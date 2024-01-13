<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
class CommentController extends Controller
{
    //get all comments for a post
    public function index($id){
        $post=Post::find($id);
        if(!$post){
          return response([
              'msg'=>'comment not found'

          ],403);
          
        }
        return response([
            'comment'=>$post->comments()->with('user:id,name,image')->get()
        ],200);
    }


    //create a comment
    public function store(Request $request, $id){
        $post=Post::find($id);
        if(!$post){
          return response([
              'msg'=>'comment not found'

          ],403);
          
        }
        $data=$request->validate([
            'comment'=>'string|required'
        ]);

        Comment::create([
            'comment'=>$data['comment'],
            'post_id'=>$id,
            'user_id'=>auth()->user()->id
        ]);
        return response([
            'msg'=>"commet created.",
        ],200);
    }

    // update a comment
    public function update(Request $request, $id){
        $comment=Comment::find($id);
        if(!$comment){
            return response([
                'msg'=>'comment not found'
  
            ],403);
          }
          if($comment->user_id !=auth()->user()->id){
            return response([
                'msg'=>'Permission denied.'

            ],403);
          }
          $data=$request->validate([
            'comment'=>'string|required'
        ]);
        $comment->update([
            'comment'=>$data['comment']

        ]);
        return response([
            'msg'=>"comment updated.",
        ],200);

    }
    public function destroy($id){
        $comment=Comment::find($id);
        if(!$comment){
            return response([
                'msg'=>'comment not found'
  
            ],403);
          }
          if($comment->user_id !=auth()->user()->id){
            return response([
                'msg'=>'Permission denied.'

            ],403);
        
    }
    $comment->delete();
    return response([
        'msg'=>"comment deleted.",
    ],200);
}
}
