<?php

namespace Database\Factories;

use App\Models\User;
use App\TodoTaskStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TodoTask>
 */
class TodoTaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(6, true),
            'description' => $this->faker->paragraph(),
            'user_id' => User::factory(),
            'status' => TodoTaskStatusEnum::PENDING->label(),
        ];
    }
}
