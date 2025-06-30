<?php

namespace App\Actions\Todo;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListTodosAction
{
    /**
     * Handle the list todos action.
     *
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function handle(User $user, array $data): LengthAwarePaginator
    {
        $query = $user->todos();
        
        // Apply filters
        if (isset($data['is_completed'])) {
            $query->where('is_completed', $data['is_completed']);
        }
        
        if (isset($data['priority'])) {
            $query->where('priority', $data['priority']);
        }
        
        $sortBy = $data['sort_by'] ?? 'created_at';
        $sortDirection = $data['sort_direction'] ?? 'desc';
        $query->orderBy($sortBy, $sortDirection);
        
        $perPage = $data['per_page'] ?? 10;
        return $query->paginate($perPage);
    }
}
