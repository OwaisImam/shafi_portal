<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Helper\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Repositories\CountRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\FiberRepository;
use App\Repositories\JobRepository;
use App\Repositories\YarnProgramItemRepository;
use App\Repositories\YarnProgramRepository;
use Exception;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class YarnProgramController extends Controller
{
    protected Request $request;
    protected YarnProgramRepository $yarnProgramRepository;
    protected YarnProgramItemRepository $yarnProgramItemRepository;
    protected DepartmentRepository $departmentRepository;
    protected JobRepository $jobRepository;
    protected CountRepository $countRepository;
    protected FiberRepository $fiberRepository;
    protected Departments $department;

    public function __construct(
        Request $request,
        YarnProgramRepository $yarnProgramRepository,
        YarnProgramItemRepository $yarnProgramItemRepository,
        DepartmentRepository $departmentRepository,
        JobRepository $jobRepository,
        FiberRepository $fiberRepository,
        CountRepository $countRepository,
    )
    {
        $this->request = $request;
        $this->yarnProgramRepository = $yarnProgramRepository;
        $this->yarnProgramItemRepository = $yarnProgramItemRepository;
        $this->departmentRepository = $departmentRepository;
        $this->jobRepository = $jobRepository;
        $this->fiberRepository = $fiberRepository;
        $this->countRepository = $countRepository;
        $this->department = $this->departmentRepository->getByColumn($this->request->slug, 'slug');

    }

    public function index()
    {
        $department = $this->department;
        $yarnPrograms = $this->yarnProgramRepository->with(['items', 'job.orders'])->get();
        $response = [
           'data' => $yarnPrograms,
           'permissions' => Auth::user()->role->permissions,
        ];

        if ($this->request->ajax()) {
            return JsonResponse::success($response, 'Yarn programs fetched successfully.');
        }

        return view('admin.department.yarn_program.index', compact('department'));
    }

    public function create()
    {
        $department = $this->department;
        $jobs = $this->jobRepository->where('status', 1)->get();
        $counts = $this->countRepository->where('status', 1)->get();
        $fibers = $this->fiberRepository->where('status', 1)->get();

        return view('admin.department.yarn_program.create', compact('department', 'jobs', 'fibers', 'counts'));
    }

    public function store($slug)
    {
        try{
            DB::beginTransaction();
            $rules = [
                'job_id' => 'required|integer',
                'name' => 'required|string|max:255',
                'required_kgs.*' => 'required',
                'order_id' => 'required'
            ];

            // Define base rules for dynamic groups
            $groupRules = [
                '*.count' => 'required|integer',
                '*.fiber' => 'required|integer',
                '*.percentage' => 'required|numeric',
                '*.kgs' => 'required|numeric',
                '*.bags' => 'required|numeric',
            ];

            // Loop through all groups dynamically
            foreach ($this->request->all() as $key => $value) {
                if (preg_match('/^group-[a-z]$/', $key)) {
                    foreach ($groupRules as $field => $rule) {
                        $rules["$key.$field"] = $rule;
                    }
                }
            }
            $validator = Validator::make($this->request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }

            $validated = $validator->validated();

            $yarnProgramData = [
                    'job_id' => $validated['job_id'],
                    'name' => $validated['name']
                ];

            $yarnProgram = $this->yarnProgramRepository->create($yarnProgramData);

            foreach($validated['order_id'] as $key=>$order_id) {

                foreach($validated['group-'.Helper::indexToAlphabet($key)] as $groupData) {
                    $yarnProgramItemData = [
                        'yarn_program_id' => $yarnProgram->id,
                        'order_id' => $order_id,
                        'count_id' => $groupData['count'],
                        'fiber_id' => $groupData['fiber'],
                        'percentage' => $groupData['percentage'],
                        'kgs' => $groupData['kgs'],
                        'bags' => $groupData['bags'],
                        'required_kgs' => $validated['required_kgs'][$key]
                    ];

                $this->yarnProgramItemRepository->create($yarnProgramItemData);
                }
            }
            DB::commit();

            return redirect()->route('admin.departments.yarn_program.index', ['slug' => $slug])->with('success', 'Yarn program created succssfully.');
        }catch(\Exception $e)
        {
            Log::debug($e);
            DB::rollback();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function edit(string $slug, string $id)
    {
        $yarnProgram = $this->yarnProgramRepository->getById($id);
        $department = $this->department;
        $jobs = $this->jobRepository->where('status', 1)->get();
        $counts = $this->countRepository->where('status', 1)->get();
        $fibers = $this->fiberRepository->where('status', 1)->get();

        return view('admin.department.yarn_program.edit', compact('yarnProgram', 'department', 'jobs', 'fibers', 'counts'));

    }

     public function update(string $slug, string $id)
    {
        try{
            DB::beginTransaction();
            $rules = [
                'job_id' => 'required|integer',
                'name' => 'required|string|max:255',
                'required_kgs.*' => 'required',
                'order_id' => 'required'
            ];

            // Define base rules for dynamic groups
            $groupRules = [
                '*.count' => 'required|integer',
                '*.fiber' => 'required|integer',
                '*.percentage' => 'required|numeric',
                '*.kgs' => 'required|numeric',
                '*.bags' => 'required|numeric',
            ];

            // Loop through all groups dynamically
            foreach ($this->request->all() as $key => $value) {
                if (preg_match('/^group-[a-z]$/', $key)) {
                    foreach ($groupRules as $field => $rule) {
                        $rules["$key.$field"] = $rule;
                    }
                }
            }
            $validator = Validator::make($this->request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }

            $validated = $validator->validated();

            $yarnProgramData = [
                    'job_id' => $validated['job_id'],
                    'name' => $validated['name']
                ];

            $yarnProgram = $this->yarnProgramRepository->updateById($id, $yarnProgramData);

            $yarnProgram->items()->delete();

            foreach($validated['order_id'] as $key=>$order_id) {

                foreach($validated['group-'.Helper::indexToAlphabet($key)] as $groupData) {
                    $yarnProgramItemData = [
                        'yarn_program_id' => $yarnProgram->id,
                        'order_id' => $order_id,
                        'count_id' => $groupData['count'],
                        'fiber_id' => $groupData['fiber'],
                        'percentage' => $groupData['percentage'],
                        'kgs' => $groupData['kgs'],
                        'bags' => $groupData['bags'],
                        'required_kgs' => $validated['required_kgs'][$key]
                    ];

                $this->yarnProgramItemRepository->create($yarnProgramItemData);
                }
            }
            DB::commit();

            return redirect()->route('admin.departments.yarn_program.index', ['slug' => $slug])->with('success', 'Yarn program updated succssfully.');
        }catch(\Exception $e)
        {
            Log::debug($e);
            DB::rollback();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function show(string $slug, string $id)
    {
        $yarnProgram = $this->yarnProgramRepository->getById($id);
        $department = $this->department;

        return view('admin.department.yarn_program.view', compact('yarnProgram', 'department'));

    }

    public function destroy(string $slug, string $id)
    {
         try {
            DB::beginTransaction();

            $yarnProgram = $this->yarnProgramRepository->getById($id);
            $yarnProgram->items()->delete();
            $yarnProgram->delete();

            DB::commit();

            if ($this->request->ajax()) {
                return JsonResponse::success(null, 'Yarn program deleted successfully.');
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
}
