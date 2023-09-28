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
        return [
            'project_name' => $this->faker->sentence(),
            'start_project' => now(),
            'status' => $status[rand(0, 2)],
            'end_project' =>  $date->addDays(rand(7, 30))
        ];
    }
}
