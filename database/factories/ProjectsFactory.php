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

        return [
            'project_name' => $this->faker->sentence(),
            'start_project' => now(),
            'end_project' =>  $date->addDays(rand(7, 30))
        ];
    }
}
