<?php

namespace App\Actions\Todo;

use App\Models\Todo;
use Illuminate\Support\Facades\DB;

class UpdateTodoAction
{
    /**
     * Handle the update todo action.
     *
     * @param array $data
     * @return Todo
     */
    public function handle(Todo $todo, array $data): Todo
    {
        return DB::transaction(function() use ($todo, $data) {
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
