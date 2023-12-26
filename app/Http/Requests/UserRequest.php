<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        if (request()->routeIs('user.login')) {
            return [
                'email' => 'required|string|email|max:255',
                'password' => 'required|max:6',
            ];
        } else if (request()->routeIs('user.store')) {
            return [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|confirmed',
            ];
        } else if (request()->routeIs('user.update')) {
            return [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
            ];
        } else if (request()->routeIs('user.email')) {
            return [
                'email' => 'required|email|unique:users,email'
            ];
        } else if (request()->routeIs('user.password')) {
            return [
                'current_password' => 'required|string|min:6',
                'new_password' => 'required|string|min:6'
            ];
        } else  // Default case, return an empty array
            return [];
    }
}
