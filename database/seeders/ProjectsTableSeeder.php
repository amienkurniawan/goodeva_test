<?php

namespace Database\Seeders;

use App\Models\Projects;
use App\Models\ProjectTasks;
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

        // Untuk setiap Post, buat 10 Comment
        $projects->each(function ($post) {
            ProjectTasks::factory()->count(10)->create([
                'project_id' => $post->id,
            ]);
        });
    }
}
