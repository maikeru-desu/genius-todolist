<?php

namespace Database\Factories;

use App\Enums\TaskPriority;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'is_completed' => $this->faker->boolean(20), // 20% chance of being completed
            'due_date' => $this->faker->optional(80)->dateTimeBetween('now', '+2 weeks'), // 80% chance of having a due date
            'target_time' => function () {
                $dateTime = $this->faker->optional(60)->dateTimeBetween('08:00', '20:00');
                return $dateTime ? $dateTime->format('H:i') : null;
            }, // 60% chance of having target time
            'priority' => $this->faker->randomElement(TaskPriority::cases()),
        ];
    }

    /**
     * Mark the todo as completed.
     */
    public function completed(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'is_completed' => true,
            ];
        });
    }

    /**
     * Set the todo priority to high.
     */
    public function highPriority(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'priority' => TaskPriority::HIGH,
            ];
        });
    }
    
    /**
     * Set the todo priority to medium.
     */
    public function mediumPriority(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'priority' => TaskPriority::MEDIUM,
            ];
        });
    }
    
    /**
     * Set the todo priority to low.
     */
    public function lowPriority(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'priority' => TaskPriority::LOW,
            ];
        });
    }
}
