<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::resource('categories', CategoryController::class);
Route::resource('tasks', TaskController::class);

// Rotas adicionais para tarefas
Route::patch('/tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggleComplete'])->name('tasks.toggle');