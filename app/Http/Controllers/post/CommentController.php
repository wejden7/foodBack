<?php

namespace App\Http\Controllers\post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Post;
use App\Models\comment;
use App\Models\User;

class CommentController extends Controller
{
    public function getAllCommentPostId(Request $request){

        $validator = Validator::make($request->all(),[
            'post_id' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }

        $data = $request->all();

        $post_id = $data['post_id'];

        $Lists=[];

        if(postExisteId($post_id)){

            $commments = post::find($post_id)->comment()->get();

            foreach($commments as $comment){
                $user = User::find($comment->user_id);
                $comment['name']=$user->name;
                            if($comment->type == "comment"){


                               
                                $comment['repande'] = setComment($commments,$comment);

                                $Lists[]=$comment;
                            }

            }
            return $Lists;
        }else{

            return response()->json(['post' => "NotExiste"], 501);

        }

    }
}
function setComment($commments,$comment){
    $repande=[];

    foreach($commments as $comment2){
       
        if($comment2->id_repondre == $comment->id && $comment2->type == "repondre"){
            
            $comment2['repande'] = setComment($commments,$comment2);

            $repande[]=$comment2;
            
        }

    }
    return $repande;
}

function postExisteId(int $id){

  return  $res = Post::where('id',$id)->exists();

}