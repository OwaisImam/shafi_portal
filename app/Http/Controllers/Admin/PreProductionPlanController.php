<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Repositories\DepartmentRepository;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class PreProductionPlanController extends Controller
{
    private DepartmentRepository $departmentRepository;
    private Request $request;
    private OrderRepository $orderRepository;
    private Departments|null $department;

    public function __construct(DepartmentRepository $departmentRepository, OrderRepository $orderRepository, Request $request)
    {
        $this->request = $request;
        $this->departmentRepository = $departmentRepository;
        $this->orderRepository = $orderRepository;
        $this->department = $this->departmentRepository->getByColumn($this->request->slug, 'slug');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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

        return view('admin.department.pre_production_plan.create', compact('department', 'order'));
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
