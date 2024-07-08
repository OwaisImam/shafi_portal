<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Repositories\DepartmentRepository;
use App\Repositories\YarnPoReceivingRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class YarnPoReceivingController extends Controller
{

    protected Request $request;
    protected YarnPoReceivingRepository $yarnPoReceivingRepository;
    protected DepartmentRepository $departmentRepository;
    protected Departments|null  $department;

    public function __construct(
        Request $request,
        YarnPoReceivingRepository $yarnPoReceivingRepository,
        DepartmentRepository $departmentRepository)
    {
        $this->request = $request;
        $this->yarnPoReceivingRepository = $yarnPoReceivingRepository;
        $this->departmentRepository = $departmentRepository;
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
    public function store()
    {
         try {
            DB::beginTransaction();

            $validator = Validator::make($this->request->all(), [
                  'yarn_po_id' => 'required|integer',
                  'received_qty' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }

            $validated = $validator->validated();

            $validated['received_by'] = Auth::user()->id;

            $receiving = $this->yarnPoReceivingRepository->create($validated);

            $receiving->yarn_po()->update(['status' => 1]);

            DB::commit();

            return redirect()->route('admin.departments.yarn_purchase_order.index', ['slug' => $this->department->slug])->with('success', 'Yarn receiving created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);

            return redirect()->back()->with('error', 'Something went wrong.');
        }
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