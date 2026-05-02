@extends('admin.layouts.master')

@section('content')

    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        تعديل مدير
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <form action="{{route('admin.admins.update' , $admin->id)}}" method="POST" enctype="multipart/form-data"
                  class="advanced-form myForm" autocomplete="off" data-parsley-validate novalidate>
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="inline-inputs mb-3">
                                    <label class="image-input user-avatar">
                                        <input hidden type="file" accept="image/*" class="avatar-input-edit"
                                               name="profile_pic">
                                        <img src="{{asset('storage/' . $admin->profile_pic)}}" class="avatar-img-edit"
                                             alt="">
                                        <div class="overlay-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-edit" width="24" height="24"
                                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                                <path
                                                    d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                                <path d="M16 5l3 3"/>
                                            </svg>
                                        </div>
                                    </label>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="adminName" name="name"
                                               value="{{$admin->name}}" placeholder="e.g. John" required>
                                        <label class="form-label" for="adminName">اسم المدير</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    @if ($errors->has('name'))
                                        <ul class="list-unstyled text-danger mt-2">
                                            @foreach ((array) $errors->get('name') as $message)
                                                <li>{{ $message }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    @if ($errors->has('profile_pic'))
                                        <ul class="list-unstyled text-danger mt-2">
                                            @foreach ((array) $errors->get('profile_pic') as $message)
                                                <li>{{ $message }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="adminEmail" name="email"
                                           value="{{$admin->email}}" placeholder="name@example.com" required>
                                    <label class="form-label" for="adminEmail">الايميل</label>
                                    @if ($errors->has('email'))
                                        <ul class="list-unstyled text-danger mt-2">
                                            @foreach ((array) $errors->get('email') as $message)
                                                <li>{{ $message }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <strong>اختر صلاحية:</strong>
                                    <select id="select-tags" class="form-select" name="role">
                                        @foreach ($roles as $role)
                                            <option
                                                value="{{ $role }}" {{ in_array($role, $adminRole) ? 'selected' : '' }}>{{ $role }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="adminPassword" name="password"
                                           placeholder="**********" autocomplete="off">
                                    <label class="form-label" for="adminPassword">كلمة المرور</label>
                                </div>
                            </div>
                            <div class=" col-12 col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="adminPasswordConfirmation"
                                           name="password_confirmation" placeholder="**********" autocomplete="off">
                                    <label class="form-label" for="adminPasswordConfirmation">تاكيد كلمة المرور</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="text-muted pt-2">اتركه فارغًا للاحتفاظ بكلمة المرور الحالية.</p>
                                    @if ($errors->has('password'))
                                        <ul class="list-unstyled text-danger mt-2">
                                            @foreach ((array) $errors->get('password') as $message)
                                                <li>{{ $message }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    @if ($errors->has('password_confirmation'))
                                        <ul class="list-unstyled text-danger mt-2">
                                            @foreach ((array) $errors->get('password_confirmation') as $message)
                                                <li>{{ $message }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-check form-switch d-inline-block mb-3">
                                    <input class="form-check-input" type="checkbox" name="active"
                                           value="1" {{$admin->active  ? 'checked' : ''}}>
                                    <span class="form-check-label">نشط</span>
                                </label>
                            </div>
                        </div>
                        <div class="card-footer d-flex">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-primary">تعديل</button>
                            <a href="{{route('admin.admins.index')}}"
                               class="btn btn-link link-secondary ms-auto">رجوع</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        const avatarImage = document.querySelector(".avatar-img"),
            avatarInput = document.querySelector(".avatar-input-edit")

        avatarInput.addEventListener("change", () => {
            avatarImage.src = URL.createObjectURL(avatarInput.files[0]);
        });
    </script>
    <script>
        const avatarImageEdit = document.querySelector(".avatar-img-edit"),
            avatarInputEdit = document.querySelector(".avatar-input-edit")

        avatarInputEdit.addEventListener("change", () => {
            avatarImageEdit.src = URL.createObjectURL(avatarInputEdit.files[0]);
        });
    </script>
@endpush
