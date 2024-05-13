<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Helper\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Models\SupplierItem;
use App\Repositories\CategoryRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\ItemRepository;
use App\Repositories\SupplierRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    private SupplierRepository $supplierRepository;
    private DepartmentRepository $departmentRepository;
    private CategoryRepository $categoryRepository;
    private ItemRepository $itemRepository;
    private Request $request;
    private Departments $department;

    public function __construct(
        Request $request,
        SupplierRepository $supplierRepository,
        DepartmentRepository $departmentRepository,
        ItemRepository $itemRepository,
        CategoryRepository $categoryRepository
    )
    {
        $this->departmentRepository = $departmentRepository;
        $this->supplierRepository = $supplierRepository;
        $this->itemRepository = $itemRepository;
        $this->categoryRepository = $categoryRepository;
        $this->request = $request;
        $this->department = $this->departmentRepository->getByColumn($this->request->slug, 'slug');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = $this->supplierRepository->with(['items'])->get();
        $items = $this->itemRepository->where('status', 1)->get();
        $categories = $this->categoryRepository->where('status', 1)->get();

        $response = [
           'data' => $suppliers,
           'permissions' => Auth::user()->role->permissions,
        ];

        if($this->request->ajax()) {
            return JsonResponse::success($response, 'Suppliers fetched successfully.');
        }

        $department = $this->department;

        return view('admin.department.suppliers.index', compact('department', 'items', 'categories'));
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
                  'name' => 'required|max:255',
                  'status' => 'nullable|boolean',
                  'contact_person' => 'required|max:255',
                  'contact_number' => 'required|numeric|max_digits:13',
                  'category' => 'required',
                  'items.*' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }
            $validated = $validator->validated();

            if(!isset($validated['status'])) {
                $validated['status'] = 0;
            }

            $validated['category_id'] =  $validated['category'];
            $validated['code'] = rand(1111,9999);
            $supplier = $this->supplierRepository->create($validated);

            $supplier->items()->sync($validated['items']);

            DB::commit();
            return redirect()->route('admin.departments.suppliers.index', ['slug' => $this->department->slug])->with('success', 'Supplier created successfully.');
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
    public function update(string $slug, string $id)
    {
         try {
            DB::beginTransaction();
            $validator = Validator::make($this->request->all(), [
                  'name' => 'required|max:255',
                  'status' => 'nullable|boolean',
                  'contact_person' => 'required|max:255',
                  'contact_number' => 'required|numeric|max_digits:13',
                  'category' => 'required',
                  'items.*' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }
            $validated = $validator->validated();

            if(!isset($validated['status'])) {
                $validated['status'] = 0;
            }

            $validated['category_id'] =  $validated['category'];
            $supplier = $this->supplierRepository->updateById($id, $validated);

            $supplier->items()->sync($validated['items']);

            DB::commit();
            return redirect()->route('admin.departments.suppliers.index', ['slug' => $this->department->slug])->with('success', 'Supplier updated successfully.');
        } catch(\Exception $e) {
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

            $supplier = $this->supplierRepository->getById($id);
            $supplier->items()->detach();
            $supplier->delete();
            DB::commit();
            if($this->request->ajax()) {
                return JsonResponse::success(null, 'Supplier deleted successfully.');
            }
        } catch(\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return JsonResponse::fail('Something went wrong.');
        }
    }
}