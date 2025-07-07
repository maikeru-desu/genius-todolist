<?php

use App\Enums\TaskPriority;
use App\Models\Todo;
use App\Models\User;
use function Pest\Laravel\{actingAs, assertDatabaseHas, assertDatabaseMissing, getJson, postJson, putJson, deleteJson};

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user, 'sanctum');

    test()->user = $user;
});


test('authenticated user can list their todos', function () {
    Todo::factory()->count(3)->create([
        'user_id' => test()->user->id,
    ]);

    $anotherUser = User::factory()->create();
    Todo::factory()->create([
        'user_id' => $anotherUser->id,
    ]);

    $response = getJson('/api/todos');

    $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'success',
                'message',
                'meta'
            ]);


    $responseData = $response->json('data');
    expect($responseData)->toHaveCount(3);
});

test('unauthenticated user cannot list todos', function () {
    $this->refreshApplication();
    
    $response = getJson('/api/todos');
    
    $response->assertStatus(401);
});


test('authenticated user can create a todo', function () {
    $todoData = [
        'title' => 'Test Todo',
        'description' => 'This is a test description',
        'due_date' => now()->addDay()->toDateString(),
        'target_time' => '14:30',
        'priority' => TaskPriority::MEDIUM->value,
        'is_completed' => false,
    ];

    $response = postJson('/api/todos', $todoData);

    $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'description',
                    'due_date',
                    'target_time',
                    'priority',
                    'is_completed',
                    'created_at',
                    'updated_at',
                ],
                'success',
                'message',
            ]);

    assertDatabaseHas('todos', [
        'user_id' => test()->user->id,
        'title' => 'Test Todo',
        'description' => 'This is a test description',
    ]);
});

test('todo creation validates required fields', function () {
    $response = postJson('/api/todos', []);

    $response->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
});


test('authenticated user can view their todo', function () {
    $todo = Todo::factory()->create([
        'user_id' => test()->user->id,
    ]);

    $response = getJson("/api/todos/{$todo->id}");

    $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'description',
                    'due_date',
                    'target_time',
                    'priority',
                    'is_completed',
                    'created_at',
                    'updated_at',
                ],
                'success',
                'message',
            ]);

    $response->assertJson([
        'data' => [
            'id' => $todo->id,
            'title' => $todo->title,
        ],
    ]);
});

test('user cannot view another users todo', function () {
    // Create a todo for another user
    $anotherUser = User::factory()->create();
    $todo = Todo::factory()->create([
        'user_id' => $anotherUser->id,
    ]);


    $response = getJson("/api/todos/{$todo->id}");

    $response->assertStatus($response->getStatusCode());
    expect($response->getStatusCode())->toBeIn([403, 404]);
});


test('authenticated user can update their todo', function () {

    $todo = Todo::factory()->create([
        'user_id' => test()->user->id,
        'title' => 'Original Title',
        'is_completed' => false,
    ]);


    $updateData = [
        'title' => 'Updated Title',
        'description' => 'Updated description',
        'is_completed' => true,
        'priority' => TaskPriority::HIGH->value,
    ];


    $response = putJson("/api/todos/{$todo->id}", $updateData);


    $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'success',
                'message',
            ]);


    assertDatabaseHas('todos', [
        'id' => $todo->id,
        'title' => 'Updated Title',
        'description' => 'Updated description',
        'is_completed' => true,
    ]);
});

test('user cannot update another users todo', function () {
    // Create a todo for another user
    $anotherUser = User::factory()->create();
    $todo = Todo::factory()->create([
        'user_id' => $anotherUser->id,
        'title' => 'Another User Todo',
    ]);

    $response = putJson("/api/todos/{$todo->id}", [
        'title' => 'Trying to update',
    ]);

    $response->assertStatus($response->getStatusCode());
    expect($response->getStatusCode())->toBeIn([403, 404]);
    
    assertDatabaseHas('todos', [
        'id' => $todo->id,
        'title' => 'Another User Todo',
    ]);
});


test('authenticated user can delete their todo', function () {

    $todo = Todo::factory()->create([
        'user_id' => test()->user->id,
    ]);

    $response = deleteJson("/api/todos/{$todo->id}");

    $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
            ]);


    assertDatabaseMissing('todos', [
        'id' => $todo->id,
    ]);
});

test('user cannot delete another users todo', function () {
    // Create a todo for another user
    $anotherUser = User::factory()->create();
    $todo = Todo::factory()->create([
        'user_id' => $anotherUser->id,
    ]);


    $response = deleteJson("/api/todos/{$todo->id}");

    $response->assertStatus($response->getStatusCode());
    expect($response->getStatusCode())->toBeIn([403, 404]);    

    assertDatabaseHas('todos', [
        'id' => $todo->id,
    ]);
});
