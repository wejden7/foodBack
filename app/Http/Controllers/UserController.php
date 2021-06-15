<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth; 
use App\Models\User;

class UserController extends Controller
{
    
  public function store(Request $request){

        $validator = Validator::make($request->all(),[ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
        ]);

        if ($validator->fails()){ 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $email                  = $request->input('email');
        
        if(!email_existe($email)){
            $data               = $request->all();
            $data['password']   = bcrypt($data['password']);
            $user               = User::create($data);
            $token              = $user->createToken('Access Token')-> accessToken;
           
            return response()->json(['token' => $token,'user' => $user]); 
        }else{
            return response()->json(['error'=>'existe'],501); 
            
        }
    }

  public function login(Request $request)  {

    $credentials    = $request->only('email', 'password');
    
    if(Auth::attempt($credentials)){ 
        $user       = Auth::user();
        $token      = $user->createToken('MyApp')-> accessToken;

        return response()->json(['token' => $token,"user" => $user], 200); 
    } 
    else{ 
        return response()->json(['error'=>'Unauthorised'], 401); 
    } 

  }
    
}

// Function sup de class

function email_existe(String $email){
    $userSaved                  = User::where('email',$email)->get()->count();
        $exist                  = false ;
        if($userSaved!=0){
            $exist              = true;
        }
        return $exist;

}
