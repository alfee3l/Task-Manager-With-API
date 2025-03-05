<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::get('index',[TaskController::class,'index']);
// Route::post('tasks',[TaskController::class,'store']);
// Route::put('tasks/{id}',[TaskController::class,'update']);
// Route::get('tasks/{id}',[TaskController::class,'show']);
// Route::delete('tasks/{id}',[TaskController::class,'destroy']);


Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);
Route::post('logout',[UserController::class,'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function(){

Route::prefix('profile')->group(function(){
Route::post('',[ProfileController::class,'store']);
Route::get('/{id}',[ProfileController::class,'show']);
});

Route::get('user',[UserController::class,'GetUser']);
Route::get('user/{id}/profile',[UserController::class,'getProfile']);
Route::put('user/{id}/profile',[UserController::class,'update']);
Route::get('user/{id}/tasks',[UserController::class,'getUserTasks']);

//This يغني من الراوت الي فوق كامل
Route::apiResource('tasks',TaskController::class)->middleware('auth:sanctum');
Route::get('task/all',[TaskController::class,'getAllTasks'])->middleware('CheckUser');

Route::get('task/ordered',[TaskController::class,'getTaskByPriority']);
Route::get('tasks/{id}/user',[TaskController::class,'getTasksUser']);
Route::post('tasks/{taskId}/categories',[TaskController::class,'AddCategoriesToTask']);
Route::get('tasks/{taskId}/categories',[TaskController::class,'getTaskCategories']);
Route::get('categories/{taskId}/tasks',[TaskController::class,'getCategoriesTasks']);


Route::post('task/{id}/favorite',[TaskController::class,'addToFavorite']);
Route::delete('task/{id}/favorite',[TaskController::class,'removeFromFavorite']);
Route::get('task/favorite',[TaskController::class,'getFavoriteTasks']);

});
