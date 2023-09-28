<?php

namespace App\Http\Controllers;

use App\Charts\TotalProjectsChart;
use App\Models\Projects;
use Illuminate\Http\Request;
use PDF;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class ProjectController extends Controller
{
    public function index()
    {

        $larapex = new LarapexChart();
        $chart = new TotalProjectsChart($larapex);
        $chart->setTitle('Total Projects');
        $chart->setData([100, 100, 100]);
        $chart->setLabel(["on progress", "finish", "delay"]);
        $projects = new Projects();

        $total_project = $projects->get()->count();
        return view('dashboard.index', ['total_project' => $total_project]);
    }

    public function export_pdf(TotalProjectsChart $chart)
    {

        $pdf = PDF::loadView('dashboard.index', ['chart' => $chart->build()]);

        return $pdf->download('user.pdf');
    }
}
