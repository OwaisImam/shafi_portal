<?php

namespace App\Http\Controllers\Admin;

use App\Helper\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Repositories\DepartmentRepository;
use App\Repositories\DyeingRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DyeingController extends Controller
{
    private DyeingRepository $dyeingRepository;
    private DepartmentRepository $departmentRepository;
    private Request $request;
    private Departments|null $department;

    public function __construct(Request $request, DyeingRepository $dyeingRepository, DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
        $this->dyeingRepository = $dyeingRepository;
        $this->request = $request;
        $this->department = $this->departmentRepository->getByColumn($this->request->slug, 'slug');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fibers = $this->dyeingRepository->all();

        $response = [
           'data' => $fibers,
           'permissions' => Auth::user()->role->permissions,
        ];

        if ($this->request->ajax()) {
            return JsonResponse::success($response, 'Dyeing fetched successfully.');
        }

        $department = $this->department;

        return view('admin.department.dyeing.index', compact('department'));
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

            $this->dyeingRepository->create($validated);
            DB::commit();

            return redirect()->route('admin.departments.dyeing.index', ['slug' => $this->department->slug])->with('success', 'Dyeing created successfully.');
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
            $this->dyeingRepository->updateById($id, $validated);
            DB::commit();

            return redirect()->route('admin.departments.dyeing.index', ['slug' => $this->department->slug])->with('success', 'Dyeing updated successfully.');
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
            $this->dyeingRepository->deleteById($id);
            DB::commit();

            if ($this->request->ajax()) {
                return JsonResponse::success(null, 'Dyeing deleted successfully.');
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);

            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
}
