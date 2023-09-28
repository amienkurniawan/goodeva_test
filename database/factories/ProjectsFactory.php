<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = Carbon::now();
        $status = ['finish', 'on progress', 'delay'];
        $start_project = $date->addDays(rand(1, 2));
        $end_project = $date->addDays(rand(7, 30));
        return [
            'project_name' => $this->faker->sentence(),
            'start_project' => $start_project,
            'end_project' =>  $end_project,
            'status' => $end_project <= Carbon::now() ? $status[0] : $status[rand(1, 2)],
        ];
    }
}
