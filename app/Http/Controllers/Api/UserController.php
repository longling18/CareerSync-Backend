<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function show(Request $request)
    {
        return $request->user();
    }

    public function edit(string $id)
    {
        // Find the user by ID
        $user = User::find($id);
        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json(['user' => $user]);
    }
    public function update(Request $request)
    {
        // Find the user by ID
        $user = $request->user();

        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        // Validate the request data
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);

        // Update the user information
        $user->update($validatedData);

        return response()->json(['message' => 'User updated successfully']);
    }

    public function email(UserRequest $request)
    {

        $user = $request->user();
        $validated = $request->validated();
        $user->email = $validated['email'];
        $user->save();
        return $user;
    }

    public function password(Request $request)
    {
        $user = $request->user();

        // Validate the request data
        $validatedData = $request->validate([
            'current_password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        // Check if the current password matches the user's stored password
        if (!Hash::check($validatedData['current_password'], $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 422);
        }

        // Update the user's password
        $user->password = Hash::make($validatedData['new_password']);
        $user->save();

        return response()->json(['message' => 'Password updated successfully']);
    }
    public function destroy(UserRequest $request)
    {

        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Detach the reviews associated with the user
        $user->reviews()->delete();

        // Now you can safely delete the user
        $user->delete();

        return response()->json(['message' => 'Account deleted successfully']);
    }
}
