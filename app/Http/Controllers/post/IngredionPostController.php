<?php

namespace App\Http\Controllers\post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\ingredion_post;
use App\Models\ingredion;
use App\Models\post;
use App\Models\unite;


class IngredionPostController extends Controller
{
    /**
     *  * FUNCTION GET ALL INGREDION PAR ID POST
     */

    public function getIngredionIdPost(Request $request){
        $validator = Validator::make($request->all(),[
            'post_id' => 'required',
           
        ]);

        if($validator->fails()){

            return response()->json(['error' => $validator->errors()], 501);
        }

        $data = $request->all();

        $post_id = $data['post_id'];

        if(postExisteId($post_id)){

            $ingredionPosts = post::find($post_id)->ingredionPost()->get();
            
            foreach ($ingredionPosts as $ingredionPost) {

                $unite = unite::find($ingredionPost->unite_id);

                $ingredion = ingredion::find($ingredionPost->ingredion_id);

                $ingredionPost["labelIngredion"]=$ingredion->label;
                
                $ingredionPost["image"] = $ingredion->image;
                
                $ingredionPost["labelUnite"] = $unite->label;
            }

            return response()->json($ingredionPosts,200);
        }else{

            return response()->json(['post' =>"notExist" ], 501);
        }
    }

    /**
     *   <<<<<  FUNCTION ADD INGREDION POST  >>>>>
     */

    public function add(Request $request){

        $validator = Validator::make($request->all(),[
            'count' => 'required|numeric',
            'post_id' => 'required',
            'ingredion_id' => 'required',
            'unite_id' => 'required'
        ]);

        if($validator->fails()){

            return response()->json(['error' => $validator->errors()], 501);
        }

        $data = $request->all();

        $post_id = $data['post_id'];

        $ingredion_id = $data['ingredion_id'];

        $unite_id =  $data['unite_id'];

        if(postExisteId($post_id)){

            if(ingredionExisteId($ingredion_id)){

                if(uniteExisteTd($unite_id)){

                    try{

                        $ingredionPost = ingredion_post::create($data);

                        return response()->json(['ingredionPost' => 'add'], 200);

                    }catch(\Exception $e){

                        return response()->json(['ingredionPost' => $e->errorInfo[2]], 501);

                    }

                }else{

                    return response()->json(['unite' => 'notExiste'], 401);

                }

            }else{

                return response()->json(['ingredion' => 'notExiste'], 401);

            }

        }else{

            return response()->json(['post' => 'notExiste'], 401);

        }
    }

    /**
     *   <<<<<  FUNCTION DELETE INGREDION POST  >>>>>
     */
    
    public function  delete(Request $request){

        $validator = Validator::make($request->all(),[
            'post_id' => 'required',
            'ingredion_id' => 'required',
        ]);

        if($validator->fails()){

            return response()->json(['error' => $validator->errors()], 501);
        }

        $data = $request->all();

        $post_id = $data['post_id'];

        $ingredion_id = $data['ingredion_id'];

        if(ingredionPostExisteId($post_id,$ingredion_id)){

            try{

                $ingredionPost = ingredion_post::where('post_id',$post_id)
                                                ->where('ingredion_id',$ingredion_id)
                                                ->delete();

                return response()->json(['ingredionPost' => 'delete'], 200);

            }catch(\Exception $e){

                return response()->json(['ingredionPost' => 'errorBD'], 401);

            }
                 
        }else{

            return response()->json(['ingredionPost' => 'notExiste'], 401);
        }

    }

    /**
     *   <<<<<  FUNCTION UPDATE INGREDION POST >>>>>
     */

    public function update(Request $request){

        $validator = Validator::make($request->all(),[
            'count' => 'required|numeric',
            'post_id' => 'required',
            'ingredion_id' => 'required',
        ]);

        if($validator->fails()){

            return response()->json(['error' => $validator->errors()], 501);
        }

        $data = $request->all();

        $post_id = $data['post_id'];

        $ingredion_id = $data['ingredion_id'];

        if(ingredionPostExisteId($post_id,$ingredion_id)){

            try{

                $ingredionPost = ingredion_post::where('post_id',$post_id)
                                                ->where('ingredion_id',$ingredion_id)
                                                ->update([
                                                    'count' => $data['count']
                                                    ]);

                return response()->json(['ingredionPost' => 'update'], 200); 

            }catch(\Exception $e){

                return response()->json(['ingredionPost' => 'errorBD'], 501); 

            } 

        }else{

            return response()->json(['ingredionPost' => 'notExiste'], 401);

        }


    }
}

/**
 *      <<<<<  function  >>>>>
 *  
 *        Unite existe par id
 */

function uniteExisteTd(int $id){

   return $res = unite::where('id',$id)->exists();
}

/**
 *      <<<<<  function  >>>>>
 *  
 *        Post existe par id
 */

function postExisteId(int $id){

    return $res = post::where('id',$id)->exists();
}

/**
 *      <<<<<  function  >>>>>
 *  
 *        Ingredion existe par id
 */

function ingredionExisteId(int $id){

    return $res = ingredion::where('id',$id)->exists();
}

/**
 *      <<<<<  function  >>>>>
 *  
 *        ingredion Post existe par id de Post et ingredion
 */

function ingredionPostExisteId(int $post_id,int $ingredion_id){

    return $res = ingredion_post::where('post_id',$post_id)
                                ->where('ingredion_id',$ingredion_id)->exists();

}
