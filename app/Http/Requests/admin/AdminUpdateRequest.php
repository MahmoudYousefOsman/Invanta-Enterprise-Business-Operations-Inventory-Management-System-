<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUpdateRequest extends FormRequest
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
        // dd(Rule::unique('admins', 'email')->ignore($this->route('admin')->id));
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('admins', 'email')->ignore($this->route('admin')->id)],
            'password' => ['nullable', 'string', 'confirmed'],
            'profile_pic' => ['nullable', 'file', 'image'],
            'active' => ['nullable', 'boolean'],
            'role' => ['required'],
        ];
    }
}
