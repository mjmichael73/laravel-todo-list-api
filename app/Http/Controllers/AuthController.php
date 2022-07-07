<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\LoginResource;
use App\Models\User;
use App\Traits\CustomApiResponser;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use CustomApiResponser;

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        if (!$user) {
            return $this->errorResponse([], 'Could not register, try again later');
        }
        return $this->successResponse([], 'Register successfull, try to login', Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
    {
        $result = Auth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ]);
        if (!$result) {
            return $this->errorResponse([], 'Wrong email or password');
        }
        $token = Auth::user()->createToken('mobile_app')->plainTextToken;
        return new LoginResource(Auth::user(), 'Login was successfuly', $token);
    }
}
