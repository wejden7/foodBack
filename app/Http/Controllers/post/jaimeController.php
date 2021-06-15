<?php

namespace App\Http\Controllers\post;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\jaime;

class jaimeController extends Controller
{

    /**
     *  * FUNCTION ADD JAIME 
    */

    public function jaimePostAdd(Request $request){
        
        $validator = Validator::make($request->all(),[
            'post_id' => 'required',           
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }

        $data = $request->all();

        $post_id = $data['post_id'];

        $user_id =  $request->user()->id;

        $data['user_id'] = $user_id;

        if(postExisteId($post_id) && userExisteId($user_id)){

            if(!jaimePostExiste($post_id,$user_id)){
                
                $jaime = jaime::create($data);

                if($jaime != null){

                    return response()->json(['jaime' => 'Add'], 200);

                }else{

                    return response()->json(['jaime' => "errorAdd"], 501);

                }



            }else{

            return response()->json(['jaime' => "existe"], 501);

            }

        }else{

            return response()->json(['error' => "PostUser"], 501);

        }
    }

    public function jaimePostDelete(Request $request){

        $validator = Validator::make($request->all(),[
            'post_id' => 'required',
                     
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }

        $data = $request->all();

        $post_id = $data['post_id'];

        $user_id =  $request->user()->id;

        $data['user_id'] = $user_id;


        if(postExisteId($post_id) && userExisteId($user_id)){

            if(jaimePostExiste($post_id,$user_id)){
                
                $jaime = jaime::where('post_id',$post_id)->where('user_id',$user_id);

                $jaime->delete();

                if($jaime != null){

                    return response()->json(['jaime' => 'delete'], 200);

                }else{

                    return response()->json(['jaime' => "errorAdd"], 501);

                }



            }else{

            return response()->json(['jaime' => "notExiste"], 501);

            }

        }else{

            return response()->json(['error' => "PostUser"], 501);

        }
    }



}
function postExisteId(int $id){

   return $res = Post::where('id',$id)->exists();

   

}

function userExisteId(int $id){

  return  $res = User::where('id',$id)->exists();


}

function jaimePostExiste(int $post_id ,int $user_id){
    return $res = jaime::where('post_id',$post_id)->where('user_id',$user_id)->exists();

}