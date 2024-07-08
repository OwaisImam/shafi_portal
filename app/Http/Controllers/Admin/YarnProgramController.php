<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Repositories\DepartmentRepository;
use App\Repositories\JobRepository;
use App\Repositories\YarnProgramRepository;
use Illuminate\Http\Request;

class YarnProgramController extends Controller
{
    protected Request $request;
    protected YarnProgramRepository $yarnProgramRepository;
    protected DepartmentRepository $departmentRepository;
    protected JobRepository $jobRepository;
    protected Departments $department;

    public function __construct(
        Request $request,
        YarnProgramRepository $yarnProgramRepository,
        DepartmentRepository $departmentRepository,
        JobRepository $jobRepository,
    )
    {
        $this->request = $request;
        $this->yarnProgramRepository = $yarnProgramRepository;
        $this->departmentRepository = $departmentRepository;
        $this->jobRepository = $jobRepository;
        $this->department = $this->departmentRepository->getByColumn($this->request->slug, 'slug');

    }

    public function index()
    {
        $department = $this->department;
        return view('admin.department.yarn_program.index', compact('department'));
    }

    public function create()
    {
        $department = $this->department;
        $jobs = $this->jobRepository->where('status', 1)->get();
        return view('admin.department.yarn_program.create', compact('department', 'jobs'));
    }
}