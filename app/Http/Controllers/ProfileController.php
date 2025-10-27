<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show($id)
    {
        $profile =  Profile::where('user_id', $id)->firstOrFail();
        return response()->json($profile, 200);
    }
    public function store(StoreProfileRequest $request)
    {
        $userId = Auth::user()->id;
        $validatedData = $request->validated();
        $validatedData['user_id'] = $userId;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('my photo', 'public');
            $validatedData['image'] = $path;
        }
        $profile = Profile::create(
            $validatedData
        );
        return response()->json([
            'message' => 'Profile created',
            'profile' => $profile,
        ], 201);
    }
    public function update(UpdateProfileRequest $request, $id)
    {

        $profile = Profile::where('user_id', $id)->firstOrFail()->update(
            $request->validated()
        );
        return response()->json($profile, 201,);
    }
}
