@extends('admin.layouts.master')
@section('content')
    <div class="page-body">
        <div class="container-xl col-lg-10 mx-auto">
            <div class="row justify-content-center">
                <div class="card shadow-sm mb-4">
                    <form action="{{ route('admin.categories.store') }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="card-header">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-plus-circle me-2"></i>إضافة تصنيف
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
                                                   required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-sitemap me-1"></i>التصنيف الرئيسي
                                            </label>
                                            <select name="categories[0][parent_id]" class="form-select">
                                                <option value="">-- بدون تصنيف رئيسي --</option>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <button type="button"
                                            class="btn btn-danger btn-sm remove-category position-absolute top-0 end-0 m-2 d-none">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="button" class="btn btn-outline-primary" id="add-category">
                                    <i class="fas fa-plus pe-1"></i>إضافة تصنيف آخر
                                </button>
                            </div>
                        </div>

                        <div class="card-footer text-end bg-light">
                            <button type="submit" class="btn btn-primary text-uppercase px-4">
                                <i class="fas fa-check me-1"></i> حفظ الكل
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
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
