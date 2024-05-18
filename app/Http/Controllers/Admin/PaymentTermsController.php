<?php

namespace App\Http\Controllers\Admin;

use App\Helper\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Models\PaymentTerms;
use App\Repositories\DepartmentRepository;
use App\Repositories\PaymentTermsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PaymentTermsController extends Controller
{
    private PaymentTermsRepository $paymentTermsRepository;
    private DepartmentRepository $departmentRepository;
    private Request $request;
    private Departments $department;

    public function __construct(Request $request, PaymentTermsRepository $paymentTermsRepository, DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
        $this->paymentTermsRepository = $paymentTermsRepository;
        $this->request = $request;
        $this->department = $this->departmentRepository->getByColumn($this->request->slug, 'slug');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fabricConstruction = $this->paymentTermsRepository->all();

        $response = [
           'data' => $fabricConstruction,
           'permissions' => Auth::user()->role->permissions,
        ];

        if($this->request->ajax()) {
            return JsonResponse::success($response, 'Payment terms fetched successfully.');
        }

        $department = $this->department;

        return view('admin.department.payment_terms.index', compact('department'));
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

            if(!isset($validated['status'])) {
                $validated['status'] = 0;
            }

            $this->paymentTermsRepository->create($validated);
            DB::commit();
            return redirect()->route('admin.departments.payment_terms.index', ['slug' => $this->department->slug])->with('success', 'Payment terms created successfully.');
        } catch(\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
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

            if(!isset($validated['status'])) {
                $validated['status'] = 0;
            }
            $this->paymentTermsRepository->updateById($id, $validated);
            DB::commit();
            return redirect()->route('admin.departments.payment_terms.index', ['slug' => $this->department->slug])->with('success', 'Payment terms  updated successfully.');
        } catch(\Exception $e) {
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
            $this->paymentTermsRepository->deleteById($id);
            DB::commit();

            if($this->request->ajax()) {
                return JsonResponse::success(null, 'Payment terms deleted successfully.');
            }
        } catch(\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
}
