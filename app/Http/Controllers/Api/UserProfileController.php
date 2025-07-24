<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateProfileRequest;
use App\Http\Resources\UserProfileResource;
use App\Http\Traits\UserResponseTrait;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    use UserResponseTrait;

    public function show(Request $request)
    {
        return $this->success(new UserProfileResource($request->user()), 'User profile fetched');
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        $user->update(collect($data)->except('photo')->toArray());

        if ($request->hasFile('photo')) {
            $user->clearMediaCollection('user_photo');
            $user->addMediaFromRequest('photo')->toMediaCollection('user_photo');
        }

        return $this->success(new UserProfileResource($user), 'Profile updated successfully');
    }
}
