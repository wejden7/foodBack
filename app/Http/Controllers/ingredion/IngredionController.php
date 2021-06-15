<?php

namespace App\Http\Controllers\ingredion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Models\ingredion;
use App\Models\categorie_ingredion;


class IngredionController extends Controller
{
    /**
     *  * FUNCTION GET INGREDION PAR ID
     */

    public function getId(Request $request){
        $validator = Validator::make($request->all(),[ 
            'id' => 'required', 
          
        ]);

        if ($validator->fails()){ 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $data = $request->all();

        $id = $data['id'];
        return response()->json(ingredion::find($id));

    }

    /**
     * * FUNCTION GET ALL INGREDION 
     */

     public function getAll(){

        return ingredion::all();


     }
    /**
     *  * <<<<<  FUNCTION ADD INGREDION  >>>>>
     */

    public function add(Request $request){

        $validator = Validator::make($request->all(),[ 
            'label' => 'required', 
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'categorie_id' => 'required',
        ]);

        if ($validator->fails()){ 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $data = $request->all();

        $label = $data['label'];

        if(!ingredionExisteLabel($label)){

            $categorie_id = $data['categorie_id'];

            if(categorieIngredionExisteId($categorie_id)){

               $data['image'] =  uplodeImageIngredion($request);

                $ingredion = ingredion::create($data);

                return response()->json(['ingredion' => 'add'], 200 );

            }else{

                return response()->json(['categorieIngredion' => 'notExiste'], 401);

            }

        }else{

            return response()->json(['ingredion' => 'existe'], 401, );
        }

    }

    /**
     *   <<<<<  FUNCTION DELETE INGREDION  >>>>>
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

        if(ingredionExisteId($id)){

            $ingredion =  ingredion::find($id);

            $imageName = $ingredion->image;

            Storage::delete('public/images/ingredion/' . $imageName);

            $ingredion->delete();

            return response()->json(['ingrdion' => 'delete'], 200);

        }else{

            return response()->json(['ingredion' => 'notExiste'], 401);

        }

    }

    /**
     *   <<<<<  FUNCTION UPDATE INGREDION  >>>>>
     */

    public function update(Request $request){

        $validator = Validator::make($request->all(),[ 
            'id' => 'required',
            'label' => 'required',
            'categorie_id' => 'required',
        ]);

        if ($validator->fails()){ 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $data = $request->all();

        $id = $data['id'];

        if(ingredionExisteId($id)){

            $categorie_id = $data['categorie_id'];

            if(categorieIngredionExisteId($categorie_id)){

                $ingredion = ingredion::where('id',$id)
                ->update([
                    'label' => $data['label'],
                    'categorie_id' =>$data['categorie_id']
                ]);

                return response()->json(['ingredion' => 'update'], 200);

            }else{

                return response()->json(['categorieIngrdion' => 'notExiste'], 401);
            }

        }else{

            return response()->json(['ingredion' => 'notExiste'], 401);
        }
    }

    /**
     *   <<<<<  FUNCTION UPDATE IMAGE INGREDION  >>>>>
     */
    
    public function updateImage(Request $request){

        $validator = Validator::make($request->all(),[ 
            'id' => 'required', 
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()){ 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $data = $request->all();

        $id = $data['id'];

        if(ingredionExisteId($id)){

            $ingredion = ingredion::find($id);

            $imageName = $ingredion->image;

            Storage::delete('public/images/ingredion/' . $imageName);

            $ingredion->image = uplodeImageIngredion($request);
            
            $ingredion->save();

            return response()->json(['ingredion'=>'update'], 200);

        }else{

            return response()->json(['ingredion' => 'notExiste'], 401);
        }

    }
}

/**
 *   <<<<<  FUNCTION  >>>>>
 */

function ingredionExisteLabel(String $label){

    $res = ingredion::where('label',$label)->exists();

    if($res){

        return true;

    }else{

        return false;

    }
}

function ingredionExisteId(int $id){

    $res = ingredion::where('id',$id)->exists();

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

function uplodeImageIngredion(Request $request){

        $imageName = time().'.'.$request->image->extension();

        $request->image->storeAs('public/images/ingredion', $imageName);

        return $imageName;

}

