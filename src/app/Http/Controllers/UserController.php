<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use Hash;
use Str;
use Socialite;

class UserController extends Controller
{
	public function register(Request $request) {

		$validatedData = $request->validate([
            'name'=>'required|max:55',
            'email'=>'email|required|unique:users',
            'password'=>'required|confirmed'
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user'=> $user, 'access_token'=> $accessToken]);
    }

    public function login(Request $request) {

    	$loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
       
        if(!auth()->attempt($loginData)) {
            return response(['message'=>'Invalid credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }

    public function logout(Request $request) {
    	
    	$user = User::where("email" , '=', $request->email)->first();

    	$user->AauthAcessToken()->delete();

    	return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function signin() {
    	return Socialite::driver("github")->redirect();
    }

    public function redirect() {
    	
    	$user = Socialite::driver("github")->user();

    	$user = User::firstOrCreate([
    			"email" => $user->email
    		],
    		[
    			"name" => "name",
    			"password" => Hash::make(Str::random(24)),
    		]
    	);
  
    	auth()->user()->createToken('authToken')->accessToken;

		return response()->json([
	        'message' => 'Successfully logged in with github account'
	    ]);

    }
}
