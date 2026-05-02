<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class StoreOrderRequest extends FormRequest
    {
        /**
         * هل المستخدم مسموح له يبعث الريكوست ده؟
         */
        public function authorize(): bool
        {
            return true;
        }

        /**
         * قواعد التحقق (Validation rules).
         */
        public function rules(): array
        {
            return [
                'client_id'            => 'nullable|exists:clients,id',
                'products'             => 'required|array|min:1',
                'products.*.id'        => 'required|exists:products,id',
                'products.*.quantity'  => 'required|integer|min:1',
                'products.*.price'     => 'required|numeric|min:0',
                'order_date'           => 'nullable|date',
                'discount'             => 'nullable|numeric|min:0',
            ];
        }

        /**
         * رسائل التحقق.
         */
        public function messages(): array
        {
            return [
                'client_id.required'       => 'يجب اختيار عميل.',
                'client_id.exists'         => 'العميل غير موجود.',
                'products.required'        => 'يجب اختيار منتج واحد على الأقل.',
                'products.*.id.exists'     => 'المنتج المحدد غير موجود.',
                'products.*.quantity.min'  => 'الكمية يجب أن تكون على الأقل 1.',
                'products.*.price.min'     => 'سعر المنتج لا يمكن أن يكون بالسالب.',
                'discount.numeric'         => 'يجب أن يكون الخصم رقمًا صحيحًا.',
                'discount.min'             => 'الخصم لا يمكن أن يكون أقل من صفر.',
            ];
        }
    }
