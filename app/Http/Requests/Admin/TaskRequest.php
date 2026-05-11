<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'client_id' => 'required|exists:clients,id',
            'engineer_id' => 'required|exists:engineers,id',
            'device_type' => 'required|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'description' => 'required|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:new,completed,cancelled',
            'cost' => 'required|numeric|min:0',
            'payed' => 'nullable|numeric|min:0|lte:cost',
            'receipt_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:receipt_date',
            'commission' => 'nullable|numeric|min:0',
            'products' => 'nullable|array',
            'products.*.item_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'client_id.required' => 'يجب اختيار العميل.',
            'client_id.exists' => 'العميل المختار غير موجود.',

            'engineer_id.required' => 'يجب اختيار المهندس.',
            'engineer_id.exists' => 'المهندس المختار غير موجود.',

            'device_type.required' => 'نوع الجهاز مطلوب.',
            'device_type.max' => 'نوع الجهاز يجب ألا يزيد عن 255 حرف.',

            'serial_number.max' => 'الرقم التسلسلي يجب ألا يزيد عن 255 حرف.',

            'description.required' => 'الوصف مطلوب.',

            'status.required' => 'الحالة مطلوبة.',
            'status.in' => 'الحالة غير صحيحة.',

            'cost.required' => 'التكلفة مطلوبة.',
            'cost.numeric' => 'التكلفة يجب أن تكون رقم.',
            'cost.min' => 'التكلفة يجب أن تكون رقم موجب.',

            'payed.numeric' => 'المدفوع يجب أن يكون رقم.',
            'payed.min' => 'المدفوع يجب أن يكون رقم موجب.',
            'payed.lte' => 'المبلغ المدفوع لا يجب أن يكون أكبر من التكلفة الإجمالية.',

            'receipt_date.required' => 'تاريخ الاستلام مطلوب.',
            'receipt_date.date' => 'تاريخ الاستلام غير صالح.',

            'due_date.date' => 'تاريخ التسليم غير صالح.',
            'due_date.after_or_equal' => 'تاريخ التسليم يجب أن يكون بعد أو يساوي تاريخ الاستلام.',
        ];
    }
}
