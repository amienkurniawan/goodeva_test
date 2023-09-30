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


Route::get('/',  [ProjectController::class, 'index']);
Route::get('/pdf',  [ProjectController::class, 'export_pdf']);

Route::group(['prefix' => 'project'], function () {

  Route::group(['prefix' => 'task'], function () {
    Route::get('/{id}',  [ProjectController::class, 'show_task_project'])->name('project.task.show');

    Route::patch('/update/{id}', [ProjectTasksController::class, 'change_status_task'])->name('project.task.update.status');
  });
});
