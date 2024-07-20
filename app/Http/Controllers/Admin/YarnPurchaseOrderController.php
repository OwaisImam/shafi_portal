<?php

namespace App\Http\Controllers\Admin;

use App\Helper\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Models\YarnPurchaseOrder;
use App\Repositories\AgentRepository;
use App\Repositories\ClientRepository;
use App\Repositories\CountRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\FabricConstructionRepository;
use App\Repositories\FiberRepository;
use App\Repositories\JobRepository;
use App\Repositories\MillRepository;
use App\Repositories\OrderRepository;
use App\Repositories\TermsOfDeliveryRepository;
use App\Repositories\YarnPurchaseOrderRepository;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class YarnPurchaseOrderController extends Controller
{
    private YarnPurchaseOrderRepository $yarnPurchaseOrderRepository;
    private DepartmentRepository $departmentRepository;
    private Request $request;
    private Departments|null $department;
    private FabricConstructionRepository $fabricConstructionRepository;
    private JobRepository $jobRepository;
    private ClientRepository $clientRepository;
    private OrderRepository $orderRepository;
    private TermsOfDeliveryRepository $termsOfDeliveryRepository;
    private FiberRepository $fiberRepository;
    private CountRepository $countRepository;
    private MillRepository $millRepository;
    private AgentRepository $agentRepository;

    public function __construct(
        Request $request,
        YarnPurchaseOrderRepository $yarnPurchaseOrderRepository,
        DepartmentRepository $departmentRepository,
        ClientRepository $clientRepository,
        JobRepository $jobRepository,
        FabricConstructionRepository $fabricConstructionRepository,
        OrderRepository $orderRepository,
        TermsOfDeliveryRepository $termsOfDeliveryRepository,
        FiberRepository $fiberRepository,
        CountRepository $countRepository,
        MillRepository $millRepository,
        AgentRepository $agentRepository
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->yarnPurchaseOrderRepository = $yarnPurchaseOrderRepository;
        $this->clientRepository = $clientRepository;
        $this->fabricConstructionRepository = $fabricConstructionRepository;
        $this->jobRepository = $jobRepository;
        $this->orderRepository = $orderRepository;
        $this->termsOfDeliveryRepository = $termsOfDeliveryRepository;
        $this->fiberRepository = $fiberRepository;
        $this->countRepository = $countRepository;
        $this->millRepository = $millRepository;
        $this->agentRepository = $agentRepository;
        $this->request = $request;
        $this->department = $this->departmentRepository->getByColumn($this->request->slug, 'slug');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $yarnpo = $this->yarnPurchaseOrderRepository->with([
            'job', 'receiving', 'order'
        ])->get();
        $response = [
           'data' => $yarnpo,
           'permissions' => Auth::user()->role->permissions,
        ];

        if ($this->request->ajax()) {
            return JsonResponse::success($response, 'Yarn Purchase Order fetched successfully.');
        }

        $department = $this->department;

        return view('admin.department.yarn_purchase_order.index', compact('department'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $department = $this->department;
        $jobs = $this->jobRepository->where('status', 1)->get();
        $clients = $this->clientRepository->where('status', 1)->get();
        $fabricConstructions = $this->fabricConstructionRepository->where('status', 1)->get();
        $orders = $this->orderRepository->where('status', 'Pending')->get();
        $counts = $this->countRepository->where('status', 1)->get();
        $termsOfDelivery = $this->termsOfDeliveryRepository->where('status', 1)->get();
        $fibers = $this->fiberRepository->where('status', 1)->get();
        $mills = $this->millRepository->where('status', 1)->get();
        $agents = $this->agentRepository->where('status', 1)->get();

        return view('admin.department.yarn_purchase_order.create', compact('department', 'fabricConstructions', 'termsOfDelivery', 'fibers', 'mills', 'agents', 'counts', 'jobs', 'orders', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($this->request->all(), [
                'count_id' => 'required|integer',
                'fiber_id' => 'required|integer',
                'mill_id' => 'required|integer',
                'fabric_construction_id' => 'required|integer',
                'terms_of_delivery_id' => 'required|integer',
                'agent_id' => 'required|integer',
                'lbs' => 'required|numeric',
                'kgs' => 'required|numeric',
                'qty' => 'required|numeric',
                'unit' => 'required|string',
                'price_per_lb' => 'required|numeric',
                'amount' => 'required|numeric',
                'with_gst' => 'required|numeric',
                'date_of_purchase' => 'required|string',
                'terms_of_payment' => 'required|integer',
                'contract_no' => 'required|numeric',
                'job_id' => 'required|string',
                'remarks' => 'required|string',
                'delivered' => 'required|numeric',
                'balance' => 'required|numeric',
                'delivery_date' => 'required|string',
                'completion_in' => 'required|integer',
                'order_id' => 'required|integer',
                'invoice_of' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }
            $validated = $validator->validated();

            $validated['remaining_qty'] = $validated['qty'];

            if (!isset($validated['status'])) {
                $validated['status'] = 0;
            }

            if (isset($validated['delivery_date'])) {
                $validated['delivery_date'] = Carbon::parse($validated['delivery_date']);
            }

            if (isset($validated['date_of_purchase'])) {
                $validated['date_of_purchase'] = Carbon::parse($validated['date_of_purchase']);
            }

            $this->yarnPurchaseOrderRepository->create($validated);

            $userId = auth()->id().session()->getId().$this->request->form_id;

            Redis::set('form_state:' . $userId,null);

            DB::commit();

            return redirect()->route('admin.departments.yarn_purchase_order.index', ['slug' => $this->department->slug])->with('success', 'Yarn Purchase Order created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);

            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $department, string $id)
    {
        $department = $this->department;
        $yarn_po = $this->yarnPurchaseOrderRepository->getById($id);

        return view('admin.department.yarn_purchase_order.receiving.create', compact('yarn_po', 'department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $department, string $id)
    {
        $department = $this->department;

        $yarn_po = $this->yarnPurchaseOrderRepository->getById($id);

        $jobs = $this->jobRepository->where('status', 1)->get();
        $clients = $this->clientRepository->where('status', 1)->get();
        $fabricConstructions = $this->fabricConstructionRepository->where('status', 1)->get();
        $orders = $this->orderRepository->where('status', 'Pending')->get();
        $counts = $this->countRepository->where('status', 1)->get();
        $termsOfDelivery = $this->termsOfDeliveryRepository->where('status', 1)->get();
        $fibers = $this->fiberRepository->where('status', 1)->get();
        $mills = $this->millRepository->where('status', 1)->get();
        $agents = $this->agentRepository->where('status', 1)->get();

        return view('admin.department.yarn_purchase_order.edit', compact('department', 'yarn_po', 'fabricConstructions', 'termsOfDelivery', 'fibers', 'mills', 'agents', 'counts', 'jobs', 'orders', 'clients'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $department, string $id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($this->request->all(), [
               'count_id' => 'required|integer',
                'fiber_id' => 'required|integer',
                'mill_id' => 'required|integer',
                'fabric_construction_id' => 'required|integer',
                'terms_of_delivery_id' => 'required|integer',
                'agent_id' => 'required|integer',
                'lbs' => 'required|numeric',
                'kgs' => 'required|numeric',
                'qty' => 'required|numeric',
                'unit' => 'required|string',
                'price_per_lb' => 'required|numeric',
                'amount' => 'required|numeric',
                'with_gst' => 'required|numeric',
                'date_of_purchase' => 'required|string',
                'terms_of_payment' => 'required|integer',
                'contract_no' => 'required|numeric',
                'job_id' => 'required|string',
                'remarks' => 'required|string',
                'delivered' => 'required|numeric',
                'balance' => 'required|numeric',
                'delivery_date' => 'required|string',
                'completion_in' => 'required|integer',
                'order_id' => 'required|integer',
                'invoice_of' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }
            $validated = $validator->validated();

            $validated['remaining_qty'] = $validated['qty'];

            if (!isset($validated['status'])) {
                $validated['status'] = 0;
            }

            if (isset($validated['delivery_date'])) {
                $validated['delivery_date'] = Carbon::parse($validated['delivery_date']);
            }

            if (isset($validated['date_of_purchase'])) {
                $validated['date_of_purchase'] = Carbon::parse($validated['date_of_purchase']);
            }

            $this->yarnPurchaseOrderRepository->updateById($id, $validated);
            DB::commit();

            return redirect()->route('admin.departments.yarn_purchase_order.index', ['slug' => $this->department->slug])->with('success', 'Yarn Purchase Order updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);

            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $department, string $id)
    {
        try {
            DB::beginTransaction();
            $this->yarnPurchaseOrderRepository->deleteById($id);
            DB::commit();

            if ($this->request->ajax()) {
                return JsonResponse::success(null, 'Yarn Purchase Order deleted successfully.');
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);

            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function print(YarnPurchaseOrder $yarn_po)
    {

        // Fetch data or prepare HTML content for PDF
        $data = [
            'title' => 'Sample PDF Document - ITCODSTUFF.COM',
            'content' => 'This is just a sample PDF document generated using DomPDF in Laravel.',
        ];

        // Load HTML content
        $html = view('pdfs.yarn_purchase_order', $data)->render();

        // Instantiate Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF (important step!)
        $dompdf->render();

        // Output PDF to browser
        return $dompdf->stream('document.pdf', ['Attachment' => false]);
    }
}
