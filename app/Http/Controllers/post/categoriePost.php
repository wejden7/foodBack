<?php

namespace App\Http\Controllers\post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\categorie_post;

class categoriePost extends Controller
{ 
    /**
     * * FUNCTION GET ALL CATEGORIE
     */
    
    public function getAllCategorie(){

        return  categorie_post::all();
    }

    /**
     *  <<<<<  FUNCTION ADD CATEGORIE POST  >>>>
     */

    public function add(Request $request){

        $validator = Validator::make($request->all(),[ 
            'label' => 'required', 
        ]);

        if ($validator->fails()){ 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $data                 = $request->all();

        $label                = $data['label'];
      
        if(!categoriePostExisteLabel($label)){

            $categoriePost    = categorie_post::create($data);

            return response()->json(['categoriePost'=>'add'], 200);

        }else{

            return response()->json(['categoriePost'=>'existe'], 401);

        }
    }

     /**
     *  <<<<<  FUNCTION DELETE CATEGORIE POST  >>>>
     */

    public function delete(Request $request){

        $validator = Validator::make($request->all(),[ 
            'id' => 'required', 
        ]);

        if ($validator->fails()){ 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $data                 = $request->all();

        $id                   = $data['id'];

        if(categoriePostExisteId($id)){

            $categoriePost    = categorie_post::find($id);
        
            $categoriePost->delete();

            return response()->json(['categoriePost'=>'delete'], 200);

        }else{

            return response()->json(['categoriePost'=>'notExiste'], 401);
        }
    }

     /**
     *  <<<<<  FUNCTION UPDATE CATEGORIE POST  >>>>
     */

    public function update(Request $request){

        $validator = Validator::make($request->all(),[
            'id' =>'required',
            'label'=>'required'
        ]);

        if ($validator->fails()){ 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $data                 = $request->all();

        $id                   = $data['id'];

        if(categoriePostExisteId($id)){
            
            $categoriePost    = categorie_post::where("id",$id)
            ->update([
                'label'=>$data['label']
            ]);

            return response()->json(['categoriePost'=>'update'], 200);


        }else{

            return response()->json(['categoriePost'=>'notExiste'], 401);
        }


    }
}

/**
*    <<<<<  FUNCTION  >>>>>
*/ 

function categoriePostExisteLabel(String $label){
  $res          = categorie_post::where('label',$label)->exists();
  if($res){
      return true;
  }else{
      return false;
  }

}

function categoriePostExisteId(int $id){
    $res                    = categorie_post::where('id',$id)->exists();
    if($res){
        return true;
    }else{
        return false;
    }
  
  }