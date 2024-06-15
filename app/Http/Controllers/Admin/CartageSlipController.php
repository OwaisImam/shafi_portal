<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Helper\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Repositories\CartageSlipItemRepository;
use App\Repositories\CartageSlipRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\JobRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class CartageSlipController extends Controller
{
    private Request $request;
    private Departments $department;
    private DepartmentRepository $departmentRepository;
    private CartageSlipRepository $cartageSlipRepository;
    private CartageSlipItemRepository $cartageSlipItemRepository;
    private JobRepository $jobRepository;

    public function __construct(
        Request $request,
        CartageSlipRepository $cartageSlipRepository,
        CartageSlipItemRepository $cartageSlipItemRepository,
        DepartmentRepository $departmentRepository,
        JobRepository $jobRepository
    ) {
        $this->request = $request;
        $this->departmentRepository = $departmentRepository;
        $this->cartageSlipRepository = $cartageSlipRepository;
        $this->cartageSlipItemRepository = $cartageSlipItemRepository;
        $this->jobRepository = $jobRepository;
        $this->department = $this->departmentRepository->getByColumn($this->request->slug, 'slug');
    }

    public function index($department)
    {
        $department = $this->department;

        $slips = $this->cartageSlipRepository->with(['job'])->get();

        $slips->map(function ($slip) {
            $modelClass = ucfirst($slip->delivery_from_type);

            $deliveryFrom = "App\\Models\\$modelClass"::where('id', $slip->delivery_from_id)->first();

            $slip->delivery_from = $deliveryFrom;

            $modelClass = ucfirst($slip->delivery_to_type);

            $deliveryTo = "App\\Models\\$modelClass"::where('id', $slip->delivery_to_id)->first();

            return $slip->delivery_to = $deliveryTo;

        });

        $response = [
                 'data' => $slips,
                 'permissions' => Auth::user()->role->permissions,
        ];

        if ($this->request->ajax()) {
            return JsonResponse::success($response, 'Cartage slips fetched successfully.');
        }

        return view('admin.department.cartage_slip.index', compact('department'));
    }

    public function create()
    {
        $department = $this->department;
        $jobs = $this->jobRepository->where('status', 1)->get();

        return view('admin.department.cartage_slip.create', compact('department', 'jobs'));
    }

    public function edit(string $department, string $id)
    {
        $department = $this->department;
        $jobs = $this->jobRepository->where('status', 1)->get();
        $slip = $this->cartageSlipRepository->getById($id);

        return view('admin.department.cartage_slip.edit', compact('department', 'slip', 'jobs'));
    }

    public function store(string $department)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($this->request->all(), [
                'job_id' => 'required|integer',
                'orders' => 'required|array',
                'orders.*' => 'required|integer',
                'slip_no' => 'required|string',
                'items' => 'required|array',
                'items.*' => 'required|integer',
                'delivery_from_type' => 'required|string',
                'delivery_from_id' => 'required|integer',
                'delivery_to_type' => 'required|string',
                'delivery_to_id' => 'required|integer',
                'driver_name' => 'required|string|max:255',
                'driver_cell_no' => 'required|string|max:20',
                'vehicle_no' => 'required|string|max:255',
                'vehicle_type' => 'required|string|max:255',
                'amount' => 'required|numeric',
                'amount_in_words' => 'required|string|max:255',
                'form_id' => 'nullable',
                'status' => 'required|integer|in:0,1', // Assuming status can be either 0 or 1
                'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048', // Adjust the allowed file types and size as necessary
            ], [
                'job_id.required' => 'The job ID is required.',
                'job_id.integer' => 'The job ID must be an integer.',
                'orders.required' => 'The orders field is required.',
                'orders.array' => 'The orders field must be an array.',
                'orders.*.required' => 'Each order ID is required.',
                'orders.*.integer' => 'Each order ID must be an integer.',
                'slip_no.required' => 'The slip number is required.',
                'slip_no.string' => 'The slip number must be a string.',
                'items.required' => 'The items field is required.',
                'items.array' => 'The items field must be an array.',
                'items.*.required' => 'Each item ID is required.',
                'items.*.integer' => 'Each item ID must be an integer.',
                'delivery_from_type.required' => 'The delivery from type is required.',
                'delivery_from_type.string' => 'The delivery from type must be a string.',
                'delivery_from_id.required' => 'The delivery from ID is required.',
                'delivery_from_id.integer' => 'The delivery from ID must be an integer.',
                'delivery_to_type.required' => 'The delivery to type is required.',
                'delivery_to_type.string' => 'The delivery to type must be a string.',
                'delivery_to_id.required' => 'The delivery to ID is required.',
                'delivery_to_id.integer' => 'The delivery to ID must be an integer.',
                'driver_name.required' => 'The driver name is required.',
                'driver_name.string' => 'The driver name must be a string.',
                'driver_name.max' => 'The driver name may not be greater than 255 characters.',
                'driver_cell_no.required' => 'The driver cell number is required.',
                'driver_cell_no.string' => 'The driver cell number must be a string.',
                'driver_cell_no.max' => 'The driver cell number may not be greater than 20 characters.',
                'vehicle_no.required' => 'The vehicle number is required.',
                'vehicle_no.string' => 'The vehicle number must be a string.',
                'vehicle_no.max' => 'The vehicle number may not be greater than 255 characters.',
                'vehicle_type.required' => 'The vehicle type is required.',
                'vehicle_type.string' => 'The vehicle type must be a string.',
                'vehicle_type.max' => 'The vehicle type may not be greater than 255 characters.',
                'amount.required' => 'The amount is required.',
                'amount.numeric' => 'The amount must be a number.',
                'amount_in_words.required' => 'The amount in words is required.',
                'amount_in_words.string' => 'The amount in words must be a string.',
                'amount_in_words.max' => 'The amount in words may not be greater than 255 characters.',
                'status.required' => 'The status is required.',
                'status.integer' => 'The status must be an integer.',
                'status.in' => 'The status must be either 0 or 1.',
                'attachment.file' => 'The attachment must be a file.',
                'attachment.mimes' => 'The attachment must be a file of type: jpg, jpeg, png, pdf, doc, docx.',
                'attachment.max' => 'The attachment may not be greater than 2048 kilobytes.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }

            $validated = $validator->validated();

            if (!isset($validated['status'])) {
                $validated['status'] = 0;
            }

            if (isset($validated['attachment'])) {
                $file = Helper::uploadFile($validated['attachment']);
                unset($validated['attachment']);
                $validated['upload_id'] = $file->id;
            }

            $cartageSlip = $this->cartageSlipRepository->create($validated);

            foreach ($validated['items'] as $item) {
                $cartageSlipItems = [
                    'cartage_slip_id' => $cartageSlip->id,
                    'order_item_id' => $item,
                ];
                $this->cartageSlipItemRepository->create($cartageSlipItems);
            }

            DB::commit();

            $userId = auth()->id().$validated['form_id'];

            Redis::del('form_state:' . $userId);

            return redirect()->route('admin.departments.cartage_slip.index', ['slug' => $department])->with('success', 'Cartage slip added succssfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::debug($e);

            return redirect()->back()->with('error', 'Something went wrong.');

        }
    }
}