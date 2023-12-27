<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(UserRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['The provided email is incorrect.'],
            ]);
        } else if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['The provided password is incorrect!'],
            ]);
        }

        $response = [
            'user'          => $user,
            'token'         => $user->createToken($request->email)->plainTextToken
        ];

        return response($response, 200);
    }

    //Logout using specified resource
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        $response = [
            'message' => 'Logout Successful.'
        ];
        return $response;
    }
}
