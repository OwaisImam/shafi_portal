<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\DashboardRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private DashboardRepository $dashboardRepository;
    private Request $request;

    public function __construct(DashboardRepository $dashboardRepository, Request $request)
    {
        $this->dashboardRepository = $dashboardRepository;
        $this->request = $request;

    }

    public function index()
    {
        return view('index');
    }
}
