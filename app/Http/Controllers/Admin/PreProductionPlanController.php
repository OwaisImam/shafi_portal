<?php

namespace App\Http\Controllers\Admin;

use App\Helper\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Repositories\DepartmentRepository;
use App\Repositories\ItemRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PreProductionPlanAccessoriesRepository;
use App\Repositories\PreProductionPlanProcessRepository;
use App\Repositories\PreProductionPlanRepository;
use App\Repositories\PreProductionPlanYarnRepository;
use App\Repositories\ProcessRepository;
use App\Repositories\YarnPurchaseOrderRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PreProductionPlanController extends Controller
{
    private DepartmentRepository $departmentRepository;
    private Request $request;
    private OrderRepository $orderRepository;
    private ProcessRepository $processRepository;
    private YarnPurchaseOrderRepository $yarnPurchaseOrderRepository;
    private ItemRepository $itemRepository;
    private PreProductionPlanRepository $preProductionPlanRepository;
    private PreProductionPlanYarnRepository $preProductionPlanYarnRepository;
    private PreProductionPlanProcessRepository $preProductionPlanProcessRepository;
    private PreProductionPlanAccessoriesRepository $preProductionPlanAccessoriesRepository;
    private Departments|null $department;

    public function __construct(
        DepartmentRepository $departmentRepository,
        OrderRepository $orderRepository,
        ProcessRepository $processRepository,
        ItemRepository $itemRepository,
        YarnPurchaseOrderRepository $yarnPurchaseOrderRepository,
        PreProductionPlanYarnRepository $preProductionPlanYarnRepository,
        PreProductionPlanRepository $preProductionPlanRepository,
        PreProductionPlanProcessRepository $preProductionPlanProcessRepository,
        PreProductionPlanAccessoriesRepository $preProductionPlanAccessoriesRepository,
        Request $request
    ) {
        $this->request = $request;
        $this->departmentRepository = $departmentRepository;
        $this->orderRepository = $orderRepository;
        $this->processRepository = $processRepository;
        $this->itemRepository = $itemRepository;
        $this->preProductionPlanRepository = $preProductionPlanRepository;
        $this->yarnPurchaseOrderRepository = $yarnPurchaseOrderRepository;
        $this->preProductionPlanProcessRepository = $preProductionPlanProcessRepository;
        $this->preProductionPlanYarnRepository = $preProductionPlanYarnRepository;
        $this->preProductionPlanAccessoriesRepository = $preProductionPlanAccessoriesRepository;
        $this->department = $this->departmentRepository->getByColumn($this->request->slug, 'slug');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = $this->preProductionPlanRepository->with(['order.job', 'accessories', 'processes', 'yarn_purchase_orders'])->get();

        $response = [
           'data' => $items,
           'permissions' => Auth::user()->role->permissions,
        ];

        if ($this->request->ajax()) {
            return JsonResponse::success($response, 'Pre production plans fetched successfully.');
        }

        $department = $this->department;

        return view('admin.department.pre_production_plan.index', compact('department'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $department = $this->department;
        $order = $this->orderRepository->getById($this->request->order_id);
        $yarn_purchase_orders = $this->yarnPurchaseOrderRepository->where('job_id', $order->job_id)->get();
        $processes = $this->processRepository->where('status', 1)->where('parent_id', null)->where('is_default', 1)->get();
        $items = $this->itemRepository->where('status', 1)->get();

        return view('admin.department.pre_production_plan.create', compact('department', 'items', 'processes', 'yarn_purchase_orders', 'order'));
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
                    'order_id' => 'required|integer',
                    'yarn_purchase_order' => 'required|array',
                    'yarn_purchase_order.*.id' => 'required|integer',
                    'yarn_purchase_order.*.qty' => 'required|numeric',
                    'yarn_purchase_order.*.kgs' => 'required|numeric',
                    'yarn_purchase_order.*.percentage' => 'required|numeric',
                    'yarn_purchase_order.*.balance' => 'required|numeric',
                    'processes' => 'required|array',
                    'processes.*.id' => 'nullable',
                    'processes.*.parent_process_id' => 'nullable|integer',
                    'processes.*.notes' => 'nullable|string',
                    'processes.*.name' => 'nullable|string',
                    'accessories' => 'required|array',
                    'accessories.*.item_id' => 'required|integer',
                    'accessories.*.qty' => 'required|numeric',
                    'accessories.*.notes' => 'nullable|string',
               ]
            );

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }

            $validated = $validator->validated();

            $preProductionPlan = $this->preProductionPlanRepository->create(
                [
                    'order_id' => $validated['order_id'],
                    'status' => 1,
                ]
            );

            foreach ($validated['yarn_purchase_order'] as $yarn) {

                $this->preProductionPlanYarnRepository->create(
                    [
                        'yarn_purchase_order_id' => $yarn['id'],
                        'qty' => $yarn['qty'],
                        'kgs' =>$yarn['kgs'],
                        'percentage' =>  $yarn['percentage'],
                        'pre_production_plan_id' => $preProductionPlan->id,
                    ]
                );

                $this->yarnPurchaseOrderRepository->updateById($yarn['id'], ['remaining_qty' => $yarn['balance']]);
            }

            foreach ($validated['processes'] as $processes) {

                if (isset($processes['id']) && $processes['id'] != 'on') {
                    if ($processes['parent_process_id'] == null) {

                        $processData = [
                            'process_id' => $processes['id'],
                            'notes' => $processes['notes'],
                            'pre_production_plan_id' => $preProductionPlan->id,
                        ];

                        $this->preProductionPlanProcessRepository->create($processData);
                    } elseif ($processes['parent_process_id'] != null) {
                        $process = $this->processRepository->create([
                            'name' => $processes['name'],
                            'parent_id' => $processes['parent_process_id'],
                            'pre_production_plan_id' => $preProductionPlan->id,
                            'is_default' => 0,
                            'status' => 1,
                        ]);

                        $processData = [
                            'process_id' => $process->id,
                            'notes' => $processes['notes'],
                            'pre_production_plan_id' => $preProductionPlan->id,
                        ];
                        $this->preProductionPlanProcessRepository->create($processData);

                    }
                } elseif ($processes['id'] == 'on') {

                    $process = $this->processRepository->create([
                        'name' => $processes['name'],
                        'parent_id' => $processes['parent_process_id'],
                        'pre_production_plan_id' => $preProductionPlan->id,
                        'is_default' => 0,
                        'status' => 1,
                    ]);

                    $processData = [
                        'process_id' => $process->id,
                        'notes' => $processes['notes'],
                        'pre_production_plan_id' => $preProductionPlan->id,
                    ];

                    $this->preProductionPlanProcessRepository->create($processData);
                }

            }

            foreach ($validated['accessories'] as $accessories) {
                $this->preProductionPlanAccessoriesRepository->create([
                   'pre_production_plan_id' => $preProductionPlan->id,
                   'item_id' => $accessories['item_id'],
                   'qty' => $accessories['qty'],
                   'notes' => $accessories['notes'],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.departments.pre_production_plans.index', ['slug' => $this->department->slug])->with('success', 'Pre production plan created successfully.');
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
        $preProductionPlan = $this->preProductionPlanRepository->getById($id);

        return view('admin.department.pre_production_plan.view', compact('department', 'preProductionPlan'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $department, string $id)
    {

        $department = $this->department;
        $order = $this->orderRepository->getById($this->request->order_id);
        $yarn_purchase_orders = $this->yarnPurchaseOrderRepository->where('job_id', $order->job_id)->get();
        $processes = $this->processRepository->getProcessesByPreProductionPlan($id);
        $items = $this->itemRepository->where('status', 1)->get();
        $preProductionPlan = $this->preProductionPlanRepository->getById($id);

        return view('admin.department.pre_production_plan.edit', compact('department', 'items', 'preProductionPlan', 'processes', 'yarn_purchase_orders', 'order'));

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
                    'order_id' => 'required|integer',
                    'yarn_purchase_order' => 'required|array',
                    'yarn_purchase_order.*.id' => 'required|integer',
                    'yarn_purchase_order.*.qty' => 'required|numeric',
                    'yarn_purchase_order.*.kgs' => 'required|numeric',
                    'yarn_purchase_order.*.percentage' => 'required|numeric',
                    'yarn_purchase_order.*.balance' => 'required|numeric',
                    'processes' => 'required|array',
                    'processes.*.id' => 'nullable',
                    'processes.*.parent_process_id' => 'nullable|integer',
                    'processes.*.notes' => 'nullable|string',
                    'processes.*.name' => 'nullable|string',
                    'accessories' => 'required|array',
                    'accessories.*.item_id' => 'required|integer',
                    'accessories.*.qty' => 'required|numeric',
                    'accessories.*.notes' => 'nullable|string',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }

            $validated = $validator->validated();

            $preProductionPlan = $this->preProductionPlanRepository->getById($id);

            $preProductionPlan->accessories()->delete();
            $preProductionPlan->processes()->delete();
            $preProductionPlan->yarn_purchase_orders()->delete();

            foreach ($validated['yarn_purchase_order'] as $yarn) {

                $this->preProductionPlanYarnRepository->create(
                    [
                        'yarn_purchase_order_id' => $yarn['id'],
                        'qty' => $yarn['qty'],
                        'kgs' =>$yarn['kgs'],
                        'percentage' =>  $yarn['percentage'],
                        'pre_production_plan_id' => $preProductionPlan->id,
                    ]
                );

                $this->yarnPurchaseOrderRepository->updateById($yarn['id'], ['remaining_qty' => $yarn['balance']]);
            }

            foreach ($validated['processes'] as $processes) {

                if (isset($processes['id']) && $processes['id'] != 'on') {
                    if ($processes['parent_process_id'] == null) {

                        $processData = [
                            'process_id' => $processes['id'],
                            'notes' => $processes['notes'],
                            'pre_production_plan_id' => $preProductionPlan->id,
                        ];

                        $this->preProductionPlanProcessRepository->create($processData);
                    } elseif ($processes['parent_process_id'] != null) {
                        $process = $this->processRepository->create([
                            'name' => $processes['name'],
                            'parent_id' => $processes['parent_process_id'],
                            'pre_production_plan_id' => $preProductionPlan->id,
                            'is_default' => 0,
                            'status' => 1,
                        ]);

                        $processData = [
                            'process_id' => $process->id,
                            'notes' => $processes['notes'],
                            'pre_production_plan_id' => $preProductionPlan->id,
                        ];
                        $this->preProductionPlanProcessRepository->create($processData);

                    }
                } elseif (isset($processes['id']) && $processes['id'] == 'on') {

                    $process = $this->processRepository->create([
                        'name' => $processes['name'],
                        'parent_id' => $processes['parent_process_id'],
                        'pre_production_plan_id' => $preProductionPlan->id,
                        'is_default' => 0,
                        'status' => 1,
                    ]);

                    $processData = [
                        'process_id' => $process->id,
                        'notes' => $processes['notes'],
                        'pre_production_plan_id' => $preProductionPlan->id,
                    ];

                    $this->preProductionPlanProcessRepository->create($processData);
                }

            }

            foreach ($validated['accessories'] as $accessories) {
                $this->preProductionPlanAccessoriesRepository->create([
                   'pre_production_plan_id' => $preProductionPlan->id,
                   'item_id' => $accessories['item_id'],
                   'qty' => $accessories['qty'],
                   'notes' => $accessories['notes'],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.departments.pre_production_plans.index', ['slug' => $this->department->slug])->with('success', 'Pre production plan created successfully.');
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

            $preProductionPlan = $this->preProductionPlanRepository->getById($id);

            $preProductionPlan->accessories()->delete();
            $preProductionPlan->processes()->delete();
            $preProductionPlan->yarn_purchase_orders()->delete();

            $preProductionPlan->delete();

            DB::commit();

            if ($this->request->ajax()) {
                return JsonResponse::success(null, 'Pre production plan deleted successfully.');
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);

            return redirect()->back()->with('error', 'Something went wrong.');
        }

    }
}