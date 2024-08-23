<?php

namespace App\Http\Controllers\Admin;

use App\Helper\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Repositories\CountRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\FiberRepository;
use App\Repositories\JobRepository;
use App\Repositories\KnittingProgramItemRepository;
use App\Repositories\KnittingProgramRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class KnittingProgramController extends Controller
{
    protected Request $request;
    protected KnittingProgramRepository $knittingProgramRepository;
    protected KnittingProgramItemRepository $knittingProgramItemRepository;
    protected DepartmentRepository $departmentRepository;
    protected JobRepository $jobRepository;
    protected CountRepository $countRepository;
    protected FiberRepository $fiberRepository;
    protected Departments $department;

    public function __construct(
        Request $request,
        KnittingProgramRepository $knittingProgramRepository,
        KnittingProgramItemRepository $knittingProgramItemRepository,
        DepartmentRepository $departmentRepository,
        JobRepository $jobRepository,
        FiberRepository $fiberRepository,
        CountRepository $countRepository,
    ) {
        $this->request = $request;
        $this->knittingProgramRepository = $knittingProgramRepository;
        $this->knittingProgramItemRepository = $knittingProgramItemRepository;
        $this->departmentRepository = $departmentRepository;
        $this->jobRepository = $jobRepository;
        $this->fiberRepository = $fiberRepository;
        $this->countRepository = $countRepository;
        $this->department = $this->departmentRepository->getByColumn($this->request->slug, 'slug');

    }

    public function index()
    {
        $department = $this->department;
        $knittingPrograms = $this->knittingProgramRepository->with(['items', 'order', 'job'])->get();
        $response = [
           'data' => $knittingPrograms,
           'permissions' => Auth::user()->role->permissions,
        ];

        if ($this->request->ajax()) {
            return JsonResponse::success($response, 'Knitting programs fetched successfully.');
        }

        return view('admin.department.knitting_program.index', compact('department'));
    }

    public function create()
    {
        $department = $this->department;
        $jobs = $this->jobRepository->where('status', 1)->get();
        $counts = $this->countRepository->where('status', 1)->get();
        $fibers = $this->fiberRepository->where('status', 1)->get();

        return view('admin.department.knitting_program.create', compact('department', 'jobs', 'fibers', 'counts'));
    }

    public function edit($slug, $id)
    {
        $department = $this->department;
        $jobs = $this->jobRepository->where('status', 1)->get();
        $counts = $this->countRepository->where('status', 1)->get();
        $fibers = $this->fiberRepository->where('status', 1)->get();
        $knittingProgram = $this->knittingProgramRepository->getById($id);

        return view('admin.department.knitting_program.edit', compact('department', 'knittingProgram', 'jobs', 'fibers', 'counts'));
    }

    public function store($slug)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($this->request->all(), [
                'job_id' => 'required|integer|exists:p_jobs,id',
                'order_id' => 'required|integer|exists:orders,id',
                'article_id' => 'required|array',
                'article_id.*' => 'required|string',
                'description' => 'required|string',
                'fabric_content' => 'required|string',
                'body_fabric' => 'required|array',
                'body_fabric.*' => 'required|numeric',
                'body_fabric_dozen' => 'required|array',
                'body_fabric_dozen.*' => 'required|numeric',
                'fabric_detail_kgs' => 'required|array',
                'fabric_detail_kgs.*' => 'required|numeric',
                'order_qty' => 'required|array',
                'order_qty.*' => 'required|integer',
                'required_finished_gsm' => 'required|string',
                'required_finished_width' => 'required|string',
                'required_finished_quality' => 'required|string',
                'shade_matching_light' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }

            $validated = $validator->validated();

            $programData = [
                'job_id' => $validated['job_id'],
                'order_id' => $validated['order_id'],
                'description' => $validated['description'],
                'fabric_content' => $validated['fabric_content'],
                'shade_matching_light' => $validated['shade_matching_light'],
                'required_finished_gsm' => $validated['required_finished_gsm'],
                'required_finished_width' => $validated['required_finished_width'],
                'required_finished_quality' => $validated['required_finished_quality'],
                'article_id' => implode(',', $validated['article_id']),
            ];

            $knittingProgram = $this->knittingProgramRepository->create($programData);

            foreach ($validated['body_fabric'] as $key=>$item) {

                $programItem = [
                    'knitting_program_id' => $knittingProgram->id,
                    'body_fabric' => $item,
                    'body_fabric_dozen' => $validated['body_fabric_dozen'][$key],
                    'fabric_detail_kgs' => $validated['fabric_detail_kgs'][$key],
                    'order_qty' => $validated['order_qty'][$key],
                ];

                $this->knittingProgramItemRepository->create($programItem);
            }

            DB::commit();

            return redirect()->route('admin.departments.knitting_program.index', ['slug' => $slug])->with('success', 'Knitting program created succssfully.');
        } catch (Exception $e) {
            Log::debug($e);
            DB::rollback();

            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function update($slug, $id)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($this->request->all(), [
                'job_id' => 'required|integer|exists:p_jobs,id',
                'order_id' => 'required|integer|exists:orders,id',
                'article_id' => 'required|array',
                'article_id.*' => 'required|string',
                'description' => 'required|string',
                'fabric_content' => 'required|string',
                'body_fabric' => 'required|array',
                'body_fabric.*' => 'required|numeric',
                'body_fabric_dozen' => 'required|array',
                'body_fabric_dozen.*' => 'required|numeric',
                'fabric_detail_kgs' => 'required|array',
                'fabric_detail_kgs.*' => 'required|numeric',
                'order_qty' => 'required|array',
                'order_qty.*' => 'required|integer',
                'required_finished_gsm' => 'required|string',
                'required_finished_width' => 'required|string',
                'required_finished_quality' => 'required|string',
                'shade_matching_light' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }

            $validated = $validator->validated();

            $programData = [
                'job_id' => $validated['job_id'],
                'order_id' => $validated['order_id'],
                'description' => $validated['description'],
                'fabric_content' => $validated['fabric_content'],
                'shade_matching_light' => $validated['shade_matching_light'],
                'required_finished_gsm' => $validated['required_finished_gsm'],
                'required_finished_width' => $validated['required_finished_width'],
                'required_finished_quality' => $validated['required_finished_quality'],
                'article_id' => implode(',', $validated['article_id']),
            ];

            $knittingProgram = $this->knittingProgramRepository->updateById($id, $programData);
            
            $knittingProgram->items()->delete();

            foreach ($validated['body_fabric'] as $key=>$item) {

                $programItem = [
                    'knitting_program_id' => $knittingProgram->id,
                    'body_fabric' => $item,
                    'body_fabric_dozen' => $validated['body_fabric_dozen'][$key],
                    'fabric_detail_kgs' => $validated['fabric_detail_kgs'][$key],
                    'order_qty' => $validated['order_qty'][$key],
                ];

                $this->knittingProgramItemRepository->create($programItem);
            }

            DB::commit();

            return redirect()->route('admin.departments.knitting_program.index', ['slug' => $slug])->with('success', 'Knitting program updated succssfully.');
        } catch (Exception $e) {
            Log::debug($e);
            DB::rollback();

            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function destroy(string $slug, string $id)
    {
        try {
            DB::beginTransaction();

            $yarnProgram = $this->knittingProgramRepository->getById($id);
            $yarnProgram->items()->delete();
            $yarnProgram->delete();

            DB::commit();

            if ($this->request->ajax()) {
                return JsonResponse::success(null, 'Knitting program deleted successfully.');
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);

            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
}
