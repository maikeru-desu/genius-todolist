<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Todo\CreateTodoAction;
use App\Actions\Todo\DeleteTodoAction;
use App\Actions\Todo\GetTodoAction;
use App\Actions\Todo\ListTodosAction;
use App\Actions\Todo\UpdateTodoAction;
use App\Http\Requests\CreateTodoRequest;
use App\Http\Requests\DeleteTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Models\Todo;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class TodoController extends Controller
{
    /**
     * Display a listing of the todos.
     */
    public function index(Request $request, ListTodosAction $action): JsonResponse
    {
        try {
            $todos = $action->handle($request->user(), $request->all());

            return $this->paginatedResponse($todos);
        } catch (Exception $th) {
            return $this->errorResponse($th->getMessage(), $th->getCode());
        }
    }

    /**
     * Store a newly created todo.
     */
    public function store(CreateTodoRequest $request, CreateTodoAction $action): JsonResponse
    {
        try {
            $todo = $action->handle($request->user(), $request->validated());

            return $this->successResponse($todo, 'Todo created successfully', 201);
        } catch (Exception $th) {
            return $this->errorResponse($th->getMessage(), $th->getCode());
        }
    }

    /**
     * Display the specified todo.
     */
    public function show(Todo $todo, GetTodoAction $action): JsonResponse
    {
        try {
            $todo = $action->handle($todo);

            return $this->successResponse($todo, 'Todo retrieved successfully');
        } catch (Exception $th) {
            return $this->errorResponse($th->getMessage(), $th->getCode());
        }
    }

    /**
     * Update the specified todo.
     */
    public function update(UpdateTodoRequest $request, Todo $todo, UpdateTodoAction $action): JsonResponse
    {
        try {
            $todo = $action->handle($todo, $request->validated());

            return $this->successResponse($todo, 'Todo updated successfully');
        } catch (Exception $th) {
            return $this->errorResponse($th->getMessage(), $th->getCode());
        }
    }

    /**
     * Remove the specified todo.
     */
    public function destroy(DeleteTodoRequest $request, Todo $todo, DeleteTodoAction $action): JsonResponse
    {
        try {
            $action->handle($todo);

            return $this->successResponse(null, 'Todo deleted successfully');
        } catch (Exception $th) {
            return $this->errorResponse($th->getMessage(), $th->getCode());
        }
    }
}
