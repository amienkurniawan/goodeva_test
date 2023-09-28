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

        $total_project = new Projects();
        $total_project = $total_project->count();

        $onprogress_project = new Projects();
        $onprogress_project = $onprogress_project->where('status', '=', 'on progress')->count();

        $finish_project = new Projects();
        $finish_project = $finish_project->where('status', '=', 'finish')->count();

        $delay_project = new Projects();
        $delay_project = $delay_project->where('status', '=', 'delay')->count();

        $list_projects = new Projects();
        $list_projects = $list_projects->get();

        return view('dashboard.index', [
            'total_project' => $total_project,
            'onprogress_project' => $onprogress_project,
            'finish_project' => $finish_project,
            'delay_project' => $delay_project,
            'list_projects' => $list_projects
        ]);
    }

    public function export_pdf(TotalProjectsChart $chart)
    {

        $pdf = PDF::loadView('dashboard.index', ['chart' => $chart->build()]);

        return $pdf->download('user.pdf');
    }
}
