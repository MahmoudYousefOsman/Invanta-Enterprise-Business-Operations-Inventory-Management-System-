@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3>تعديل منتج صيانة</h3>
                </div>
                <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- الاسم --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">اسم المنتج</label>
                                <input type="text" name="name" class="form-control"
                                       value="{{ old('name', $product->name) }}" required>
                                @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- الكود --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">الكود</label>
                                <input type="text" name="code" class="form-control"
                                       value="{{ old('code', $product->code) }}" required>
                                @error('code')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">التصنيف الرئيسي</label>
                                <select name="category_id" id="parent_category"
                                        class="form-select @error('category_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>اختر التصنيف الرئيسي</option>
                                    @foreach ($categories->where('parent_id', null) as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $product->category?->parent?->parent?->id ?? $product->category?->parent?->id ?? $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4 mb-3" id="sub_category_container" style="display:none;">
                                <label class="form-label">التصنيف الفرعي</label>
                                <select name="subcategory_id" id="sub_category"
                                        class="form-select @error('subcategory_id') is-invalid @enderror">
                                    <option value="">اختر التصنيف الفرعي</option>
                                </select>
                                @error('subcategory_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4 mb-3" id="sub_sub_category_container" style="display:none;">
                                <label class="form-label">التصنيف الفرعي الثانوي</label>
                                <select name="subsubcategory_id" id="sub_sub_category"
                                        class="form-select @error('subsubcategory_id') is-invalid @enderror">
                                    <option value="">اختر التصنيف الفرعي الثانوي</option>
                                </select>
                                @error('subsubcategory_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            {{-- الكمية --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">كمية المنتج</label>
                                <input type="number" step="0.01" name="quantity" class="form-control"
                                       value="{{ old('quantity', $product->quantity) }}" required>
                                @error('quantity')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- سعر الشراء --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">سعر الشراء</label>
                                <input type="number" step="0.01" name="purchase_price" class="form-control"
                                       value="{{ old('purchase_price', $product->purchase_price) }}" required>
                                @error('purchase_price')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- سعر البيع --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">سعر البيع</label>
                                <input type="number" step="0.01" name="sale_price" class="form-control"
                                       value="{{ old('sale_price', $product->sale_price) }}" required>
                                @error('sale_price')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- الوصف --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">المواصفات</label>
                                <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- الصورة --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">صورة المنتج</label>
                                <input type="file" name="photo" class="form-control" accept="image/*">
                                @error('photo')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror

                                @if($product->photo)
                                    <div class="mt-3">
                                        <p class="mb-1">الصورة الحالية:</p>
                                        <img src="{{ asset('storage/' . $product->photo) }}" class="img-fluid rounded" style="max-height: 200px;">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="type" value="صيانة">

                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">تحديث المنتج</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const parentSelect = document.getElementById("parent_category");
            const subSelect = document.getElementById("sub_category");
            const subSubSelect = document.getElementById("sub_sub_category");

            const subContainer = document.getElementById("sub_category_container");
            const subSubContainer = document.getElementById("sub_sub_category_container");

            const selectedSub = "{{ $product->category?->parent?->id ?? '' }}";
            const selectedSubSub = "{{ $product->category_id }}";

            function loadSubcategories(parentId, targetSelect, selectedId = null, showContainer = null) {
                if (!parentId) return;

                fetch(`/admin/get-subcategories/${parentId}`)
                    .then(res => res.json())
                    .then(data => {
                        targetSelect.innerHTML = '<option value="">اختر التصنيف</option>';
                        data.forEach(item => {
                            const option = document.createElement("option");
                            option.value = item.id;
                            option.textContent = item.name;
                            if (selectedId && selectedId == item.id) option.selected = true;
                            targetSelect.appendChild(option);
                        });
                        if (data.length > 0 && showContainer) showContainer.style.display = 'block';
                    });
            }

            // إظهار القوائم عند التغيير
            parentSelect.addEventListener("change", function () {
                const parentId = this.value;
                subSelect.innerHTML = '<option value="">جارٍ التحميل...</option>';
                subSubSelect.innerHTML = '<option value="">اختر التصنيف الفرعي الثانوي</option>';
                subContainer.style.display = 'none';
                subSubContainer.style.display = 'none';

                if (parentId) {
                    loadSubcategories(parentId, subSelect, null, subContainer);
                }
            });

            subSelect.addEventListener("change", function () {
                const subId = this.value;
                subSubSelect.innerHTML = '<option value="">جارٍ التحميل...</option>';
                subSubContainer.style.display = 'none';
                if (subId) {
                    loadSubcategories(subId, subSubSelect, null, subSubContainer);
                }
            });

            // تحميل القيم المختارة أثناء التعديل
            const selectedParent = parentSelect.value;
            if (selectedParent) {
                loadSubcategories(selectedParent, subSelect, selectedSub, subContainer);
                if (selectedSub) {
                    loadSubcategories(selectedSub, subSubSelect, selectedSubSub, subSubContainer);
                }
            }
        });
    </script>
@endpush
