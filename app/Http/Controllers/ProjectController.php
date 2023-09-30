<?php

namespace App\Http\Controllers;

use App\Charts\ProjectTasksChart;
use App\Charts\ProjectTasksPieChart;
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
        $list_projects = $list_projects->paginate(10);

        return view('dashboard.index', [
            'total_project' => $total_project,
            'onprogress_project' => $onprogress_project,
            'finish_project' => $finish_project,
            'delay_project' => $delay_project,
            'list_projects' => $list_projects
        ]);
    }

    public function show_task_project($id)
    {
        $project = Projects::with('tasks')->findOrFail($id);
        $on_progress_task = 0;
        $finish_task = 0;
        $delay_task = 0;

        foreach ($project->tasks as $task) {
            if ($task->status == 'on progress') {
                $on_progress_task++;
            }
            if ($task->status == 'delay') {
                $delay_task++;
            }
            if ($task->status == 'finish') {
                $finish_task++;
            }
        };

        $larapex = new LarapexChart();
        $chart = new ProjectTasksChart($larapex);
        $chart->setTitle('Total Task');
        $chart->setData([$on_progress_task, $finish_task, $delay_task]);
        $chart->setLabel(["on progress", "finish", "delay"]);

        $piechart = new ProjectTasksPieChart($larapex);
        $piechart->setTitle('Total Task');
        $piechart->setData([$on_progress_task, $finish_task, $delay_task]);
        $piechart->setLabel(["on progress", "finish", "delay"]);

        return view('projects.view', [
            'project' => $project,
            'chart' => $chart->build(),
            'piechart' => $piechart->build(),
        ]);
    }

    public function export_pdf(TotalProjectsChart $chart)
    {

        $pdf = PDF::loadView('dashboard.index', ['chart' => $chart->build()]);

        return $pdf->download('user.pdf');
    }
}
