<?php

namespace App\Http\Controllers\Admin;

use App\Helper\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Repositories\DepartmentRepository;
use App\Repositories\KnittingRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class KnittingController extends Controller
{
    private KnittingRepository $knittingRepository;
    private DepartmentRepository $departmentRepository;
    private Request $request;
    private Departments|null $department;

    public function __construct(Request $request, KnittingRepository $knittingRepository, DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
        $this->knittingRepository = $knittingRepository;
        $this->request = $request;
        $this->department = $this->departmentRepository->getByColumn($this->request->slug, 'slug');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $knitting = $this->knittingRepository->all();

        $response = [
           'data' => $knitting,
           'permissions' => Auth::user()->role->permissions,
        ];

        if ($this->request->ajax()) {
            return JsonResponse::success($response, 'Knitting fetched successfully.');
        }

        $department = $this->department;

        return view('admin.department.knitting.index', compact('department'));
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
                  'company_name' => 'required',
                  'status' => 'nullable|boolean',
                  'address' => 'required|string',
                  'contact_person' => 'required|string',
                  'contact' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }
            $validated = $validator->validated();

            if (!isset($validated['status'])) {
                $validated['status'] = 0;
            }

            $this->knittingRepository->create($validated);
            DB::commit();

            return redirect()->route('admin.departments.knitting.index', ['slug' => $this->department->slug])->with('success', 'Knitting created successfully.');
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
    public function update(string $department, string $id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($this->request->all(), [
                'company_name' => 'required',
                'status' => 'nullable|boolean',
                'address' => 'required|string',
                'contact_person' => 'required|string',
                'contact' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }
            $validated = $validator->validated();

            if (!isset($validated['status'])) {
                $validated['status'] = 0;
            }
            $this->knittingRepository->updateById($id, $validated);
            DB::commit();

            return redirect()->route('admin.departments.knitting.index', ['slug' => $this->department->slug])->with('success', 'Knitting updated successfully.');
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
            $this->knittingRepository->deleteById($id);
            DB::commit();

            if ($this->request->ajax()) {
                return JsonResponse::success(null, 'Knitting deleted successfully.');
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);

            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
}
