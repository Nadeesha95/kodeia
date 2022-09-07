<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
        ]);
    
    if($validator->fails()){
    
    
        return response()->json([
    
            'validate_err'=>$validator->messages(),
    
        ]);
    
    
    }else{
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
    
       $token = $user->createToken('myapptoken')->plainTextToken;// Simple user role
    
        return response()->json([
    
            'status'=>200,
            'username'=>$user->name,
            'token'=>$token,
            'message'=>'Registered successfully ',
    
        ]);
    
    
    
    
    
    }
    
    }








    public function login(Request $request)
{
 

    $validator = Validator::make($request->all(), [
        'email' => 'email|required',
        'password' => 'required'
    ]);

if($validator->fails()){


    return response()->json([

        'validate_err'=>$validator->messages(),

    ]);


}else{


    $credentials = request(['email', 'password']);
    if (!auth()->attempt($credentials)) {
        return response()->json([
            'message' => 'The given data was invalid.',
            'status'=>401,
          
        ], 401);
    }

    $user = User::where('email', $request->email)->first();
    $authToken = $user->createToken('auth-token')->plainTextToken;

    return response()->json([
        'status'=> 200,
        'auth_token' => $authToken,
        'auth_name' => $user->name,
    ]);
}


}



public function logout(){


 auth()->user()->tokens()->delete();
 Cookie::queue(Cookie::forget('laravel_session'));

 return response()->json([

    'status'=> 200,
    'message'=>'logout sussesfully'

 ]);



}








}
