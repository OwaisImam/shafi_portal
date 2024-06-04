<?php

namespace App\Http\Controllers\Admin;

use App\Helper\JsonResponse;
use App\Http\Controllers\Controller;
use App\Imports\ItemImport;
use App\Models\Departments;
use App\Repositories\DepartmentRepository;
use App\Repositories\ItemRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ItemController extends Controller
{
    private ItemRepository $itemRepository;
    private DepartmentRepository $departmentRepository;
    private Request $request;
    private Departments|null $department;

    public function __construct(Request $request, ItemRepository $itemRepository, DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
        $this->itemRepository = $itemRepository;
        $this->request = $request;
        $this->department = $this->departmentRepository->getByColumn($this->request->slug, 'slug');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = $this->itemRepository->all();

        $response = [
           'data' => $items,
           'permissions' => Auth::user()->role->permissions,
        ];

        if ($this->request->ajax()) {
            return JsonResponse::success($response, 'Items fetched successfully.');
        }

        $department = $this->department;

        return view('admin.department.items.index', compact('department'));
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

            $this->itemRepository->create($validated);
            DB::commit();

            return redirect()->route('admin.departments.items.index', ['slug' => $this->department->slug])->with('success', 'Item created successfully.');
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
            $this->itemRepository->updateById($id, $validated);
            DB::commit();

            return redirect()->route('admin.departments.items.index', ['slug' => $this->department->slug])->with('success', 'Item updated successfully.');
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

            $this->itemRepository->deleteById($id);

            DB::commit();

            if ($this->request->ajax()) {
                return JsonResponse::success(null, 'Item deleted successfully.');
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);

            return JsonResponse::fail('Something went wrong.');
        }

    }

    public function bulkUpload()
    {
        try {
            DB::beginTransaction();

            $this->request->validate([
                'file' => 'required|mimes:xlsx,xls',
            ]);

            // Get the uploaded file
            $file = $this->request->file('file');

            // Process the Excel file
            Excel::import(new ItemImport, $file);

            DB::commit();

            return redirect()->route('admin.departments.items.index', ['slug' => $this->department->slug])->with('success', 'Items uploaded successfully.');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);

            return JsonResponse::fail('Something went wrong.');
        }

    }
}
