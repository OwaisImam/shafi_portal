<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\KnittingProgramRepository;
use Illuminate\Http\Request;

class KnittingProgramController extends Controller
{
    private Request $request;
    private KnittingProgramRepository $knittingProgramRepository;

    public function __construct(
        Request $request,
        KnittingProgramRepository $knittingProgramRepository
    )
    {
        $this->request = $request;
        $this->knittingProgramRepository = $knittingProgramRepository;
    }

    public function index()
    {
        return view('admin.department.knitting_program.index');
    }
}