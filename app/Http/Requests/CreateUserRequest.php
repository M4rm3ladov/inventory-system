<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'mi' => 'nullable|min:2',
            'suffix' => 'nullable|min:2',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|confirmed|min:6',
            'branch_id' => 'exists:branches,id',
            'role_id' => 'exists:roles,id',
        ];
    }
}
