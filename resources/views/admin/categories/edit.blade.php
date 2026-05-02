@extends('admin.layouts.master')
@section('content')
    <style>
        .category-preview {
            width: 100px;
            height: auto;
        }
    </style>

    <div class="page-body">
        <div class="container-xl col-lg-10 mx-auto">
            <div class="row justify-content-center">
                <div class="col-lg-11">
                    <div class="card shadow-sm mb-4">
                        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="card-header">
                                <h3 class="card-title mb-0">
                                    <i class="fas fa-edit me-2"></i>تعديل التصنيف: {{ $category->name }}
                                </h3>
                            </div>

                            <div class="card-body">
                                <div id="category-wrapper">
                                    <div class="category-group border rounded p-3 mb-3 position-relative bg-light">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-tag me-1"></i>اسم التصنيف
                                                </label>
                                                <input type="text" name="categories[0][name]" class="form-control"
                                                       value="{{ old('categories.0.name', $category->name) }}" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-sitemap me-1"></i>التصنيف الرئيسي
                                                </label>
                                                <select name="categories[0][parent_id]" class="form-select">
                                                    <option value="">-- بدون تصنيف رئيسي --</option>
                                                    @foreach($categories as $cat)
{{--                                                        @if($cat->id !== $category->id)--}}
                                                            <option value="{{ $cat->id }}"
                                                                {{ old('categories.0.parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>
                                                                {{ $cat->name }}
                                                            </option>
{{--                                                        @endif--}}
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>

                                        <button type="button" class="btn btn-danger btn-sm remove-category position-absolute top-0 end-0 m-2 d-none">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer text-end bg-light">
                                <button class="btn btn-primary px-4" type="submit">
                                    <i class="fas fa-save me-1"></i> حفظ التعديلات
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>


        // الكود الأصلي لإضافة/حذف التصنيفات
        let index = 1;

        document.getElementById('add-category').addEventListener('click', function () {
            const wrapper = document.getElementById('category-wrapper');
            const group = document.querySelector('.category-group');
            const clone = group.cloneNode(true);

            clone.querySelectorAll('input, select').forEach((input) => {
                if (input.name.includes('[name]')) {
                    input.name = `categories[${index}][name]`;
                    input.value = '';
                }

                if (input.name.includes('[parent_id]')) {
                    input.name = `categories[${index}][parent_id]`;
                    input.value = '';
                }

            });

            clone.querySelector('.remove-category').classList.remove('d-none');
            const preview = clone.querySelector('.category-preview');
            if (preview) preview.remove();

            wrapper.appendChild(clone);
            index++;
        });

        document.addEventListener('click', function (e) {
            if (e.target.closest('.remove-category')) {
                e.target.closest('.category-group').remove();
            }
        });
    </script>
@endpush
