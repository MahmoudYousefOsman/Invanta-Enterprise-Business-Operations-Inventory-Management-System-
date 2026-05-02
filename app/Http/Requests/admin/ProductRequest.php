<?php

    namespace App\Http\Requests\admin;

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;

    class ProductRequest extends FormRequest
    {
        public function authorize(): bool
        {
            return true;
        }

        public function rules(): array
        {
            $productId = $this->route('product')?->id;

            return [
                'name' => 'required|string|max:255',
                'code' => [
                    'nullable',
                    'string',
                    'max:100',
                    Rule::unique('products', 'code')->ignore($productId),
                ],
                'purchase_price' => 'required|numeric|min:0',
                'sale_price' => 'required|numeric|min:0|gte:purchase_price',
                'description' => 'nullable|string|max:1000',
                'quantity' => 'required|numeric|min:0',
                'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
                'type' => 'nullable|string',
                'category_id' => 'required|exists:categories,id',

            ];
        }

        public function messages(): array
        {
            return [
                'name.required' => 'اسم المنتج مطلوب.',
                'name.max' => 'اسم المنتج لا يجب أن يزيد عن 255 حرف.',
                'code.required' => 'كود المنتج مطلوب.',
                'code.unique' => 'هذا الكود مستخدم من قبل.',
                'purchase_price.required' => 'سعر الشراء مطلوب.',
                'purchase_price.numeric' => 'سعر الشراء يجب أن يكون رقم.',
                'sale_price.required' => 'سعر البيع مطلوب.',
                'sale_price.numeric' => 'سعر البيع يجب أن يكون رقم.',
                'sale_price.gte' => 'سعر البيع يجب أن يكون أكبر أو يساوي سعر الشراء.',
                'description.max' => 'الوصف لا يجب أن يزيد عن 1000 حرف.',
                'photo.image' => 'الملف يجب أن يكون صورة.',
                'photo.mimes' => 'الصورة يجب أن تكون jpg, jpeg, png أو gif.',
                'photo.max' => 'الصورة يجب ألا تتعدى 2 ميجابايت.',
                'quantity.required' => 'يجب إدخال الكمية للمنتج.',
                'quantity.numeric' => 'الكمية يجب أن تكون رقم.',
                'quantity.min' => 'الكمية لا يمكن أن تكون أقل من 0.',
            ];
        }
    }
