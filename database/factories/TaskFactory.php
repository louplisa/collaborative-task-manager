<?php

namespace Database\Factories;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake('fr_FR')->sentence(),
            'description' => implode(' ', fake('fr_FR')->sentences()),
            'status' => array_rand(TaskStatus::labels()),
            'deadline' => now(),
        ];
    }
}
