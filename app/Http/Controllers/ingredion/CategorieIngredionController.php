<?php

namespace App\Http\Controllers\ingredion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\categorie_ingredion;
use App\Models\categorie_unite;

class CategorieIngredionController extends Controller
{
    /**
     *   <<<<<  FUNCTION ADD CATEGORIE INGREDION  >>>>>
     */

    public function add(Request $request){
        $validator = Validator::make($request->all(),[ 
            'label' => 'required', 
            'categorie_unite_id' => 'required'
        ]);

        if ($validator->fails()){ 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $data = $request->all();

        $label = $data['label'];

        if(!categorieIngredionExisteLabel($label)){

            $categorie_unite_id = $data['categorie_unite_id'];

            if(categorieUniteExisteId($categorie_unite_id)){

                $categorieIngredion = categorie_ingredion::create($data);

                return response()->json(['categorieIngredion' => 'add'], 200);

            }else{

                return response()->json(['categorieUnite' => 'notExiste'], 401);

            }

        }else{

            return response()->json(['categorieIngredion' => 'existe'], 401);
        }

    }

    /**
     *   <<<<<  FUNCTION DELETE CATEGORIE INGREDION  >>>>> 
     */
    
    public function delete(Request $request){

        $validator = Validator::make($request->all(),[ 
            'id' => 'required', 
        ]);

        if ($validator->fails()){ 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $data = $request->all();

        $id = $data['id'];

        if(categorieIngredionExisteId($id)){

            $categorieIngredion =  categorie_ingredion::find($id);
            
            $categorieIngredion->delete();

            return response()->json(['categorieIngredion' => 'delete'], 200);

        }else{

            return response()->json(['categorieIngredion' => 'notExiste'], 401);

        }

    }

    /**
     *   <<<<<  FUNCTION UPDATE CATEGORIE INGREDION  >>>>>
     */

    public function update(Request $request){

        $validator = Validator::make($request->all(),[ 
            'id' => 'required', 
            'label' => 'required', 
            'categorie_unite_id' => 'required'
        ]);

        if ($validator->fails()){ 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $data = $request->all();

        $id = $data['id'];

        if(categorieIngredionExisteId($id)){
            
            $categorie_unite_id = $data['categorie_unite_id'];

            if(categorieUniteExisteId($categorie_unite_id)){

                $categorieIngredion = categorie_ingredion::where('id',$id)
                ->update([
                    'label' => $data['label'],
                    'categorie_unite_id' => $data['categorie_unite_id']
                ]);
    
                return response()->json(['categorieIngredion' => 'update'], 200);

            }else{

                return response()->json(['categorieUnite' => 'notExiste'], 401);
            }

        }else{

            return response()->json(['categorieIngredion' => 'notExiste'], 401,);
        }



    }
    
}

/**
 *   <<<<<  FUNCTION  >>>>>
 */

function categorieIngredionExisteLabel(String $label){

    $res = categorie_ingredion::where('label',$label)->exists();

    if($res){

        return true;

    }else{

        return false;

    }

}

function categorieIngredionExisteId(int $id){

    $res = categorie_ingredion::where('id',$id)->exists();

    if($res){

        return true;

    }else{

        return false;

    }

}

function categorieUniteExisteId(int $id){

    $res = categorie_unite::where('id',$id)->exists();

    if($res){

        return true;

    }else{

        return false;

    }

}


