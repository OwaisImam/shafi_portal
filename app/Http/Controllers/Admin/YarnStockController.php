<?php

namespace App\Http\Controllers\Admin;

use App\Helper\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Models\Dyeing;
use App\Models\Knitting;
use App\Repositories\DepartmentRepository;
use App\Repositories\DyeingRepository;
use App\Repositories\KnittingRepository;
use App\Repositories\YarnPoReceivingRepository;
use App\Repositories\YarnPurchaseOrderRepository;
use App\Repositories\YarnStockRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class YarnStockController extends Controller
{

    protected Request $request;
    protected YarnPurchaseOrderRepository $yarnPurchaseOrderRepository;
    protected YarnStockRepository $yarnStockRepository;
    protected DepartmentRepository $departmentRepository;
    protected Departments|null  $department;
    protected KnittingRepository $knittingRepository;
    protected DyeingRepository $dyeingRepository;

    public function __construct(
        Request $request,
        YarnPurchaseOrderRepository $yarnPurchaseOrderRepository,
        YarnStockRepository $yarnStockRepository,
        DepartmentRepository $departmentRepository,
        KnittingRepository $knittingRepository,
        DyeingRepository $dyeingRepository
        )
    {
        $this->request = $request;
        $this->yarnPurchaseOrderRepository = $yarnPurchaseOrderRepository;
        $this->departmentRepository = $departmentRepository;
        $this->yarnStockRepository = $yarnStockRepository;
        $this->knittingRepository = $knittingRepository;
        $this->dyeingRepository = $dyeingRepository;
        $this->department = $this->departmentRepository->getByColumn($this->request->slug, 'slug');

    }

    /**
     * Display a listing of the resource.
     */
    public function index(string $department)
    {
        $yarnstocks = $this->yarnStockRepository->with(['cartage_slip', 'parent_stock', 'yarn_purchase_order.order.client'])->get();

        $yarnstocks->map(function ($yarnstock) {
            if($yarnstock->delivery_from_type !== 'company') {

                $modelClass = ucfirst($yarnstock->delivery_from_type);

                $deliveryFrom = "App\\Models\\$modelClass"::where('id', $yarnstock->delivery_from_id)->first();

                $yarnstock->delivery_from = $deliveryFrom;
            }
                $modelClass = ucfirst($yarnstock->delivery_to_type);

                $deliveryTo = "App\\Models\\$modelClass"::where('id', $yarnstock->delivery_to_id)->first();

                return $yarnstock->delivery_to = $deliveryTo;
        });
        $response = [
           'data' => $yarnstocks,
           'permissions' => Auth::user()->role->permissions,
        ];

        if ($this->request->ajax()) {
            return JsonResponse::success($response, 'Yarn stock fetched successfully.');
        }

        $department = $this->department;
        return view('admin.department.yarn_stock.index', compact('department'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $department = $this->department;
        $yarn_po = $this->yarnPurchaseOrderRepository->getById($this->request->yarn_po_id);

        $knittingLocations = $this->knittingRepository->where('status', 1)->get();
        $dyeingLocations = $this->dyeingRepository->where('status', 1)->get();

        return view('admin.department.yarn_stock.create', compact('department', 'yarn_po', 'knittingLocations', 'dyeingLocations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($this->request->all(), [
                'yarn_purchase_order_id' => 'required|integer|exists:yarn_purchase_orders,id', // Ensure it exists in the yarn_purchase_orders table
                'delivery_from_type' => 'required|string', // Adjust options based on allowed types
                'delivery_from_id' => 'nullable|integer', // Assuming null is allowed, otherwise make it required if it shouldn't be null
                'delivery_to_type' => 'required|string', // Adjust based on your application's allowed types
                'delivery_to_id' => 'required|integer', // Assuming it references another table like destinations
                'total_qty' => 'required|numeric|min:0', // Quantity should be a non-negative number
                'received_qty' => [
                    'required',
                    'numeric',
                    'min:0',
                    function ($attribute, $value, $fail) {
                        $maxQty = $this->request->input('total_qty');
                        if (is_null($maxQty)) {
                            $fail('The total quantity (total_qty) is required.');
                        } elseif ($value > $maxQty) {
                            $fail('The received quantity cannot exceed the total quantity.');
                        }
                    },
                ],
                'remaining_qty' => 'required|numeric|min:0', // Remaining quantity should be non-negative
                'status' => 'required|string', // Define valid statuses
                'type' => 'required|string', // Define valid types
                'remarks' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }

            $validated = $validator->validated();

            $this->yarnStockRepository->create($validated);
            
            DB::commit();

            return redirect()->route('admin.departments.yarn_stock.index', ['slug' => $this->department->slug])->with('success', 'Yarn stock added successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            return JsonResponse::fail('Something went wrong.');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $department, string $id)
    {
        $yarnStock = $this->yarnStockRepository->getById($id);
        $department = $this->department;
        
        if($yarnStock->delivery_from_type !== 'company') {

            $modelClass = ucfirst($yarnStock->delivery_from_type);

            $deliveryFrom = "App\\Models\\$modelClass"::where('id', $yarnStock->delivery_from_id)->first();

            $yarnStock->delivery_from = $deliveryFrom;
        }
        
        $modelClass = ucfirst($yarnStock->delivery_to_type);

        $deliveryTo = "App\\Models\\$modelClass"::where('id', $yarnStock->delivery_to_id)->first();

        $yarnStock->delivery_to = $deliveryTo;

        return view('admin.department.yarn_stock.view', compact('yarnStock', 'department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $department, string $id)
    {
        $department = $this->department;
        $yarnStock = $this->yarnStockRepository->getById($id);
        $yarn_po = $this->yarnPurchaseOrderRepository->getById($yarnStock->yarn_purchase_order_id);
        $knittingLocations = $this->knittingRepository->where('status', 1)->get();
        $dyeingLocations = $this->dyeingRepository->where('status', 1)->get();

        return view('admin.department.yarn_stock.edit', compact('department', 'yarn_po', 'yarnStock', 'knittingLocations', 'dyeingLocations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $department, string $id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($this->request->all(), [
                'yarn_purchase_order_id' => 'required|integer|exists:yarn_purchase_orders,id', // Ensure it exists in the yarn_purchase_orders table
                'delivery_from_type' => 'required|string', // Adjust options based on allowed types
                'delivery_from_id' => 'nullable|integer', // Assuming null is allowed, otherwise make it required if it shouldn't be null
                'delivery_to_type' => 'required|string', // Adjust based on your application's allowed types
                'delivery_to_id' => 'required|integer', // Assuming it references another table like destinations
                'total_qty' => 'required|numeric|min:0', // Quantity should be a non-negative number
                'received_qty' => [
                    'required',
                    'numeric',
                    'min:0',
                    function ($attribute, $value, $fail) {
                        $maxQty = $this->request->input('total_qty');
                        if (is_null($maxQty)) {
                            $fail('The total quantity (total_qty) is required.');
                        } elseif ($value > $maxQty) {
                            $fail('The received quantity cannot exceed the total quantity.');
                        }
                    },
                ],
                'remaining_qty' => 'required|numeric|min:0', // Remaining quantity should be non-negative
                'status' => 'required|string', // Define valid statuses
                'type' => 'required|string', // Define valid types
                'remarks' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }

            $validated = $validator->validated();

            $this->yarnStockRepository->updateById($id, $validated);
            
            DB::commit();

            return redirect()->route('admin.departments.yarn_stock.index', ['slug' => $this->department->slug])->with('success', 'Yarn stock updated successfully.');
        } catch (Exception $e) {
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
        //
    }
}