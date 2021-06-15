<?php

namespace App\Http\Controllers\post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Models\Post;
use App\Models\User;
use App\Models\jaime;
use App\Models\categorie_post;

class PostController extends Controller
{
     /**
     * * FUNCTION GET ALL POST
     */
    
    public function getAll(Request $request){
        $user =  $request->user();
        $posts =  Post::all();
        foreach ($posts as $post) {

            $jaime = jaime::where('post_id',$post->id);

            $jaimeUser = jaime::where('user_id',$user->id)->where('post_id',$post->id)->exists();
            if($jaimeUser){


                $post['like'] =true;


            }else{

                $post['like'] =false;
            }

            $post['likeCount'] = $jaime->count();


        }
      return $posts;
    }
    
    /**
     * * FUNCTION GET POST PAR ID 
     */

    public function  getPostId(Request $request){
        $validator = Validator::make($request->all(),[
            'id' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }

        $data = $request->all();
        $user =  $request->user();
        $id = $data['id'];
        if(postExisteId($id)){
            $post = post::find($id);
            $jaime = jaime::where('post_id',$post->id);

            $jaimeUser = jaime::where('user_id',$user->id)->where('post_id',$post->id)->exists();
            if($jaimeUser){


                $post['like'] =true;


            }else{

                $post['like'] =false;
            }

            $post['likeCount'] = $jaime->count();

            return response()->json($post, 200);
        }else{
            return response()->json(['post' => "NotExiste"], 501);

        }



    }

    /**
     *   <<<<<  FUNCTION ADD POST  >>>>>
     */

    public function add(Request $request){
      
        $validator = Validator::make($request->all(),[
            'titre' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user_id' => 'required',
            'categorie_id'=> 'required',
           
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }

        $data = $request->all();

        $user_id = $data['user_id'];

        $categorie_id = $data['categorie_id'];
       
       
        if(userExisteId($user_id)){

            if(categorieExisteId($categorie_id)){
                 
                $data['image'] = uplodeImagePost($request);

                $post = Post::create($data);

                if($post != null){

                    return response()->json(['id' => $post->id], 200);

                }else{

                    return response()->json(['post' => "errorAdd"], 501);

                }

            }else{

                return response()->json(['categorie' => 'notExiste'], 401);

            }

        }else{

            return response()->json(['user' => 'notExiste'], 401);
        }
    }

    /**
     *   <<<<< FUNCTION DELETE POST  >>>>>
     */

    public function delete(Request $request){

        $validator = Validator::make($request->all(),[
            'id' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['error' =>$validator->errors()], 401);
        }

        $data = $request->all();

        $id = $data['id'];

        if(postExisteId($id)){

            $post = Post::find($id);

            $imageName = $post->image;

            Storage::delete('public/images/post/' . $imageName);

            $post->delete();

            if($post != null){

                return response()->json(['post' => 'delete'], 200);

            }else{

                return response()->json(['post' => 'errorAdd'], 401);
            }

        }else{

            return response()->json(['post' => 'notExiste'], 401);
        }
    }

    /**
     *   <<<<<  FUNCTION UPDATE POST
     */

    public function update(Request $request){

        $validator = Validator::make($request->all(),[
            'id' => 'required',
            'titre' => 'required',
            'user_id' => 'required',
            'categorie_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }

        $data = $request->all();

        $id = $data['id'];

        if(postExisteId($id)){

            $user_id = $data['user_id'];

            if(userExisteId($user_id)){

                $categorie_id = $data['categorie_id'];

                if(categorieExisteId($categorie_id)){

                    $post = Post::where('id',$id)
                    ->update([
                        'titre' => $data['titre'],
                        'user_id' => $data['user_id'],
                        'categorie_id' => $data['categorie_id'],
                    ]);

                    if($post != null){

                        return response()->json(['post' => 'update'], 200);

                    }else{

                        return response()->json(['post' => 'errorUpdate' ], 501);

                    }

                }else{

                    return response()->json(['categorie' => 'notExiste'], 401);

                }

            }else{

                return response()->json(['user' => 'notExiste'], 401);

            }

        }else{

            return response()->json(['post' => 'notExiste'], 401);

        }
    }

    /**
     *   <<<<< FUNCTION UPDATE IMAGE POST  >>>>>
     */

    public function updateImage(Request $request){

        $validator = Validator::make($request->all(),[
            'id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }

        $data = $request->all();

        $id = $data['id'];

        if(postExisteId($id)){

            $post = Post::find($id);

            $imageName = $post->image;

            Storage::delete('public/images/post/' . $imageName);

            $post->image = uplodeImagePost($request);

            $post->save();

            if($post != null){


                return response()->json(['post' => 'update'], 200);

            }else{

                return response()->json(['post' => 'errorUpdate'], 501);

            }

        }else{

            return response()->json(['post' => 'notExiste'], 401);

        }

    }
}

/**
 *   <<<<<  FUNCTION  >>>>>
 */

function postExisteId(int $id){

    $res = Post::where('id',$id)->exists();

    if($res){

        return true;

    }else{

        return false;

    }

}

function userExisteId(int $id){

    $res = User::where('id',$id)->exists();

    if($res){

        return true;

    }else{

        return false;

    }

}

function  categorieExisteId(int $id){

    $res = categorie_post::where('id',$id)->exists();
    
    if($res){

        return true;

    }else{

        return false;

    }

}

function uplodeImagePost(Request $request){

    $imageName = time().'.'.$request->image->extension();

    $request->image->storeAs('public/images/post', $imageName);

    return $imageName;

}