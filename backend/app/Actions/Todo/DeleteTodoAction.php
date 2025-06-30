<?php

namespace App\Actions\Todo;

use App\Models\Todo;
use Illuminate\Support\Facades\DB;

class DeleteTodoAction
{
    /**
     * Handle the delete todo action.
     *
     * @return bool
     */
    public function handle(Todo $todo): bool
    {
        return DB::transaction(function() use ($todo) {
            return $todo->delete();
        });
    }
}
