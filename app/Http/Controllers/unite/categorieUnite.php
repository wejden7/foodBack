<?php

namespace App\Http\Controllers\unite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\categorie_unite;

class categorieUnite extends Controller
{

    /**
     *  <<<<<  FUNCTION ADD CATEGORIE UNITE  >>>>
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
      
        if(!categorieUniteExisteLabel($label)){

            $categorieUnite    = categorie_unite::create($data);

            return response()->json(['categorieUnite'=>'add'], 200);

        }else{

            return response()->json(['categorieUnite'=>'existe'], 401);

        }
    }

    /**
     *  <<<<<  FUNCTION DELETE CATEGORIE UNITE  >>>>
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

        if(categorieUniteExisteId($id)){

            $categorieUnite    = categorie_unite::find($id);
        
            $categorieUnite->delete();

            return response()->json(['categorieUnite'=>'delete'], 200);

        }else{

            return response()->json(['categorieUnite'=>'notExiste'], 401);
        }
    }

    /**
     *  <<<<<  FUNCTION UPDATE CATEGORIE UNITE  >>>>
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

        if(categorieUniteExisteId($id)){
            
            $categorieUnite    = categorie_unite::where("id",$id)->update(['label'=>$data['label']]);

            return response()->json(['categorieUnite'=>'update'], 200);


        }else{

            return response()->json(['categorieUnite'=>'notExiste'], 401);
        }


    }
}

/**
*  <<<<<  FUNCTION  >>>>
*/

function categorieUniteExisteLabel(String $label){
  $res                        = categorie_unite::where('label',$label)->exists();
  if($res){
      return true;
  }else{
      return false;
  }

}

function categorieUniteExisteId(int $id){
    $res                     = categorie_unite::where('id',$id)->exists();
    if($res){
        return true;
    }else{
        return false;
    }
  
  }
