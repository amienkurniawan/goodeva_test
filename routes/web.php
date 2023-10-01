<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectTasksController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/',  [ProjectController::class, 'index'])->name('index.project');


Route::group(['prefix' => 'project'], function () {

  Route::get('/pdf',  [ProjectController::class, 'export_pdf'])->name('export.pdf.project');
  Route::get('/export', [ProjectController::class, 'download_export_projects'])->name('export.project');
  Route::get('/format-import', [ProjectController::class, 'format_import_projects'])->name('format.import.project');
  Route::get('/create', [ProjectController::class, 'form_project'])->name('create.project');
  Route::post('/import', [ProjectController::class, 'import_projects'])->name('import.project');
  Route::post('/store', [ProjectController::class, 'create_project'])->name('save.project');

  Route::group(['prefix' => 'task'], function () {
    Route::get('/{id}',  [ProjectController::class, 'show_task_project'])->name('project.task.show');
    Route::patch('/update/{id}', [ProjectTasksController::class, 'change_status_task'])->name('project.task.update.status');
  });
});
