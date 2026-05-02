@extends('admin.layouts.master')
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card card-md">
                        <form method="POST" action="{{ route('admin.roles.update', $role->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <h3 class="h1">{{ trans('main.edit_role') }}: {{ $role->name }}</h3>
                                        <div class="row">
                                            <div class="markdown text-secondary col">
                                                <label class="form-label">{{ trans('main.role_name') }}</label>
                                                <input type="text" name="name" class="form-control"
                                                    value="{{ old('name', $role->name) }}" placeholder="ادخل اسم الاذن" autocomplete="off">
                                                @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
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
                                                                value="{{ $permission->id }}" name="permissions[]"
                                                                {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                            <span class="form-check-label fs-3">{{ $permission->name }}</span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="card-footer text-end mt-3">
                                            <button class="btn btn-primary text-uppercase col-2 me-2"
                                                type="submit">تعديل</button>
                                            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary text-uppercase col-2">
                                                اغلاق
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.getElementById('checkAllPermissions').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            const isChecked = this.dataset.checked !== 'true';

            checkboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });

            if (isChecked) {
                this.innerHTML = `<i class="fas fa-times-circle me-1"></i> {{ trans('main.uncheck_all') }}`;
                this.dataset.checked = 'true';
            } else {
                this.innerHTML = `<i class="fas fa-check-circle me-1"></i> {{ trans('main.check_all') }}`;
                this.dataset.checked = 'false';
            }
        });
    </script>
@endsection