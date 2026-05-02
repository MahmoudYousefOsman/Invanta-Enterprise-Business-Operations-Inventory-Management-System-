<?php
    namespace App\Http\Requests;

    use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    use Illuminate\Foundation\Http\FormRequest;

    class StorePurchaseRequest extends FormRequest
    {
        public function authorize(): bool
        {
            return true;
        }

        public function rules(): array
        {

            return [
                'supplier_id'         => ['required', 'exists:suppliers,id'],
                'purchase_date'       => ['nullable', 'date'],
                'products'            => ['required', 'array', 'min:1'],
                'products.*.id'       => ['required', 'exists:products,id'],
                'products.*.quantity' => ['required', 'integer', 'min:1'],
//                'products.*.price'     => ['required', 'numeric', 'min:0'],
                'invoice_type' => 'required|in:paid,unpaid,partial',
                'paid_amount' => 'nullable|numeric|min:0',
                'remaining_amount' => 'nullable|numeric|min:0',
                'date' => 'required|date',
            ];
        }

        public function messages(): array
        {
            return [
                'supplier_id.required' => 'يجب اختيار المورد.',
                'invoice_type.required' => 'يجب اختيار نوع الفاتورة.',

                'supplier_id.exists' => 'المورد المحدد غير موجود.',
                'purchase_date.date' => 'تاريخ الشراء غير صالح.',
                'products.required' => 'يجب إضافة منتج واحد على الأقل.',
                'products.min' => 'يجب إضافة منتج واحد على الأقل.',
                'products.*.id.required' => 'معرف المنتج مطلوب.',
                'products.*.id.exists' => 'هذا المنتج غير موجود.',
                'products.*.quantity.required' => 'الكمية مطلوبة.',
                'products.*.quantity.integer' => 'يجب أن تكون الكمية رقماً صحيحاً.',
                'products.*.quantity.min' => 'يجب أن تكون الكمية على الأقل 1.',
                // 'products.*.price.required' => 'السعر مطلوب.',
                // 'products.*.price.numeric' => 'يجب أن يكون السعر رقماً.',
                // 'products.*.price.min' => 'يجب أن يكون السعر على الأقل 0.',
            ];
        }
    }
