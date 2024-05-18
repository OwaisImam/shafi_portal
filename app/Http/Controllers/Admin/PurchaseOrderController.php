<?php

namespace App\Http\Controllers\Admin;

use App\Helper\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Repositories\CategoryRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\PurchaseOrderRepository;
use App\Repositories\SupplierRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseOrderController extends Controller
{

    private SupplierRepository $supplierRepository;
    private DepartmentRepository $departmentRepository;
    private CategoryRepository $categoryRepository;
    private PurchaseOrderRepository $purchaseOrderRepository;
    private Request $request;
    private Departments $department;

    public function __construct(
        Request $request,
        SupplierRepository $supplierRepository,
        DepartmentRepository $departmentRepository,
        PurchaseOrderRepository $purchaseOrderRepository,
        CategoryRepository $categoryRepository
    )
    {
        $this->departmentRepository = $departmentRepository;
        $this->supplierRepository = $supplierRepository;
        $this->purchaseOrderRepository = $purchaseOrderRepository;
        $this->categoryRepository = $categoryRepository;
        $this->request = $request;
        $this->department = $this->departmentRepository->getByColumn($this->request->slug, 'slug');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = $this->purchaseOrderRepository->all();

        $response = [
           'data' => $items,
           'permissions' => Auth::user()->role->permissions,
        ];

        if($this->request->ajax()) {
            return JsonResponse::success($response, 'Purchase Orders fetched successfully.');
        }

        $department = $this->department;

        return view('admin.department.purchase_orders.index', compact('department'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $department = $this->department;
        return view('admin.department.purchase_orders.create', compact('department'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}