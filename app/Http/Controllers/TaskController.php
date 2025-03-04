<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // public function store(Request $request ){
    //     $task=Task::create(
    //        [
    //         'title' =>$request->title,
    //         'description' =>$request->description,
    //         'priority'=>$request->priority
    //        ]
    //     );
    //     return  response()->json($task, 201);
    // }


    //this add validate

    public function getTaskByPriority(){
        $task=Auth::user()->tasks()->orderByRaw("FIELD(priority,'high','medium','low')")->get();
        return  response()->json($task, 200);
    }
    public function getAllTasks(){
        $task=Task::all();
        return  response()->json($task, 200);
    }
    public function index(){
        $task=Auth::user()->tasks;
        return  response()->json($task, 200);
    }
    public function store(StoreTaskRequest $request ){
        $user_id=Auth::user()->id;
        $validatedData=$request->validated();
        $validatedData['user_id']=$user_id;
        $task= Task::create($validatedData);
        return  response()->json($task, 201);
    }


    // public function update(Request $request,$id ){
    //     $task=Task::find($id);
    //     $task->update(

    //         $request->All(),

    //     );
    //     return  response()->json($task, 200);
    // }


    //this add validate
    public function update(UdateTaskRequest $request,$id ){
       $user_id=Auth::user()->id;
       $task=Task::findOrFail($id);
       if($task->user_id!=$user_id){
       return  response()->json(['message'=>'unauthorized'], 403);
       }
        $task->update(
            $request->validated(),
        );
        return  response()->json($task, 200);
    }
    public function show($id ){
        $task=Task::find($id);
        return  response()->json($task, 200);
    }
    public function destroy($id ){
        $task=Task::findOrFail($id);
        $task->delete();
        return  response()->json(null, 204);
    }
    public function getTasksUser($id){

        $user = Task::findOrFail($id)->user;
        return  response()->json($user, 200);
    }

    public function AddCategoriesToTask(Request $request,$taskId){
          $task=Task::findOrFail($taskId);
          $task->categories()->attach($request ->category_id);
          return response()->json('Category attached successfully', 200);
    }

    public function getTaskCategories($taskId){
        $categories = Task::findOrFail($taskId)->categories;
        return  response()->json($categories, 200);
    }
    //فيبه مشكلة
    // public function getCategoriesTasks($taskId){
    //     $task = Task::findOrFail($taskId);
    //     $tasks = $task->categories()->with('tasks')->get()->pluck('tasks')->flatten();
    //     return response()->json($tasks, 200);
    // }



     public function addToFavorite($taskId){
        Task::findOrFail($taskId);
       Auth::user()->favoriteTasks()->syncWithoutDetaching($taskId);
       return response()->json(['message'=>'Task added to favorite'], 200,);
     }
      public function removeFromFavorite($taskId){
        Task::findOrFail($taskId);
        Auth::user()->favoriteTasks()->detach($taskId);
        return response()->json(['message'=>'Task removed from favorite'], 200,);

     }
     public function getFavoriteTasks(){
        $favoriteTasks = Auth::user()->favoriteTasks;
        if ($favoriteTasks->isEmpty()) {
            return response()->json(['message' => 'No favorite tasks found'], 404);
        }

        return response()->json($favoriteTasks, 200);
     }


}



