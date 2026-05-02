<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class EngineerRequest extends FormRequest
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
        protected function prepareForValidation(): void
        {
            $this->merge([
                'salary' => $this->filled('salary') ? $this->salary : 0,
                'current_balance' => $this->filled('current_balance') ? $this->current_balance : 0,
            ]);
        }
        public function rules(): array
        {
            $engineerId = $this->route('engineer')?->id;

            return [
                'name'    => 'required|string|max:255',
                'phone' => 'required|string|regex:/^[0-9]+$/|max:20|min:11|unique:engineers,phone,' . ($engineerId ?? 'NULL'),
                'email'   => 'required|string|email|max:255|min:11|unique:engineers,email,' . ($engineerId ?? 'NULL'),
                'password' => 'required|string|min:6',
                'new_password'=> 'nullable|string|min:6',
                'address' => 'nullable|string|max:255',
                'current_balance' => 'nullable|numeric',
                'salary' => 'nullable|numeric',
                'notes' => 'nullable|string|max:255',
            ];
        }

        public function messages(): array
        {
            return [
                'name.required'       => 'حقل الاسم مطلوب.',
                'name.string'         => 'حقل الاسم يجب أن يكون نصاً.',
                'name.max'            => 'الاسم يجب ألا يزيد عن 255 حرفاً.',

                'phone.required'      => ' رقم الهاتف مطلوب.',
                'phone.string'=> 'رقم التليفون يحب ان يكون نصا',
                'phone.regex' => 'رقم الهاتف يجب أن يحتوي على أرقام فقط.',
                'phone.max'           => 'رقم الهاتف يجب ألا يزيد عن 20 ارقام.',
                'phone.min'           => 'رقم الهاتف يجب ألا يقل عن 11 ارقام',
                'phone.unique'        => 'رقم الهاتف مستخدم من قبل.',

                'email.required'      => 'حقل البريد الإلكتروني مطلوب.',
                'email.string'        => 'البريد الإلكتروني يجب أن يكون نصاً.',
                'email.email'         => 'يجب إدخال بريد إلكتروني صالح.',
                'email.max'            => 'البريد الإلكتروني يجب ألا يزيد عن 255 حرفاً.',
                'email.unique'        => 'هذا البريد الإلكتروني مستخدم من قبل.',

                'password.required'   => 'حقل كلمة المرور مطلوب.',
                'password.string'     => 'كلمة المرور يجب أن تكون نصاً.',
                'password.min'        => 'كلمة المرور يجب ألا تقل عن 6 أحرف.',
                'new_password.min'        => 'كلمة المرور يجب ألا تقل عن 6 أحرف.',

                'address.string'      => 'العنوان يجب أن يكون نصاً.',
                'address.max'         => 'العنوان يجب ألا يزيد عن 255 حرفاً.',

                'current_balance.numeric' => 'الرصيد الحالي يجب أن يكون رقماً.',
                'salary.numeric'          => 'المرتب يجب أن يكون رقماً.',
            ];
        }
    }
