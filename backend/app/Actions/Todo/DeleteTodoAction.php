<?php

declare(strict_types=1);

namespace App\Actions\Todo;

use App\Models\Todo;
use Illuminate\Support\Facades\DB;

final class DeleteTodoAction
{
    /**
     * Handle the delete todo action.
     */
    public function handle(Todo $todo): bool
    {
        return DB::transaction(function () use ($todo) {
            return $todo->delete();
        });
    }
}
