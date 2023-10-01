<?php

namespace App\Http\Controllers;

use App\Models\ProjectTasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProjectTasksController extends Controller
{

  /**
   * function untuk mengubah status dari pengerjaan task
   */
  public function change_status_task(Request $request, $id)
  {
    try {
      $task = ProjectTasks::find($id);
      if (!$task) {
        // Handle jika pengguna tidak ditemukan
        return redirect()->back()->with('error', 'Data task tidak ditemukan');
      }

      //code...
      $validator = Validator::make($request->all(), [
        'status' => 'required'
      ]);

      if ($validator->fails()) {
        return redirect()->back()
          ->withErrors($validator)
          ->withInput();
      }
      $task->status = $request->input('status');

      if ($task->save()) {
        return redirect()->back()->with(['success' => 'berhasil mengubah status task']);
      }
      return redirect()->back()->with(['error' => 'Gagal mengubah status task']);
    } catch (\Throwable $th) {
      //throw $th;
      Log::error($th->getMessage());
      return redirect()->back()->with(['error' => 'Gagal mengubah status task']);
    }
  }
  /**
   * function untuk mendapatkan data dari task 
   * 
   */
  public function edit_task_project($id)
  {
    return $id;
  }

  /**
   * function untuk membuat data task
   */
  public function create_task_project($id)
  {
    return view('tasks.form', ['project_id' => $id, 'edit' => false]);
  }
  /**
   * function untuk menyimpan data create task
   */

  public function store_task_project(Request $request, $id)
  {

    try {
      // data validation
      $validator = Validator::make($request->all(), [
        'task_name' => 'required',
        'start_task' => 'required',
        'end_task' => 'required',
      ]);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)
          ->withInput();
      }

      $task = new ProjectTasks();
      $task->projects_id = $id;
      $task->task_name = $request->input('task_name');
      $task->start_task = $request->input('start_task');
      $task->end_task = $request->input('end_task');

      if ($task->save()) {
        return redirect()->route('project.task.show', ['id' => $id])->with('success', 'Berhasil membuat data task!');
      } else {
        return redirect()->route('project.task.show', ['id' => $id])->with('error', 'Gagal membuat data task!');
      }
    } catch (\Throwable $th) {
      Log::error('Failed create data project, please check!', [$th->getMessage()]);
      return redirect()->route('project.task.show', ['id' => $id])->with('error', 'Gagal membuat data task, cek code server!');
    }
  }

  /**
   * function to delete task project
   */
  public function delete_task_project($id)
  {
    try {
      $task = ProjectTasks::findOrFail($id);

      if ($task->delete()) {
        return redirect()->back()->with('success', 'Berhasil menghapus data task!');
      } else {
        return redirect()->back()->with('error', 'Berhasil menghapus data task!');
      }
    } catch (\Throwable $th) {
      //throw $th;
      Log::error('Failed delete data task, please check!', [$th->getMessage()]);
      return redirect()->back()->with('error', 'Berhasil menghapus data task!');
    }
  }
}
