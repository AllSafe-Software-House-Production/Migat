<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ForgotPasswordRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\Admin\UserResource;
use App\Http\Traits\UserResponseTrait;
use App\Mail\UserOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    use UserResponseTrait;

    public function register(RegisterRequest $request)
    {
        $otp = rand(100000, 999999);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new UserOtpMail($otp));

        return $this->success([], 'Registered successfully. OTP sent to your email.');
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)
            ->where('role', 'user')
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->fail('Invalid credentials', 401);
        }

        if (!$user->otp_code || $user->otp_expires_at < now()) {
            return $this->fail('Your OTP is not verified or expired.', 403);
        }

        $token = $user->createToken('user_token')->plainTextToken;
        $user->token = $token;

        return $this->success(new UserResource($user), 'Login successful');
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return $this->success(null, 'Logout successful');
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return $this->fail('Email not found in our records.', 404);
        }

        $otp = rand(100000, 999999);
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(10)
        ]);

        Mail::to($user->email)->send(new UserOtpMail($otp));

        return $this->success([], 'OTP has been sent to your email.');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return $this->fail('User not found.', 404);
        }

        if (
            !$user->otp_code ||
            $user->otp_code != $request->otp ||
            $user->otp_expires_at < now()
        ) {
            return $this->fail('Invalid or expired OTP.', 400);
        }

        return $this->success([], 'OTP verified. You can now reset your password.');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return $this->fail('User not found.', 404);
        }

        if (
            !$user->otp_code ||
            $user->otp_code != $request->otp ||
            $user->otp_expires_at < now()
        ) {
            return $this->fail('Invalid or expired OTP.', 400);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        return $this->success([], 'Password has been reset successfully.');
    }
}
