<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminStoreRequest extends FormRequest
{
    /**
     * Determine if the users is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:admins'],
            'password' => ['required', 'string', 'confirmed'],
            'profile_pic' => ['nullable', 'file', 'image'],
            'active' => ['nullable', 'boolean'],
            'role' => ['required'],
        ];
    }
}
