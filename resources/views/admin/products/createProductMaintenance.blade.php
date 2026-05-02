@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3>إضافة منتج صيانة جديد</h3>
                </div>
                <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        <div class="row">
                            {{-- الاسم --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">اسم المنتج</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">التصنيف الرئيسي</label>
                                    <select name="category_id" id="parent_category"
                                            class="form-select @error('category_id') is-invalid @enderror" required>
                                        <option value="" disabled selected>اختر التصنيف الرئيسي</option>
                                        @foreach ($categories->where('parent_id', null) as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">التصنيف الفرعي</label>
                                    <select name="category_id" id="sub_category"
                                            class="form-select @error('subcategory_id') is-invalid @enderror">
                                        <option value="" disabled selected>اختر التصنيف الفرعي</option>
                                    </select>
                                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">التصنيف الفرعي الثانوي</label>
                                    <select name="category_id" id="sub_sub_category"
                                            class="form-select @error('subsubcategory_id') is-invalid @enderror">
                                        <option value="" disabled selected>اختر التصنيف الفرعي الثانوي</option>
                                    </select>
                                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            {{-- الكميه --}}

                            <div class="col-md-6 mb-3">
                                <label class="form-label">كميه المنتج</label>
                                <input type="number" step="0.01" name="quantity" class="form-control" value="{{ old('quantity') }}" required>
                                @error('quantity')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- سعر الشراء --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">سعر الشراء</label>
                                <input type="number" step="0.01" name="purchase_price" class="form-control" value="{{ old('purchase_price') }}" required>
                                @error('purchase_price')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- سعر البيع --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">سعر البيع</label>
                                <input type="number" step="0.01" name="sale_price" class="form-control" value="{{ old('sale_price') }}" required>
                                @error('sale_price')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- الوصف --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">المواصفات</label>
                                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- الصورة --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">صورة المنتج</label>
                                <input type="file" name="photo" id="photoInput" class="form-control" accept="image/*">
                                @error('photo')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror

                                {{-- معاينة الصورة --}}
                                <div id="previewContainer" class="mt-3" style="display:none;">
                                    <div class="card card-sm">
                                        <div class="card-body p-2 text-center">
                                            <img id="photoPreview" src="" class="img-fluid rounded" style="max-height: 200px;" alt="Preview">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="type" value="fix">


                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">حفظ المنتج</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const photoInput = document.getElementById('photoInput');
        const previewContainer = document.getElementById('previewContainer');
        const photoPreview = document.getElementById('photoPreview');

        photoInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    photoPreview.src = e.target.result;
                    previewContainer.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
                photoPreview.src = '';
            }
        });
    </script>
    <script>
        const parentCategorySelect = document.getElementById('parent_category');
        const subCategorySelect = document.getElementById('sub_category');
        const subSubCategorySelect = document.getElementById('sub_sub_category');

        // نخفي القوائم الفرعية في البداية
        subCategorySelect.closest('.mb-3').style.display = 'none';
        subSubCategorySelect.closest('.mb-3').style.display = 'none';

        // عند تغيير التصنيف الرئيسي
        parentCategorySelect.addEventListener('change', function () {
            const parentId = this.value;
            subCategorySelect.innerHTML = '<option value="" disabled selected>جارٍ التحميل...</option>';
            subSubCategorySelect.innerHTML = '<option value="" disabled selected>اختر التصنيف الفرعي الثانوي</option>';
            subSubCategorySelect.closest('.mb-3').style.display = 'none'; // نخفي الفرعي الثانوي دائمًا أولًا

            if (parentId) {
                fetch(`/admin/get-subcategories/${parentId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            subCategorySelect.innerHTML = '<option value="" disabled selected>اختر التصنيف الفرعي</option>';
                            data.forEach(function (subcategory) {
                                const option = document.createElement('option');
                                option.value = subcategory.id;
                                option.textContent = subcategory.name;
                                subCategorySelect.appendChild(option);
                            });
                            subCategorySelect.closest('.mb-3').style.display = 'block'; // ✅ نعرض التصنيف الفرعي
                        } else {
                            subCategorySelect.closest('.mb-3').style.display = 'none'; // ❌ مفيش بيانات → نخفيه
                        }
                    })
                    .catch(error => {
                        subCategorySelect.innerHTML = '<option value="" disabled selected>حدث خطأ في التحميل</option>';
                        subCategorySelect.closest('.mb-3').style.display = 'none';
                        console.error(error);
                    });
            } else {
                subCategorySelect.closest('.mb-3').style.display = 'none';
                subSubCategorySelect.closest('.mb-3').style.display = 'none';
            }
        });

        // عند تغيير التصنيف الفرعي
        subCategorySelect.addEventListener('change', function () {
            const subCategoryId = this.value;
            subSubCategorySelect.innerHTML = '<option value="" disabled selected>جارٍ التحميل...</option>';

            if (subCategoryId) {
                fetch(`/admin/get-subcategories/${subCategoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            subSubCategorySelect.innerHTML = '<option value="" disabled selected>اختر التصنيف الفرعي الثانوي</option>';
                            data.forEach(function (subsubcategory) {
                                const option = document.createElement('option');
                                option.value = subsubcategory.id;
                                option.textContent = subsubcategory.name;
                                subSubCategorySelect.appendChild(option);
                            });
                            subSubCategorySelect.closest('.mb-3').style.display = 'block'; // ✅ نعرضه فقط لو فيه بيانات
                        } else {
                            subSubCategorySelect.closest('.mb-3').style.display = 'none'; // ❌ نخفيه لو مفيش
                        }
                    })
                    .catch(error => {
                        subSubCategorySelect.innerHTML = '<option value="" disabled selected>حدث خطأ في التحميل</option>';
                        subSubCategorySelect.closest('.mb-3').style.display = 'none';
                        console.error(error);
                    });
            } else {
                subSubCategorySelect.closest('.mb-3').style.display = 'none';
            }
        });

        // في حالة رجع المستخدم للصفحة بعد خطأ Validation (old values)
        if (parentCategorySelect.value) {
            parentCategorySelect.dispatchEvent(new Event('change'));
        }
    </script>
@endpush
