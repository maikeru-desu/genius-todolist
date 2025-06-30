<?php

use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// User info route
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Todo resource routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('todos', TodoController::class);
});
