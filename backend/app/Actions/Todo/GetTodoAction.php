<?php

declare(strict_types=1);

namespace App\Actions\Todo;

use App\Models\Todo;

final class GetTodoAction
{
    /**
     * Handle the get Todo action.
     */
    public function handle(Todo $todo): Todo
    {
        return $todo;
    }
}
