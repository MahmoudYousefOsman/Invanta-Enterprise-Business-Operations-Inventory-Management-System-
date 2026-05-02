@php 
    use Spatie\Permission\Models\Role;
    $roles = Role::orderBy("created_at", "desc")->get();
@endphp

<div class="modal modal-blur fade" id="modal-new-admin" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">اضافة مدير</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{route('admin.admins.store')}}" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="inline-inputs mb-3">
                                <label class="image-input admin-avatar">
                                    <input hidden type="file" id="newAdminPic" name="profile_pic" accept="image/*" class="avatar-input">
                                    <img src="{{asset('')}}assets/admin/img/img-placeholder.png" class="avatar-img" alt="">
                                    <div class="overlay-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                            <path d="M16 5l3 3" />
                                        </svg>
                                    </div>
                                </label>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="newAdminName" name="name" value="{{old('name')}}" placeholder="e.g. John" required>
                                    <label for="newAdminName">اسم المدير</label>
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
                                <input type="email" class="form-control" id="newAdminEmail" name="email" value="{{ old('email') }}" placeholder="name@example.com" required>
                                <label for="newAdminEmail">الايميل</label>
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
                                <select id="select-roles" class="form-select" name="role">
                                   @foreach ($roles as $role)
                                       <option value="{{ $role->name }}">{{ $role->name }}</option>
                                   @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="newAdminPassword" name="password" placeholder="**********" autocomplete="off" required>
                                <label for="newAdminPassword">كلمة المرور</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="newAdminPasswordConfirmation" name="password_confirmation" placeholder="**********" autocomplete="off" required>
                                <label for="newAdminPasswordConfirmation">تاكيد كلمة المرور</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
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
                                <input class="form-check-input" type="checkbox" name="active" value="1" checked>
                                <span class="form-check-label">نشط</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        اغلاق
                    </button>
                    @csrf
                    <button type="submit" class="btn btn-primary ms-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-checkbox" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M9 11l3 3l8 -8" />
                            <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" />
                        </svg> اضافة مدير
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
