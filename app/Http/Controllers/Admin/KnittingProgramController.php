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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    )
    {
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
        $yarnPrograms = $this->knittingProgramRepository->with(['items', 'job.orders'])->get();
        $response = [
           'data' => $yarnPrograms,
           'permissions' => Auth::user()->role->permissions,
        ];

        if ($this->request->ajax()) {
            return JsonResponse::success($response, 'Yarn programs fetched successfully.');
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
}