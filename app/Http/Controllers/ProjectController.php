<?php

namespace App\Http\Controllers;

use App\Charts\ProjectTasksChart;
use App\Charts\ProjectTasksPieChart;
use App\Charts\TotalProjectsChart;
use App\Models\Projects;
use Illuminate\Http\Request;
use PDF;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Exports\ProjectsExport;
use App\Exports\ProjectsFormatExport;
use App\Imports\MasterImportProject;
use App\Models\ProjectTasks;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ProjectController extends Controller
{
    /**
     * function to show main dashboard
     */
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


        $list_projects = Projects::withCount([
            'tasks',
            'tasks as tasks_finish' => function ($query) {
                $query->where('status', '=', 'finish');
            }
        ])->paginate(10);

        return view('dashboard.index', [
            'total_project' => $total_project,
            'onprogress_project' => $onprogress_project,
            'finish_project' => $finish_project,
            'delay_project' => $delay_project,
            'list_projects' => $list_projects
        ]);
    }

    /**
     * function to show data project
     */
    public function form_project()
    {
        return view('projects.form', ['edit' => false]);
    }

    /**
     * function to edit project
     */
    public function edit($id)
    {
        $data = Projects::find($id);
        return view('projects.form', ['data' => $data, 'edit' => true]);
    }
    /**
     * function to update project
     */
    public function update_project(Request $request, $id)
    {
        try {
            // data import excel
            $validator = Validator::make($request->all(), [
                'project_name' => 'required',
                'start_project' => 'required',
                'end_project' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)
                    ->withInput();
            }

            $project = Projects::find($id);
            $project->project_name = $request->input('project_name');
            $project->start_project = $request->input('start_project');
            $project->end_project = $request->input('end_project');

            if ($project->save()) {
                return redirect()->route('index.project')->with('success', 'Berhasil mengubah data project!');
            } else {
                return redirect()->route('index.project')->with('error', 'Gagal mengubah data project!');
            }
        } catch (\Throwable $th) {
            Log::error('Failed mengubah data project, please check!', [$th->getMessage()]);
            return redirect()->route('index.project')->with('error', 'Gagal mengubah data project, cek code server!');
        }
    }
    /**
     * function to softdelete data project
     */
    public function delete_project($id)
    {
        try {

            $project = Projects::find($id);
            $task = ProjectTasks::where('projects_id', '=', $id)->delete();

            if ($project->delete() && $task) {
                return redirect()->route('index.project')->with('success', 'Berhasil menghapus data project!');
            } else {
                return redirect()->route('index.project')->with('error', 'Berhasil menghapus data project!');
            }
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('Failed delete data project, please check!', [$th->getMessage()]);
            return redirect()->route('index.project')->with('error', 'Berhasil menghapus data project!');
        }
    }

    /**
     * function to create data project
     */
    public function create_project(Request $request)
    {
        try {
            // data validation
            $validator = Validator::make($request->all(), [
                'project_name' => 'required',
                'start_project' => 'required',
                'end_project' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)
                    ->withInput();
            }

            $project = new Projects();
            $project->project_name = $request->input('project_name');
            $project->start_project = $request->input('start_project');
            $project->end_project = $request->input('end_project');

            if ($project->save()) {
                return redirect()->route('index.project')->with('success', 'Berhasil membuat data project!');
            } else {
                return redirect()->route('index.project')->with('error', 'Gagal membuat data project!');
            }
        } catch (\Throwable $th) {
            Log::error('Failed create data project, please check!', [$th->getMessage()]);
            return redirect()->route('index.project')->with('error', 'Gagal membuat data project, cek code server!');
        }
    }
    /**
     * function to show task project
     */
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

        return view('tasks.view', [
            'project' => $project,
            'chart' => $chart->build(),
            'piechart' => $piechart->build(),
        ]);
    }

    /**
     * function download format import project
     */
    public function format_import_projects()
    {
        return Excel::download(new ProjectsFormatExport, 'import-format-project.xlsx');
    }

    /**
     * function download projects
     */
    public function download_export_projects()
    {
        return Excel::download(new ProjectsExport, 'export-project.xlsx');
    }
    /**
     * function to import data project
     */
    public function import_projects(Request $request)
    {
        try {
            // data import excel
            $validator = Validator::make($request->all(), [
                'import_file' => 'required|mimes:xls,xlsx',
            ]);

            if ($validator->fails()) {
                return $validator->errors();
            }

            if ($request->hasFile('import_file')) {

                $datas = Excel::toArray(new MasterImportProject, request()->file('import_file'));

                $result  = $this->insert_data_project($datas[0]);
                // return Date::excelToDateTimeObject($datas['project_start']);

                if ($result) {
                    return redirect()->route('index.project')->with('success', 'Success melakukan import data project!');
                } else {
                    return redirect()->route('index.project')->with('error', 'Gagal melakukan import data project!');
                }
            } else {
                Log::error('Failed import data item stock opname, please check!');
                return redirect()->route('index.project')->with('error', 'Gagal melakukan import data project, file tidak ditemukan!');
            }
        } catch (\Throwable $th) {
            Log::error('Failed import data data project, please check!', [$th->getMessage()]);
            return redirect()->route('index.project')->with('error', 'Gagal melakukan import data project, cek code server!');
        }
    }

    /**
     * function to download pdf file
     */
    public function export_pdf()
    {
        $list_projects = Projects::get();
        $pdf = PDF::loadView('pdf.projects', ['list_projects' => $list_projects]);
        return $pdf->download('projects.pdf');
    }

    private function insert_data_project($datas)
    {
        try {
            foreach ($datas as $data) {
                Projects::create([
                    'project_name'  => $data['project_name'],
                    'start_project' => Date::excelToDateTimeObject($data['project_start']),
                    'end_project' => Date::excelToDateTimeObject($data['project_end']),
                ]);
            }
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('Failed import data data project, please check!', [$th->getMessage()]);
            return false;
        }
    }
}
