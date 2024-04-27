<?php

namespace App\Http\Controllers\Api;

use App\Facades\ImageFacade;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Image;
use App\Traits\CustomResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class CommentController extends Controller
{
   use CustomResponseTrait;
    public function addComment(Request $request)
    {
        $input = $request->all();
        $validator =  Validator::make($request->all(), [
            'content' => 'required',
            'task_id' => 'required|exists:tasks,id',
        ]);
        if ($validator->fails()) {
            return $this->custom_response(false, 'Validation Error', $validator->errors(), 422);
        }
        $data = (object) $input;
        $user = Auth::guard('sanctum')->user();
        $user_type = $user->type;
        if($user_type == 0 && $user->id != $data->task_id){
            return $this->custom_response(false, 'just admins can add comment on ather users task', [], 401);
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
        $comment = new Comment();
        $comment->content = $data->content;
        $comment->commentable_id = $data->task_id;
        $comment->commentable_type = 'App\Models\Task';
        $comment->image_id = $data->image_id ?? null;
        $comment->user_id = $user->id;
        $comment->save();
        return response()->json(['status' => true, 'message' => 'Comment added', 'data' => ['comment' => $comment]], 200);
    }
    public function addReply(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'content' => 'required',
            'comment_id' => 'required|exists:comments,id',
        ]);
        if ($validator->fails()) {
            return $this->custom_response(false, 'Validation Error', $validator->errors(), 422);
        }
        $data = (object) $input;
        $user = Auth::guard('sanctum')->user();
        $user_type = $user->type;
        if($user_type == 0 && $user->id != $data->task_id){
            return $this->custom_response(false, 'just admins can add comment on ather users task', [], 401);
          }
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imagePath = ImageFacade::uploadImage($request->file('image'))['image'];
            $image = new Image();
            $image->filename = $imagePath;
            $image->imageable_id = $user->id;
            $image->imageable_type = 'App\Models\Comment';
            $image->save();
            $data->image_id = $image->id;
        }
        $comment = new Comment();
        $comment->content = $data->content;
        $comment->commentable_id = $data->comment_id;
        $comment->commentable_type = 'App\Models\Comment';
        $comment->image_id = $data->image_id ?? null;
        $comment->user_id = $user->id;
        $comment->save();
        return response()->json(['status' => true, 'message' => 'reply added', 'data' => ['replay' => $comment]], 200);
    }
    public function deleteComment(Request $request)
    {
        $input = $request->all();
        Validator::make($request->all(), [
            'comment_id' => 'required',
        ]);
        $data = (object) $input;
        $user = Auth::guard('sanctum')->user();
        $comment = Comment::where('id', $data->comment_id)->where('user_id', $user->id)->first();
        if ($comment) {
            $comment->delete();
            return response()->json(['status' => true, 'message' => 'Comment deleted', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Comment not found', 'data' => []], 404);
        }
    }
       
}