<?php

namespace App\Http\Controllers;

use App\Charts\MonthlyUsersChart;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(MonthlyUsersChart $chart)
    {
        return view('dashboard.index', ['chart' => $chart->build()]);
    }
}
