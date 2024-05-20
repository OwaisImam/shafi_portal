<?php

namespace App\Http\Controllers\Admin;

use App\Helper\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Models\Order;
use App\Repositories\ClientRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\FabricConstructionRepository;
use App\Repositories\ItemRepository;
use App\Repositories\JobRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PaymentTermsRepository;
use App\Repositories\RangeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    private OrderRepository $orderRepository;
    private DepartmentRepository $departmentRepository;
    private Request $request;
    private FabricConstructionRepository $fabricConstructionRepository;
    private ClientRepository $clientRepository;
    private RangeRepository $rangeRepository;
    private Departments $department;
    private PaymentTermsRepository $paymentTermsRepository;
    private JobRepository $jobRepository;
    private ItemRepository $itemRepository;

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
        )
    {
        $this->departmentRepository = $departmentRepository;
        $this->orderRepository = $orderRepository;
        $this->itemRepository = $itemRepository;
        $this->rangeRepository = $rangeRepository;
        $this->fabricConstructionRepository = $fabricConstructionRepository;
        $this->paymentTermsRepository = $paymentTermsRepository;
        $this->clientRepository = $clientRepository;
        $this->jobRepository = $jobRepository;
        $this->request = $request;
        $this->department = $this->departmentRepository->getByColumn($this->request->slug, 'slug');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = $this->orderRepository->all();

        $response = [
           'data' => $items,
           'permissions' => Auth::user()->role->permissions,
        ];

        if($this->request->ajax()) {
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
        $fabricConstruction = $this->fabricConstructionRepository->where('status', 1)->get();
        $jobs = $this->jobRepository->where('status', 1)->get();
        $items = $this->itemRepository->where('status', 1)->get();

        return view('admin.department.orders.create', compact('department', 'ranges', 'clients', 'items', 'jobs', 'paymentTerms', 'fabricConstruction'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($this->request->all(), [
                  'name' => 'required',
                  'status' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }
            $validated = $validator->validated();

            if(!isset($validated['status'])) {
                $validated['status'] = 0;
            }

            $this->orderRepository->create($validated);
            DB::commit();
            return redirect()->route('admin.departments.orders.index', ['slug' => $this->department->slug])->with('success', 'Order created successfully.');
        } catch(\Exception $e) {
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
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $department, string $id)
    {
           try {
            DB::beginTransaction();
            $validator = Validator::make($this->request->all(), [
                'name' => 'required',
                'status' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }
            $validated = $validator->validated();
            if(!isset($validated['status'])) {
                $validated['status'] = 0;
            }
            $this->orderRepository->updateById($id, $validated);
            DB::commit();
            return redirect()->route('admin.departments.orders.index', ['slug' => $this->department->slug])->with('success', 'Item updated successfully.');
        } catch(\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return JsonResponse::fail('Something went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $this->orderRepository->deleteById($id);
            DB::commit();

            if($this->request->ajax()) {
                return JsonResponse::success(null, 'Order deleted successfully.');
            }
        } catch(\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
}