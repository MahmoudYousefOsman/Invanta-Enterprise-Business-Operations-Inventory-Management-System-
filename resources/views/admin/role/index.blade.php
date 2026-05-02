@extends('admin.layouts.master')
@section('content')
    <div class="page-body">
        @if ($permissionUser->can("create_roles"))
            <div class="col-lg-11 mx-lg-auto">
                <div class="row row-deck row-cards">
                    <form method="POST" action="{{ route('admin.roles.store') }}">
                        <div class="col-lg-11 mx-lg-auto">
                            <div class="card">
                                @csrf
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <h3 class="h1 pb-3">اضافه اذن</h3>
                                            <div class="row">
                                                <div class="markdown text-secondary col">
                                                    {{--                                                <label class="form-label">اسم الاذن</label>--}}
                                                    <input type="text" name="name" class="form-control"
                                                        placeholder="ادخل اسم الاذن" autocomplete="off">
                                                    @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-11 mx-lg-auto">
                            <div class="card card-md mt-2">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h3 class="card-title m-0">الصلاحيات</h3>
                                        <button type="button" class="btn btn-primary py-2 px-4" id="checkAllPermissions">
                                            <i class="fas fa-check-circle me-2"></i> اختيار الكل
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach ($permissions as $permission)
                                                <div class="col-md-3 col-6 mb-3">
                                                    <label class="form-check d-block">
                                                        <input class="form-check-input permission-checkbox" type="checkbox"
                                                            value="{{ $permission->id }}" name="permissions[]">
                                                        <span class="form-check-label fs-3">{{ __($permission->name) }}</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="card-footer text-end mt-3">
                                        <button class="btn btn-primary text-uppercase col-1"
                                                type="submit">حفظ
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <div class="col-lg-11 mx-lg-auto">
            <div class="row justify-content-center mt-4">
                <div class="col-lg-11 mx-lg-auto">
                    <div class="card">
                        <div class="card-body">
                            <div id="table-default" class="table">
                                {{ $dataTable->table() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script
        src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.0/b-3.0.0/b-html5-3.0.0/b-print-3.0.0/sl-2.0.0/datatables.min.js"></script>
    {{ $dataTable->scripts() }}
    @vite(['resources/js/crud.js'])
    <script>
        document.getElementById('checkAllPermissions').addEventListener('click', function () {
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            const isChecked = this.dataset.checked !== 'true';

            checkboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });

            if (isChecked) {
                this.innerHTML = `<i class="fas fa-times-circle me-1"></i> الغاء الاختيار`;
                this.dataset.checked = 'true';
            } else {
                this.innerHTML = `<i class="fas fa-check-circle me-1"></i> اختيار الكل`;
                this.dataset.checked = 'false';
            }
        });
    </script>
@endpush
