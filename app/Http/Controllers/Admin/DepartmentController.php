<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Helper\JsonResponse;
use App\Http\Controllers\Controller;
use App\Repositories\DepartmentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    private DepartmentRepository $departmentRepository;
    private Request $request;

    public function __construct(Request $request, DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
        $this->request = $request;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = $this->departmentRepository->with(['logo'])->get();

        $response = [
                  'data' => $departments,
                  'permissions' => Auth::user()->role->permissions,
               ];

        if($this->request->ajax()) {
            return JsonResponse::success($response, 'Departments fetched successfully.');
        }

        return view('admin.departments.index');
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
                  'name' => 'required',
                  'status' => 'nullable|boolean',
                  'slug' => 'required|max:255',
                  'logo' => 'nullable|mimes:png,jpg,svg',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }
            if ($this->request->hasFile('logo')) {
                $logo = Helper::uploadFile($this->request->logo);
                $validated['logo_id'] = $logo->id;
            }
            unset($validated['logo']);
            if(!isset($validated['status'])) {
                $validated['status'] = 0;
            }

            $this->departmentRepository->create($validated);
            DB::commit();
            return redirect()->route('admin.departments.index')->with('success', 'Department created successfully.');
        } catch(\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return JsonResponse::fail('Something went wrong.');
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
    public function update(string $id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($this->request->all(), [
                    'name' => 'required',
                    'status' => 'nullable|boolean',
                    'slug' => 'required|max:255',
                    'logo' => 'nullable|mimes:png,jpg,svg',
            ]);

             if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }

            if ($this->request->hasFile('logo')) {
                $logo = Helper::uploadFile($this->request->logo);
                $validated['logo_id'] = $logo->id;
            }

            unset($validated['logo']);

            if(!isset($validated['status'])) {
                $validated['status'] = 0;
            }

            $this->departmentRepository->updateById($id, $validated);
            DB::commit();
            return redirect()->route('admin.departments.index')->with('success', 'Department updated successfully.');
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
            $this->departmentRepository->deleteById($id);
            DB::commit();

            if($this->request->ajax()) {
                return JsonResponse::success(null, 'Department deleted successfully.');
            }
        } catch(\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return JsonResponse::fail('Something went wrong.');
        }
    }

    public function dashboard($slug)
    {
        // Fetch department data based on slug
        $department = $this->departmentRepository->getByColumn($slug, 'slug');

        // Pass department data to the view
        return view('admin.department.dashboard', ['department' => $department]);
    }
}