<?php

namespace App\Http\Controllers\post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\etape;
use App\Models\post;

class EtapeController extends Controller
{

    /**
     *  * FUNCTION GET ALL ETTAPE PAR ID POST
    */

    public function getEtapeIdPost(Request $request){

        $validator = Validator::make($request->all(),[
            'post_id' => 'required',
          
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }
        
        $data = $request->all();

        $post_id =$data["post_id"];
     
        if(postExistId($post_id)){

            $list = post::find($post_id)->etape()->get();

              return response()->json($list,200);

        }else{

            return response()->json(["post"=>"NotExist"],501);

        }

    }

    /**
     *   <<<<<  FUNCTION ADD ETAPE  >>>>>
     */

    public function add(Request $request){

        $validator = Validator::make($request->all(),[
            'titre' => 'required',
            'descreption' => 'required',
            'post_id' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }

        $data = $request->all();

        $titre = $data['titre'];

        $post_id = $data['post_id'];

        if(!etapeExisteTitre($titre , $post_id)){

            if(postExistId($post_id)){

                $etape = etape::create($data);

                if($etape != null){

                    return response()->json(['etape' => 'add'], 200);

                }else{

                    return response()->json(['etape' => 'errorAdd'], 501);

                }

            }else{

                return response()->json(['post' => 'notExiste'], 401);

            }

        }else{

            return response()->json(['etape' => 'existe'], 401);

        }
    }

    /**
     *   <<<<<  FUNCTION DELETE ATAPE  >>>>>
     */

    public function delete(Request $request){

        $validator = Validator::make($request->all(),[
            'id'=> 'required' ,
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()],401);
        }

        $data = $request->all();

        $id = $data['id'];

        if(etapeExisteId($id)){

            $etape = etape::find($id);

            $etape->delete();

            if($etape != null){

                return response()->json(['etape' => 'delete'], 200);

            }else{

                return response()->json(['etape' => 'errorDelete'], 501);
            }

        }else{

            return response()->json(['etape' => 'notExiste'], 401);
        }
    }

    /**
     *   <<<<<  FUNCTION UPDATE ETAPE >>>>>
     */

    public function update(Request $request){

        $validator = Validator::make($request->all(),[
            'id' => 'required',
            'titre' => 'required',
            'descreption' => 'required',
            'post_id' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }

        $data = $request->all();

        $id = $data['id'];

        if(etapeExisteId($id)){

            $titre = $data['titre'];

            $post_id = $data['post_id'];

            if(!etapeExisteTitreDifferentId($titre,$id,$post_id)){

                if(postExistId($post_id)){
    
    
                    $etape = etape::where('id',$id)
                                    ->update([
                                        'titre' => $data['titre'],
                                        'descreption' => $data['descreption'],
                                        'post_id' => $data['post_id'],
                                    ]);
                    
                    if($etape != null){
    
                        return response()->json( ['etape' => 'update'], 200);
    
                    }else{
    
                        return response()->json(['etape' => 'errorUpdate'], 501);
                    }
    
                }else{
    
                    return response()->json( ['post' => 'notExiste'], 401);
    
                }

            }else{

                return response()->json(['etape' => 'existe'], 401);
            }

        }else{

            return response()->json(['etape' => 'notExiste'], 401);
        }
        
    }
}

/**
 *   <<<<<  FUNCTION  >>>>>
 */

function etapeExisteTitreDifferentId(String $titre,int $id,$post_id){

    $res = etape::where('titre',$titre)
                    ->where('id','<>',$id)
                    ->where('post_id',$post_id)->exists();

    if($res){

        return true;

    }else{

        return false;

    }

}

function etapeExisteTitre(String $titre,int $id){

    return   $res = etape::where('titre',$titre)
                    ->where('post_id',$id)->exists();

}

function etapeExisteId(int $id){

    return  $res = etape::where('id',$id)->exists();

}

function postExistId(int $id){

    return  $res = post::where('id',$id)->exists();

}


