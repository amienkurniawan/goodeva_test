<?php

namespace App\Http\Controllers;

use App\Charts\MonthlyUsersChart;
use Illuminate\Http\Request;
use PDF;

class ProjectController extends Controller
{
    public function index(MonthlyUsersChart $chart)
    {
        return view('dashboard.index', ['chart' => $chart->build()]);
    }

    public function export_pdf(MonthlyUsersChart $chart)
    {

        $pdf = PDF::loadView('dashboard.index', ['chart' => $chart->build()]);

        return $pdf->download('user.pdf');
    }
}
