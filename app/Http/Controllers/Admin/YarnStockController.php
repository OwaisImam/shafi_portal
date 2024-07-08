<?php

namespace App\Http\Controllers\Admin;

use App\Helper\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Repositories\DepartmentRepository;
use App\Repositories\YarnPoReceivingRepository;
use App\Repositories\YarnPurchaseOrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class YarnStockController extends Controller
{

    protected Request $request;
    protected YarnPurchaseOrderRepository $yarnPurchaseOrderRepository;
    protected DepartmentRepository $departmentRepository;
    protected Departments|null  $department;

    public function __construct(
        Request $request,
        YarnPurchaseOrderRepository $yarnPurchaseOrderRepository,
        DepartmentRepository $departmentRepository)
    {
        $this->request = $request;
        $this->yarnPurchaseOrderRepository = $yarnPurchaseOrderRepository;
        $this->departmentRepository = $departmentRepository;
        $this->department = $this->departmentRepository->getByColumn($this->request->slug, 'slug');

    }

    /**
     * Display a listing of the resource.
     */
    public function index(string $department)
    {
        $yarnpo = $this->yarnPurchaseOrderRepository->getYarnPOWhereHasReceiving();
        $response = [
           'data' => $yarnpo,
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
        //
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