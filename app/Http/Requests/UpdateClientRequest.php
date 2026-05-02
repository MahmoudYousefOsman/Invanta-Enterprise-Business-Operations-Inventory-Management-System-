<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class UpdateClientRequest extends FormRequest
    {
        public function authorize(): bool
        {
            return true;
        }

        public function rules(): array
        {
            $clientId = $this->route('client')->id;

            return [
                'name'       => 'required|string|max:255',
                'phone'      => 'required|string|max:20|unique:clients,phone,' . $clientId,
                'address'    => 'nullable|string|max:255',
                'type'       => 'required|in:repair,purchase',
                'new_client' => 'nullable',
            ];
        }
    }
