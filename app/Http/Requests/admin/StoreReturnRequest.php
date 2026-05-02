<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReturnRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', Rule::in(['client','supplier'])],
            'type_id' => 'required|integer',
            'notes' => 'nullable|string',
            'total_price' => 'required|numeric|min:0',

            'products' => 'required|array|min:1',
            'products.*.id' => 'required|integer|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.line_total' => 'nullable|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'نوع المرتجع مطلوب',
            'type.in' => 'نوع المرتجع يجب أن يكون client أو supplier',
            'type_id.required' => 'اختيار العميل/المورد مطلوب',

            'products.required' => 'يجب إضافة منتج واحد على الأقل',
            'products.*.id.required' => 'المنتج مطلوب',
            'products.*.id.exists' => 'المنتج غير موجود',
            'products.*.quantity.required' => 'الكمية مطلوبة',
            'products.*.quantity.min' => 'الحد الأدنى للكمية هو 1',
        ];
    }
}
