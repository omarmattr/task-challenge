<?php

namespace App\Http\Controllers\Api;

use App\Facades\ImageFacade;
use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Task;
use App\Traits\CustomResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    use CustomResponseTrait;
   
    public function tasks(Request $request)
    {
    
        $user = Auth::guard('sanctum')->user();

        $tasks = Task::where('user_id', $user->id)
        ->with('comments.replies', 'image')
        ->get();
        return $this->custom_response(true, 'Tasks', [
            'tasks' => $tasks
        ], 200);
       
      
    }
    public function getAllTasks(Request $request)
    {  
        $tasks = Task::with('comments.replies', 'image')->get();
        return $this->custom_response(true, 'Tasks', [
            'tasks' => $tasks
        ], 200);
      
      }

    public function addTask(Request $request)
    {
        $input = $request->all();
        $validator  = Validator::make($request->all(), [
            'content' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->custom_response(false, 'Validation Error', $validator->errors(), 422);
        }
        $data = (object) $input;
        $user = Auth::guard('sanctum')->user();
        $user_type = $user->type;
        if($user_type == 1 || $user_type == 2){
            return $this->custom_response(false, 'admin can not add task', [], 401);
          }
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imagePath = ImageFacade::uploadImage($request->file('image'))['image'];
            $image = new Image();
            $image->filename = $imagePath;
            $image->imageable_id = $user->id;
            $image->imageable_type = 'App\Models\Task';
            $image->save();
            $data->image_id = $image->id;
        }
       
            $task = new Task();
            $task->user_id = $user->id;
            $task->content = $data->content;
            $task->image_id = $data->image_id ?? null;
            $task->save();
            return $this->custom_response(true, 'Task added successfully', [
                'task' => $task
            ], 201);
        
    }

    public function removeTask(Request $request)
    {
        // Code to remove a task from the database or any other data source
    }
}
