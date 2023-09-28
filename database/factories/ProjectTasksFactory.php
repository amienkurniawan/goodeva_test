<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectTasksFactory extends Factory
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
            'task_name' => $this->faker->sentence(),
            'start_task' => now(),
            'end_task' => $date->addDays(rand(1, 3)),
        ];
    }
}
