<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::get('/', function () {
    return redirect()->route('todos.index');
});

Route::resource('todos', TodoController::class);
Route::post('/todos/{todo}/toggle', [TodoController::class, 'toggle'])
    ->name('todos.toggle');