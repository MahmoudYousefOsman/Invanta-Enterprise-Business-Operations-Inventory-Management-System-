<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
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
        'name' => [
            'required',
            'string',
            'max:255',
            Rule::unique('roles', 'name')->ignore($this->role),
        ],
        'permissions' => 'required|array',
        'permissions.*' => 'exists:permissions,id'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Role name is required.',
            'name.string' => 'Role name must be a string.',
            'name.max' => 'Role name cannot be longer than 255 characters.',
        ];
    }
}
