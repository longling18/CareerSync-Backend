<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(UserRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
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
