<?php

namespace App\Http\Controllers\unite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\unite as UniteModel;
use App\Models\categorie_unite;
use App\Models\categorie_ingredion;

class Unite extends Controller
{
    /** 
     * * Get  All Unite par categorie _id
     */

    public function getUnitesIdCategorie(Request $request){

        $validator = Validator::make($request->all(),[
            'categorie_id' => 'required'
        ]);

        if($validator->fails()){
             return response()->json(['error'=>$validator->errors()], 401);
        }

        $data  = $request->all();

        $categorie_Ingredion_Id = $data['categorie_id'];

        $categorie_Ingredion = categorie_unite::find($categorie_Ingredion_Id);
        
        if($categorie_Ingredion != null){

        // ! $res = UniteModel::Where('categorie_id',$categorie_Ingredion->categorie_unite_id)->get();

        $res = categorie_unite::find($categorie_Ingredion_Id)->unites;

        return response()->json($res, 200); 

        }else{

        return response()->json(['categorie_unite'=>' NoteFound'], 501); 

        }
       



    }

    /**
     *  <<<<<  FUNCTION ADD UNITE  >>>>>
     */

    public function add(Request $request){

        $validator = Validator::make($request->all(),[
            'label' => 'required',
            'convert' => 'required',
            'categorie_id' => 'required'
        ]);

        if($validator->fails()){
             return response()->json(['error'=>$validator->errors()], 401);
        }

        $data               = $request->all();

        $label              = $data['label'];

        if(!uniteExisteLabel($label)){

            $categorie_id   = $data['categorie_id'];

            if(categorieUniteExisteId($categorie_id)){

                $unite      = UniteModel::create($data);
            
                return  response()->json(['unite'=>'add'], 200);

            }else{

                return  response()->json(['unite_categorie_id'=>'notExiste'], 401);

            } 

        }else{

            return response()->json(['unite'=>'existe'], 401);
        }
    }

    /**
     *  <<<<<  FUNCTION DELETE UNITE  >>>>>
     */

    public function delete(Request $request){

        $validator = Validator::make($request->all(),[
            'id' => 'required',
        ]);

        if($validator->fails()){
             return response()->json(['error'=>$validator->errors()], 401);
        }

        $data               = $request->all();

        $id                 = $data['id'];

        if(UniteExisteId($id)){
             
            $unite          = UniteModel::find($id);

            $unite->delete();

            return response()->json(['unite'=>'delete'], 200);

        }else{

            return response()->json(['unite'=>'noteExiste'], 401);

        }
    }

    /**
     *  <<<<<  FUNCTION UPDATE UNITE  >>>>>
     */

    public function update(Request $request){

        $validator = Validator::make($request->all(),[
            'id' => 'required',
            'label' => 'required',
            'convert' => 'required',
            'categorie_id' => 'required'
        ]);

        if($validator->fails()){
             return response()->json(['error'=>$validator->errors()], 401);
        }

        $data               = $request->all();

        $id                 = $data['id'];

        if(uniteExisteId($id)){
            
            $categorie_id   = $data['categorie_id'];

            if(categorieUniteExisteId($categorie_id)){

                $unite = UniteModel::where('id',$id)->update([
                    'label' => $data['label'],
                    'convert' => $data['convert'],
                    'categorie_id' => $data['categorie_id'],
                ]);

                return response()->json(['unite'=>'update'], 200);

            }else{

                return response()->json(['unite_categorie_id'=>'notExiste'], 401);

            }
        }else{

            return response()->json(['unite'=>'notExiste'], 401);
        }


    }
}

/**
 *  <<<<<  FUNCTION  >>>>>
 */

 function uniteExisteLabel(String $label){
    $res                    = UniteModel::where('label',$label)->exists();

    if($res){
        return true;
    }else{
        return false;
    }

 }

 function uniteExisteId(int $id){
    $res                    = UniteModel::where('id',$id)->exists();

    if($res){
        return true;
    }else{
        return false;
    }

 }

 function categorieUniteExisteId(int $id){
    $res                    = categorie_unite::where('id',$id)->exists();
    if($res){
        return true;
    }else{
        return false;
    }
 }