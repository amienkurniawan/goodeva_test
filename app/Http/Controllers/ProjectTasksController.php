<?php

namespace App\Http\Controllers;

use App\Models\ProjectTasks;
use Illuminate\Http\Request;
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
}
