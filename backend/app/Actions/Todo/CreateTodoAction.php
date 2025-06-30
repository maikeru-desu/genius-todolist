<?php

declare(strict_types=1);

namespace App\Actions\Todo;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final class CreateTodoAction
{
    /**
     * Handle the create todo action.
     */
    public function handle(User $user, array $data): Todo
    {
        return DB::transaction(function () use ($user, $data) {
            return $user->todos()->create([
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'due_date' => $data['due_date'] ?? null,
                'is_completed' => $data['is_completed'] ?? false,
                'priority' => $data['priority'] ?? 0,
            ]);
        });
    }
}
