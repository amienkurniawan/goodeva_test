<?php

namespace Database\Seeders;

use App\Models\Projects;
use App\Models\ProjectTasks;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buat 10 Post
        $projects = Projects::factory()->count(10)->create();
        $status = ['finish', 'on progress', 'delay'];
        // Untuk setiap Post, buat 10 Comment
        $projects->each(function ($projects) use ($status) {

            $date_start = Carbon::now();
            $date_end = Carbon::now();

            ProjectTasks::factory()->count(10)->create([
                'start_task' => $projects->status === 'finish' ? $date_start->subDays(rand(4, 5)) : $date_start->addDays(rand(1, 2)),
                'end_task' => $projects->status === 'finish' ? $date_end->subDays(rand(1, 3)) : $date_end->addDays(rand(3, 5)),
                'status' => $projects->status === 'finish' ? $status[0] : $status[rand(1, 2)],
                'projects_id' => $projects->id,
            ]);
        });
    }
}
