<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\TaskPriority;
use App\Models\Todo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users or create if none exist
        $users = User::all();
        
        if ($users->isEmpty()) {
            // Create some users if none exist
            User::factory()->count(3)->create();
            $users = User::all();
        }
        
        foreach ($users as $user) {
            // Create current day todos (due today)
            $this->createTodosForToday($user);
            
            // Create upcoming todos (due in next 7 days)
            $this->createUpcomingTodos($user);
            
            // Create past todos (mix of completed and overdue)
            $this->createPastTodos($user);
        }
    }
    
    /**
     * Create todos due today
     */
    private function createTodosForToday(User $user): void
    {
        // High priority todo for today
        Todo::create([
            'user_id' => $user->id,
            'title' => 'Important task for today',
            'description' => 'This is a high priority task that needs to be completed today',
            'is_completed' => false,
            'due_date' => Carbon::today(),
            'target_time' => Carbon::createFromTime(17, 0), // 5:00 PM
            'priority' => TaskPriority::HIGH,
        ]);
        
        // Medium priority todo for today
        Todo::create([
            'user_id' => $user->id,
            'title' => 'Regular task for today',
            'description' => 'This is a medium priority task for today',
            'is_completed' => false,
            'due_date' => Carbon::today(),
            'target_time' => Carbon::createFromTime(14, 30), // 2:30 PM
            'priority' => TaskPriority::MEDIUM,
        ]);
        
        // Low priority todo for today
        Todo::create([
            'user_id' => $user->id,
            'title' => 'Optional task for today',
            'description' => 'This is a low priority task that would be nice to complete today',
            'is_completed' => false,
            'due_date' => Carbon::today(),
            'target_time' => Carbon::createFromTime(12, 0), // Noon
            'priority' => TaskPriority::LOW,
        ]);
        
        // Completed todo for today
        Todo::create([
            'user_id' => $user->id,
            'title' => 'Already completed task',
            'description' => 'This task has already been completed today',
            'is_completed' => true,
            'due_date' => Carbon::today(),
            'target_time' => Carbon::createFromTime(9, 0), // 9:00 AM
            'priority' => TaskPriority::MEDIUM,
        ]);
    }
    
    /**
     * Create todos due in the future
     */
    private function createUpcomingTodos(User $user): void
    {
        // Create 5 upcoming todos with varying priorities
        for ($i = 1; $i <= 5; $i++) {
            $daysInFuture = rand(1, 7);
            $priority = match(rand(0, 2)) {
                0 => TaskPriority::LOW,
                1 => TaskPriority::MEDIUM,
                2 => TaskPriority::HIGH,
            };
            
            $hour = rand(8, 17); // Between 8 AM and 5 PM
            $minute = [0, 15, 30, 45][rand(0, 3)];
            
            Todo::create([
                'user_id' => $user->id,
                'title' => "Upcoming task #{$i} (due in {$daysInFuture} days)",
                'description' => "This is a future task due in {$daysInFuture} days",
                'is_completed' => false,
                'due_date' => Carbon::now()->addDays($daysInFuture),
                'target_time' => Carbon::createFromTime($hour, $minute),
                'priority' => $priority,
            ]);
        }
    }
    
    /**
     * Create todos from the past (mix of completed and overdue)
     */
    private function createPastTodos(User $user): void
    {
        // Create 5 completed past todos
        for ($i = 1; $i <= 5; $i++) {
            $daysInPast = rand(1, 14);
            $priority = match(rand(0, 2)) {
                0 => TaskPriority::LOW,
                1 => TaskPriority::MEDIUM,
                2 => TaskPriority::HIGH,
            };
            
            Todo::create([
                'user_id' => $user->id,
                'title' => "Completed past task #{$i} (completed {$daysInPast} days ago)",
                'description' => "This task was completed {$daysInPast} days ago",
                'is_completed' => true,
                'due_date' => Carbon::now()->subDays($daysInPast),
                'target_time' => Carbon::createFromTime(rand(8, 17), [0, 15, 30, 45][rand(0, 3)]),
                'priority' => $priority,
            ]);
        }
        
        // Create 3 overdue todos (past due, not completed)
        for ($i = 1; $i <= 3; $i++) {
            $daysOverdue = rand(1, 5);
            $priority = match(rand(0, 2)) {
                0 => TaskPriority::LOW,
                1 => TaskPriority::MEDIUM,
                2 => TaskPriority::HIGH,
            };
            
            Todo::create([
                'user_id' => $user->id,
                'title' => "Overdue task #{$i} (overdue by {$daysOverdue} days)",
                'description' => "This task is overdue by {$daysOverdue} days",
                'is_completed' => false,
                'due_date' => Carbon::now()->subDays($daysOverdue),
                'target_time' => Carbon::createFromTime(rand(8, 17), [0, 15, 30, 45][rand(0, 3)]),
                'priority' => $priority,
            ]);
        }
    }
}
