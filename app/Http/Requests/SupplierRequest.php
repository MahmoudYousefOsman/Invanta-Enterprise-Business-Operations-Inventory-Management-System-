<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class SupplierRequest extends FormRequest
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
            $supplierId = $this->route('supplier')?->id;

            return  [
                'name' => 'required|string|max:255',
                'phone' => 'required|string|regex:/^[0-9]+$/|max:20|min:11|unique:suppliers,phone,' . $supplierId,
                'address' => 'nullable|string|max:500',
                'current_balance' => 'nullable|numeric|min:0',
//                'notes' => 'nullable|string|max:1000',
            ];
        }

        /**
         * Get custom messages for validator errors.
         *
         * @return array<string, string>
         */
        public function messages(): array
        {
            return [
                'name.required' => 'اسم المورد مطلوب',
                'name.string' => 'اسم المورد يجب أن يكون نصاً',
                'name.max' => 'اسم المورد يجب ألا يتجاوز 255 حرفاً',

                'phone.required'      => ' رقم الهاتف مطلوب.',
                'phone.string'=> 'رقم التليفون يحب ان يكون نصا',
                'phone.regex' => 'رقم الهاتف يجب أن يحتوي على أرقام فقط.',
                'phone.max'           => 'رقم الهاتف يجب ألا يزيد عن 20 ارقام.',
                'phone.min'           => 'رقم الهاتف يجب ألا يقل عن 11 ارقام',
                'phone.unique'        => 'رقم الهاتف مستخدم من قبل.',

                'address.string' => 'العنوان يجب أن يكون نصاً',
                'address.max' => 'العنوان يجب ألا يتجاوز 500 حرفاً',

                'current_balance.numeric' => 'الرصيد الحالي يجب أن يكون رقماً',
                'current_balance.min' => 'الرصيد الحالي لا يمكن أن يكون سالباً',

                'notes.string' => 'الملاحظات يجب أن تكون نصاً',
                'notes.max' => 'الملاحظات يجب ألا تتجاوز 1000 حرف',

                'created_at.date' => 'تاريخ الإضافة يجب أن يكون تاريخاً صحيحاً',
            ];
        }
    }
