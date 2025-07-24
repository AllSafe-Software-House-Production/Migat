<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Resources\Admin\UserResource;
use App\Http\Traits\UserResponseTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use UserResponseTrait;

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)
            ->where('role', 'admin')
            ->orWhere('role', 'superAdmin')
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->fail(__('Invalid credentials'), 401);
        }

        $token = $user->createToken('admin_token')->plainTextToken;
        $user->token = $token;

        return $this->success(new UserResource($user), __('Login successful'));
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(null, __('Logout successful'));
    }
}
