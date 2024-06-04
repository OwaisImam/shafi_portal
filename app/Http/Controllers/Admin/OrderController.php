<?php

namespace App\Http\Controllers\Admin;

use App\Helper\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Models\Order;
use App\Repositories\ArticleStyleRepository;
use App\Repositories\ClientRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\FabricConstructionRepository;
use App\Repositories\ItemRepository;
use App\Repositories\JobRepository;
use App\Repositories\OrderItemRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PaymentTermsRepository;
use App\Repositories\RangeRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    private OrderRepository $orderRepository;
    private OrderItemRepository $orderItemRepository;
    private DepartmentRepository $departmentRepository;
    private Request $request;
    private FabricConstructionRepository $fabricConstructionRepository;
    private ClientRepository $clientRepository;
    private RangeRepository $rangeRepository;
    private Departments|null $department;
    private PaymentTermsRepository $paymentTermsRepository;
    private JobRepository $jobRepository;
    private ItemRepository $itemRepository;
    private ArticleStyleRepository $articleStyleRepository;

    public function __construct(
        Request $request,
        OrderRepository $orderRepository,
        DepartmentRepository $departmentRepository,
        RangeRepository $rangeRepository,
        FabricConstructionRepository $fabricConstructionRepository,
        PaymentTermsRepository $paymentTermsRepository,
        ClientRepository $clientRepository,
        JobRepository $jobRepository,
        ItemRepository $itemRepository,
        OrderItemRepository $orderItemRepository,
        ArticleStyleRepository $articleStyleRepository
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->orderRepository = $orderRepository;
        $this->itemRepository = $itemRepository;
        $this->articleStyleRepository = $articleStyleRepository;
        $this->rangeRepository = $rangeRepository;
        $this->fabricConstructionRepository = $fabricConstructionRepository;
        $this->paymentTermsRepository = $paymentTermsRepository;
        $this->clientRepository = $clientRepository;
        $this->jobRepository = $jobRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->request = $request;
        $this->department = $this->departmentRepository->getByColumn($this->request->slug, 'slug');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = $this->orderRepository->with(['client'])->get();

        $response = [
           'data' => $items,
           'permissions' => Auth::user()->role->permissions,
        ];

        if ($this->request->ajax()) {
            return JsonResponse::success($response, 'Orders fetched successfully.');
        }

        $department = $this->department;

        return view('admin.department.orders.index', compact('department'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $department = $this->department;
        $ranges = $this->rangeRepository->where('status', 1)->get();
        $paymentTerms = $this->paymentTermsRepository->where('status', 1)->get();
        $clients = $this->clientRepository->where('status', 1)->get();
        $fabricConstructions = $this->fabricConstructionRepository->where('status', 1)->get();
        $jobs = $this->jobRepository->where('status', 1)->get();
        $articleStyles = $this->articleStyleRepository->where('status', 1)->get();

        return view('admin.department.orders.create', compact('department', 'ranges', 'clients', 'articleStyles', 'jobs', 'paymentTerms', 'fabricConstructions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make(
                $this->request->all(),
                [
                'customer_po_number' => 'required|string|max:255',
                'job_id' => 'required|integer|exists:p_jobs,id',
                'customer_id' => 'required|integer|exists:clients,id',
                'po_receive_date' => 'required|date',
                'delivery_date' => 'required|date|after_or_equal:po_receive_date',
                'payment_term_id' => 'required|integer|exists:payment_terms,id',
                'range_id' => 'required|integer|exists:ranges,id',
                'fabric_construction_id' => 'required|integer|exists:fabric_constructions,id',
                'gsm' => 'required|integer|min:1',
                'order_quantity' => 'required|integer|min:1',
                'group-a.*.article_style_no' => 'required|string|max:255',
                'group-a.*.article_style_id' => 'required|integer|exists:article_styles,id',
                'group-a.*.description' => 'required|string|max:255',
                'group-a.*.size' => 'required|array',
                'group-a.*.size.*' => 'required|string|max:255', // Adjust as per your size validation needs
                'group-a.*.color' => 'required|string|max:7', // Assuming it's a hex code for the color
                'group-a.*.qty' => 'required|integer|min:1',
                'group-a.*.unit' => 'required|string|max:255',
            ],
                [
                'customer_po_number.required' => 'The customer PO number is required.',
                'job_id.required' => 'The job ID is required.',
                'customer_id.required' => 'The customer ID is required.',
                'po_receive_date.required' => 'The PO receive date is required.',
                'delivery_date.required' => 'The delivery date is required.',
                'delivery_date.after_or_equal' => 'The delivery date must be after or equal to the PO receive date.',
                'payment_term_id.required' => 'The payment term ID is required.',
                'range_id.required' => 'The range ID is required.',
                'fabric_construction_id.required' => 'The fabric construction ID is required.',
                'gsm.required' => 'The GSM is required.',
                'order_quantity.required' => 'The order quantity is required.',
                'group-a.*.article_style_no.required' => 'The article style number is required.',
                'group-a.*.article_style_id.required' => 'The article style ID is required.',
                'group-a.*.description.required' => 'The description is required.',
                'group-a.*.size.required' => 'The size is required.',
                'group-a.*.color.required' => 'The color is required.',
                'group-a.*.qty.required' => 'The quantity is required.',
                'group-a.*.unit.required' => 'The unit is required.',
            ]
            );

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }

            $validated = $validator->validated();
            $validated['article_style_count'] = count($validated['group-a']);

            $customer = $this->clientRepository->getById($validated['customer_id']);

            $validated['code'] = $customer->name[0] . '-' . Carbon::now()->format('dmY');

            $orderData['order_items'] = $validated['group-a'];
            unset($validated['group-a']);

            $order = $this->orderRepository->create($validated);

            foreach ($orderData['order_items'] as $item) {
                $item['order_id'] = $order->id;
                $item['sizes'] = json_encode($item['size']);
                $this->orderItemRepository->create($item);
            }

            DB::commit();

            return redirect()->route('admin.departments.orders.index', ['slug' => $this->department->slug])->with('success', 'Order created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);

            return JsonResponse::fail('Something went wrong.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $department, string $id)
    {
        $department = $this->department;
        $ranges = $this->rangeRepository->where('status', 1)->get();
        $paymentTerms = $this->paymentTermsRepository->where('status', 1)->get();
        $clients = $this->clientRepository->where('status', 1)->get();
        $fabricConstructions = $this->fabricConstructionRepository->where('status', 1)->get();
        $jobs = $this->jobRepository->where('status', 1)->get();
        $order = $this->orderRepository->getById($id);
        $articleStyles = $this->articleStyleRepository->where('status', 1)->get();

        return view('admin.department.orders.edit', compact('department', 'ranges', 'order', 'clients', 'articleStyles', 'jobs', 'paymentTerms', 'fabricConstructions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $department, string $id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make(
                $this->request->all(),
                [
                'customer_po_number' => 'required|string|max:255',
                'job_id' => 'required|integer|exists:p_jobs,id',
                'customer_id' => 'required|integer|exists:clients,id',
                'po_receive_date' => 'required|date',
                'delivery_date' => 'required|date|after_or_equal:po_receive_date',
                'payment_term_id' => 'required|integer|exists:payment_terms,id',
                'range_id' => 'required|integer|exists:ranges,id',
                'fabric_construction_id' => 'required|integer|exists:fabric_constructions,id',
                'gsm' => 'required|integer|min:1',
                'order_quantity' => 'required|integer|min:1',
                'group-a.*.article_style_no' => 'required|string|max:255',
                'group-a.*.article_style_id' => 'required|integer|exists:article_styles,id',
                'group-a.*.description' => 'required|string|max:255',
                'group-a.*.size' => 'required|array',
                'group-a.*.size.*' => 'required|string|max:255', // Adjust as per your size validation needs
                'group-a.*.color' => 'required|string|max:7', // Assuming it's a hex code for the color
                'group-a.*.qty' => 'required|integer|min:1',
                'group-a.*.unit' => 'required|string|max:255',
                'group-a.*.order_item_id' => 'required',
            ],
                [
                'customer_po_number.required' => 'The customer PO number is required.',
                'job_id.required' => 'The job ID is required.',
                'customer_id.required' => 'The customer ID is required.',
                'po_receive_date.required' => 'The PO receive date is required.',
                'delivery_date.required' => 'The delivery date is required.',
                'delivery_date.after_or_equal' => 'The delivery date must be after or equal to the PO receive date.',
                'payment_term_id.required' => 'The payment term ID is required.',
                'range_id.required' => 'The range ID is required.',
                'fabric_construction_id.required' => 'The fabric construction ID is required.',
                'gsm.required' => 'The GSM is required.',
                'order_quantity.required' => 'The order quantity is required.',
                'group-a.*.article_style_no.required' => 'The article style number is required.',
                'group-a.*.article_style_id.required' => 'The article style ID is required.',
                'group-a.*.description.required' => 'The description is required.',
                'group-a.*.size.required' => 'The size is required.',
                'group-a.*.color.required' => 'The color is required.',
                'group-a.*.qty.required' => 'The quantity is required.',
                'group-a.*.unit.required' => 'The unit is required.',
            ]
            );

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }

            $validated = $validator->validated();
            $validated['article_style_count'] = count($validated['group-a']);

            $orderData['order_items'] = $validated['group-a'];
            unset($validated['group-a']);

            $this->orderRepository->updateById($id, $validated);

            foreach ($orderData['order_items'] as $item) {
                $item['sizes'] = json_encode($item['size']);
                $this->orderItemRepository->updateById($item['order_item_id'], $item);
            }

            DB::commit();

            return redirect()->route('admin.departments.orders.index', ['slug' => $this->department->slug])->with('success', 'Order updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);

            return JsonResponse::fail('Something went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $department, string $id)
    {
        try {
            DB::beginTransaction();
            $order = $this->orderRepository->getById($id);
            $order->order_items()->delete();
            $order->delete();
            DB::commit();

            if ($this->request->ajax()) {
                return JsonResponse::success(null, 'Order deleted successfully.');
            }
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            Log::error($e);

            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
}
