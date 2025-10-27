<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::get('tasks',[TaskController::class,'index']);
// Route::post('tasks',[TaskController::class,'store']);
// Route::put('tasks/{id}',[TaskController::class,'update']);
// Route::get('tasks/{id}',[TaskController::class,'show']);
 Route::delete('tasks/{id}',[TaskController::class,'destroy']);

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('', [UserController::class, 'getUser']);
        Route::get('/all', [UserController::class, 'getUserAll']);
        Route::get('/{id}/tasks', [UserController::class, 'getUserTasks']);
        Route::get('/{id}/profile', [UserController::class, 'getUserProfile']);
    });
    Route::prefix('profile')->group(function () {
        Route::post('', [ProfileController::class, 'store']);
        Route::get('/{id}', [ProfileController::class, 'show']);
        Route::put('/{id}', [ProfileController::class, 'update']);
    });
    Route::prefix('tasks')->group(function () {
        Route::get('/{id}/user', [TaskController::class, 'getTasksUser']);
        Route::apiResource('', TaskController::class);
        Route::post('/{taskId}/categories', [TaskController::class, 'addCategoriesToTask']);
        Route::get('/{taskId}/categories', [TaskController::class, 'getTaskCategories']);
        Route::get('tasks/all', [TaskController::class, 'getAllTasks'])->middleware('CheckUser');
        Route::get('/ordered', [TaskController::class, 'getAllTasksByPriority']);
        Route::get('/favorites', [TaskController::class, 'getFavoriteTasks']);
        Route::post('/{taskId}/favorite', [TaskController::class, 'AddFavoriteTasks']);
        Route::delete('/{taskId}/favorite', [TaskController::class, 'DeleteFavoriteTasks']);
    });
    Route::prefix('category')->group(function () {
        Route::get('/{categoryId}/tasks', [TaskController::class, 'getCategoryTasks']);
    });
});
