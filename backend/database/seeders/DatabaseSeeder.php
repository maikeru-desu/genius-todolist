<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users if they don't exist
        if (User::count() === 0) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

            User::factory()->create([
                'name' => 'Test User 2',
                'email' => 'test2@example.com',
            ]);
            
            // Create a few more random users
            User::factory(3)->create();
        }
        
        // Seed todos
        $this->call([
            TodoSeeder::class,
        ]);
    }
}
