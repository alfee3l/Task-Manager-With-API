<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreProfileRequest;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function store(StoreProfileRequest $request)
    {
        $userId=Auth::user()->id;
        $validated=$request->validated();
        $validated['user_id']=$userId;
        if($request->hasFile('image')){
            $path=$request->file('image')->store('my photo','public');
            $validated['image']=$path;  
        }
        $profile = Profile::create($validated);
        return response()->json(['message' => 'Profile created successfully', 'profile' => $profile], 201,);
    }
    public function show($id)
    {
       $profile=Profile::where('user_id', $id)->firstOrFail();
       return response()->json($profile,200);
    }

}
