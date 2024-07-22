<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => ['required', 'min:3', 'max:50'],
            'user_name' => ['required', 'alpha_num:ascii', 'min:4', 'max:50', 'unique:users,user_name'],
            'email' => ['required', 'email', 'unique:users,email', 'max:50'],
            'password' => ['required', 'min:6', 'max:32', 'confirmed'],
        ];
    }
}
