<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TaskPriority;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_completed' => 'boolean',
            'due_date' => 'datetime',
            'priority' => TaskPriority::class,
        ];
    }
    
    /**
     * Scope a query to only include todos with a specific priority.
     *
     * @param Builder $query
     * @param TaskPriority $priority
     * @return Builder
     */
    public function scopeWithPriority(Builder $query, TaskPriority $priority): Builder
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope a query to order todos by priority (highest first).
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrderByPriority(Builder $query, bool $descending = true): Builder
    {
        return $query->orderBy('priority', $descending ? 'desc' : 'asc');
    }

    /**
     * Scope a query to only include completed todos.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('is_completed', true);
    }

    /**
     * Scope a query to only include uncompleted todos.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeUncompleted(Builder $query): Builder
    {
        return $query->where('is_completed', false);
    }
}
