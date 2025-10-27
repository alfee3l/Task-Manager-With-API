<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public function AddFavoriteTasks($taskId)
    {
        Task::findOrFail($taskId);
        Auth::user()->favoriteByTasks()->syncWithoutDetaching($taskId);
        return response()->json('Task added to favorites successfully', 201,);
    }
    public function getFavoriteTasks()
    {
        $favorites =  Auth::user()->favoriteByTasks()->get();
        return response()->json($favorites, 200,);
    }
    public function DeleteFavoriteTasks($taskId)
    {
        Task::findOrFail($taskId);
        Auth::user()->favoriteByTasks()->detach($taskId);
        return  response()->json(['message' => 'task deleted to favorites'], 200);
    }



    public function addCategoriesToTask(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->categories()->attach($request->category_id);
        return response()->json('Category attached successfully', 200,);
    }

    public function getTaskCategories($taskId)
    {
        $categories = Task::findOrFail($taskId)->categories;
        return response()->json($categories, 200,);
    }

    public function getCategoryTasks($categoryId)
    {
        $tasks = Category::findOrFail($categoryId)->tasks;
        return response()->json($tasks, 200,);
    }

    function index()
    {
        $tasks = Auth::user()->tasks;
        return response()->json($tasks, 200);
    }
    function getAllTasksByPriority()
    {
        $tasks = Auth::user()->tasks()->orderByRaw("FIELD(priority,'high','medium','low')")->get();
        return response()->json($tasks, 200);
    }
    function getAllTasks()
    {
        $tasks = Task::all();
        return response()->json($tasks, 200);
    }
    function store(StoreTaskRequest $request)
    {
        $user_id = Auth::user()->id;
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user_id;
        $task =  Task::create($validatedData);
        return response()->json($task, 201,);
    }
    function update(UpdateTaskRequest $request, $id)
    {
        $user_id = Auth::user()->id;
        $task = Task::findOrFail($id);
        if ($task->user_id != $user_id) {
            return response()->json(['message' => 'You are not authorized to update this task'], 203,);
        }
        $task->update(
            $request->validated()
        );
        return response()->json($task, 200,);
    }
    function show($id)
    {
        $task = Task::find($id);
        return response()->json($task, 200,);
    }
    function destroy($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();
            return response()->json('Task deleted successfully', 200,);
        } catch (ModelNotFoundException $m) {
            return response()->json([
                'error' => 'task not found ',
                'details' => $m->getMessage(),

            ], 404,);
        } catch (Exception $m) {
            return response()->json([
                'error' => 'something went wrong while deleting task ',
                'details' => $m->getMessage()

            ], 404,);
        }
    }

    function getTasksUser($id)
    {

        $user = Task::findOrFail($id)->user;

        return response()->json($user, 200,);
    }
}
