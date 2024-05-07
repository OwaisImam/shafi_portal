<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\DashboardRepository;
use Illuminate\Http\Request;

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
        return view('client.index');
    }
}
