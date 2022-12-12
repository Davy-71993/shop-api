<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserReguest;
use App\Models\User;
use App\Traits\HttpResponses;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginRequest $request){
        $request->validated($request->all());

        if(!Auth::attempt($request->only(['email', 'password']))){
            return $this->error('', 'Invalid credentials', 401);
        }
        $user = User::where('email', $request->email)->first();
        return $this->success([
            'user' => $user,
            'token' => $user->createToken($user->name . "'s API token")->plainTextToken
        ]);
    }

    public function register(StoreUserReguest $request){
        $request->validated($request->all());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return $this->success([
            'user' => $user,
            'token' => $user->createToken($user->name . "'s API token")->plainTextToken
        ]);
    }

    public function logout(){
        Auth::user()->currentAccessToken()->delete();
        return $this->success([
            'message' => 'Logout success',
        ]);
    }
}
