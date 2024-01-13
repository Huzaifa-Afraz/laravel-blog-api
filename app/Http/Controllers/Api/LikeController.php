<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
class LikeController extends Controller
{
    //
    public function likeordislike($id){
        $post=Post::find($id);
        if(!$post){
          return response([
              'msg'=>'Post not found'

          ],403);
        }
        $like=$post->likes()->where('user_id', auth()->user()->id)->first();
        if(!$like){
            Like::create(
                
                    ['post_id'=>$id,
                    'user_id'=>auth()->user()->id
                    ]
                
            );
            return response([
                'msg'=>'liked'
    
            ],200);

        }
        
        $like->delete();
        return response([
            'msg'=>'disliked'

        ],200);

    }
}
