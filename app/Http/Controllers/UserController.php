<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{


    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'email' => 'required|string|email|max:200|unique:users,email,',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        Mail::to($user->email)->send(new WelcomeMail($user));
        return response()->json([
            'message' => 'User created successfully',
            'User' => $user
        ], 201);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if (!Auth::attempt($request->only('email', 'password')))
            return response()->json(['message' => 'invalid email or password'], 401,);
        $user =  User::where('email', $request->email)->FirstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => ' login successfully',
            'User' => $user,
            'Token' => $token
        ], 201);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => ' logout successfully',

        ]);
    }





    function getUserProfile($id)
    {
        $profile = User::find($id)->profile;

        return response()->json($profile, 200,);
    }
    function getUserTasks($id)
    {
        $tasks = User::findOrFail($id)->tasks;

        return response()->json($tasks, 200,);
    }
    public function getUser()
    {
        $user = Auth::user()->id;
        $userData = User::with('profile')->findOrFail($user);
        return new UserResource($userData);
    }
    public function getUserAll()
    {
        $userData = User::with('profile')->get();
        return  UserResource::collection($userData);
    }
}
