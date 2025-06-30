<?php

namespace App\Actions\Todo;

use App\Models\Todo;

class GetTodoAction
{
    /**
     * Handle the get Todo action.
     *
     * @return Todo
     */
    public function handle(Todo $todo): Todo
    {
        return $todo;
    }
}
