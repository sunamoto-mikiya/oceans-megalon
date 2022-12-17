<?php

namespace Database\Factories;

use Carbon\CarbonImmutable;
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
    public function definition()
    {
        return [
            'user_id' => 1,
            'author_id' => 1,
            'project_id' => 1,
            'title' => $this->faker->title(),
            'type' => 1,
            'status' => 1,
            'description' => $this->faker->realText(300),
            'start_date' => CarbonImmutable::now()->toDateString(),
            'end_date' => CarbonImmutable::now()->addDays(3)->toDateString(),
        ];
    }
}
