<?php
    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class EngineerLoginRequest extends FormRequest
    {
        public function rules(): array
        {
            return [
                'email' => 'required|email|exists:engineers,email',
                'password' => 'required|string|min:6',
            ];
        }

        public function messages(): array
        {
            return [
                'email.required' => 'البريد الإلكتروني مطلوب',
                'email.email' => 'صيغة البريد الإلكتروني غير صحيحة',
                'email.exists' => 'هذا البريد غير مسجل لدينا',
                'password.required' => 'كلمة المرور مطلوبة',
                'password.min' => 'كلمة المرور يجب ألا تقل عن 6 أحرف',
            ];
        }
    }
