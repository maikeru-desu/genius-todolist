<?php

declare(strict_types=1);

namespace App\Actions\Todo;

use App\Enums\TaskPriority;
use App\Models\Todo;
use Illuminate\Support\Facades\DB;

final class UpdateTodoAction
{
    /**
     * Handle the update todo action.
     */
    public function handle(Todo $todo, array $data): Todo
    {
        return DB::transaction(function () use ($todo, $data) {
            $todo->update([
                'title' => $data['title'] ?? $todo->title,
                'description' => $data['description'] ?? $todo->description,
                'due_date' => $data['due_date'] ?? $todo->due_date,
                'is_completed' => $data['is_completed'] ?? $todo->is_completed,
                'priority' => $data['priority'] ?? $todo->priority,
            ]);

            return $todo->fresh();
        });
    }
}
