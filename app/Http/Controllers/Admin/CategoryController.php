<?php

namespace App\Http\Controllers\Admin;

use App\Helper\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Repositories\CategoryRepository;
use App\Repositories\DepartmentRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    private CategoryRepository $categoryRepository;
    private DepartmentRepository $departmentRepository;
    private Request $request;
    private Departments $department;

    public function __construct(Request $request, CategoryRepository $categoryRepository, DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
        $this->categoryRepository = $categoryRepository;
        $this->request = $request;
        $this->department = $this->departmentRepository->getByColumn($this->request->slug, 'slug');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = $this->categoryRepository->all();

        $response = [
           'data' => $items,
           'permissions' => Auth::user()->role->permissions,
        ];

        if ($this->request->ajax()) {
            return JsonResponse::success($response, 'Category fetched successfully.');
        }

        $department = $this->department;

        return view('admin.department.category.index', compact('department'));
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

            $this->categoryRepository->create($validated);
            DB::commit();

            return redirect()->route('admin.departments.category.index', ['slug' => $this->department->slug])->with('success', 'Item created successfully.');
        } catch (Exception $e) {
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
    public function update(string $string, string $id)
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
            $this->categoryRepository->updateById($id, $validated);
            DB::commit();

            return redirect()->route('admin.departments.category.index', ['slug' => $this->department->slug])->with('success', 'Item updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);

            return JsonResponse::fail('Something went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug, string $id)
    {
        try {
            DB::beginTransaction();
            $this->categoryRepository->deleteById($id);
            DB::commit();

            if ($this->request->ajax()) {
                return JsonResponse::success(null, 'Category deleted successfully.');
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);

            return JsonResponse::fail('Something went wrong.');
        }
    }
}
