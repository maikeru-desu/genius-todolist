<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TaskPriority;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Todo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'is_completed',
        'due_date',
        'target_time',
        'priority',
    ];

    /**
     * Get the user that owns the todo.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include todos with a specific priority.
     */
    public function scopeWithPriority(Builder $query, TaskPriority $priority): Builder
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope a query to order todos by priority (highest first).
     */
    public function scopeOrderByPriority(Builder $query, bool $descending = true): Builder
    {
        return $query->orderBy('priority', $descending ? 'desc' : 'asc');
    }

    /**
     * Scope a query to only include completed todos.
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('is_completed', true);
    }

    /**
     * Scope a query to only include uncompleted todos.
     */
    public function scopeUncompleted(Builder $query): Builder
    {
        return $query->where('is_completed', false);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_completed' => 'boolean',
            'due_date' => 'datetime',
            'target_time' => 'datetime:H:i',
            'priority' => TaskPriority::class,
        ];
    }
}
