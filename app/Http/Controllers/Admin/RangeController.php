<?php

namespace App\Http\Controllers\Admin;

use App\Helper\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Models\Range;
use App\Repositories\DepartmentRepository;
use App\Repositories\RangeRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RangeController extends Controller
{
    private RangeRepository $rangeRepository;
    private DepartmentRepository $departmentRepository;
    private Request $request;
    private Departments $department;

    public function __construct(Request $request, RangeRepository $rangeRepository, DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
        $this->rangeRepository = $rangeRepository;
        $this->request = $request;
        $this->department = $this->departmentRepository->getByColumn($this->request->slug, 'slug');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ranges = $this->rangeRepository->all();

        $response = [
           'data' => $ranges,
           'permissions' => Auth::user()->role->permissions,
        ];

        if ($this->request->ajax()) {
            return JsonResponse::success($response, 'Ranges fetched successfully.');
        }

        $department = $this->department;

        return view('admin.department.ranges.index', compact('department'));
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
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }
            $validated = $validator->validated();

            if (!isset($validated['status'])) {
                $validated['status'] = 0;
            }

            $this->rangeRepository->create($validated);
            DB::commit();

            return redirect()->route('admin.departments.range.index', ['slug' => $this->department->slug])->with('success', 'Range created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);

            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Range $range)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Range $range)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $slug, string $id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($this->request->all(), [
                'name' => 'required',
                'status' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }
            $validated = $validator->validated();

            if (!isset($validated['status'])) {
                $validated['status'] = 0;
            }
            $this->rangeRepository->updateById($id, $validated);
            DB::commit();

            return redirect()->route('admin.departments.range.index', ['slug' => $this->department->slug])->with('success', 'Range updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);

            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug, string $id)
    {
        try {
            DB::beginTransaction();
            $this->rangeRepository->deleteById($id);
            DB::commit();

            if ($this->request->ajax()) {
                return JsonResponse::success(null, 'Range deleted successfully.');
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);

            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
}
