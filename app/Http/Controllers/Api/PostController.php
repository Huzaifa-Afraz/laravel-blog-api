<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
class PostController extends Controller
{
    //
    public function index(){
        return response([
           'posts'=>Post::orderBy('created_at','desc')->with('user:id,name,image')->withCount('comments','likes')->get()
        ],200);
    }

    public function show($id){
        return response([
            'post'=>Post::where('id',$id)->withCount('comments','Likes')->get()

        ],200);}
// create a post 
    public function store(Request $request){
        $data=$request->validate([
            'body'=>'string|required'
        ]);
        $post=Post::create([
            'body'=>$data['body'],
            'user_id'=>auth()->user()->id

        ]);
        return response([
            'msg'=>'post successfully created',
            'post'=>$post
        ],200);

    }

    // update a post 
    public function update(Request $request, $id){
          $post=Post::find($id);
          if(!$post){
            return response([
                'msg'=>'Post not found'

            ],403);
          }
          if($post->user_id !=auth()->user()->id){
            return response([
                'msg'=>'Permission denied.'

            ],403);
          }

        $data=$request->validate([
            'body'=>'string|required'
        ]);
        $post->update([
            'body'=>$data['body']
        ]);
        return response([
            'msg'=>'post updated successfully',
            'post'=>$post
        ],200);

    }

    public function destroy($id){
        $post=Post::find($id);
        if(!$post){
          return response([
              'msg'=>'Post not found'

          ],403);
        }
        if($post->user_id !=auth()->user()->id){
          return response([
              'msg'=>'Permission denied.'

          ],403);
        }
        $post->comments()->delete();
        $post->Likes()->delete();
        $post->delete();
        return response([
            'msg'=>'post deleted successfully',
            'post'=>$post
        ],200);
    }
}
