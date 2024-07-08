<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Repositories\DepartmentRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProcessRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessController extends Controller
{
    private DepartmentRepository $departmentRepository;
    private Request $request;
    private ProcessRepository $processRepository;
    private Departments|null $department;

    public function __construct(
        DepartmentRepository $departmentRepository,
        OrderRepository $orderRepository,
        ProcessRepository $processRepository,
        Request $request
    ) {
        $this->request = $request;
        $this->departmentRepository = $departmentRepository;
        $this->processRepository = $processRepository;
        $this->department = $this->departmentRepository->getByColumn($this->request->slug, 'slug');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function destroy(string $department, string $id)
    {
        try {
            DB::beginTransaction();

            $this->processRepository->deleteById($id);

            DB::commit();

            return redirect()->back()->with('success', 'Pre production plan deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);

            return redirect()->back()->with('error', 'Something went wrong.');
        }

    }
}