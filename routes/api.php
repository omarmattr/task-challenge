<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login'])
->name('login');

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
->name('logout');

Route::middleware(['auth:sanctum'])->group(function () {

Route::get('tasks', [TaskController::class, 'tasks'])
->name('tasks');

Route::post('tasks/add-task', [TaskController::class, 'addTask'])
->name('add-task');

Route::post('tasks/add-comment', [CommentController::class, 'addComment']);
Route::post('tasks/add-reply', [CommentController::class, 'addReply']);
Route::get('tasks/all-tasks', [TaskController::class, 'getAllTasks'])->middleware('adminAuth');

});