@extends('admin.layouts.master')
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                       المديرين
                    </h2>
                    <div class="page-pretitle">
                        {{$admins->firstItem()}}-{{$admins->lastItem()}} {{__('of')}} {{$admins->total()}} مدير
                    </div>
                </div>

                    <!-- Page title actions -->
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-new-admin">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg> اضافه مدير جديد
                            </a>
                            <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-new-admin" aria-label="Create new report">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                            </a>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="admins-grid">
                        @foreach ($admins as $admin)
                            @include('admin.admins.partials.admin-card')
                        @endforeach
                    </div>
                </div>
            </div>
            {{$admins->links('admin.partials.pagination')}}
        </div>
    </div>
@endsection
@push('modals')
    @include('admin.admins.modals.create')
    {{-- @include('dashboard.admins.modals.edit') --}}
@endpush
@push('scripts')
    @vite(['resources/js/crud.js'])
    <script>
        const CRUD_BASE = '/admin/admins/';
        var dataObj = {
            formURL: '',
            name: '',
            email: '',
            profile_pic: '',
            active: true,
        };
        function editCallback(data) {
            Alpine.store('editModal').formURL = '/admin/admins/' + data.id;
            Alpine.store('editModal').name = data.name;
            Alpine.store('editModal').email = data.email;
            Alpine.store('editModal').profile_pic = data.profile_pic_url;
            Alpine.store('editModal').active = data.active;
        }
    </script>
    <!-- New avatar -->
    <script>
        const avatarImage = document.querySelector(".avatar-img"),
            avatarInput = document.querySelector(".avatar-input")

        avatarInput.addEventListener("change", () => {
            avatarImage.src = URL.createObjectURL(avatarInput.files[0]);
        });
    </script>

    <!-- edit avatar -->
    <script>
        const avatarImageEdit = document.querySelector(".avatar-img-edit"),
            avatarInputEdit = document.querySelector(".avatar-input-edit")

        avatarInputEdit.addEventListener("change", () => {
            avatarImageEdit.src = URL.createObjectURL(avatarInputEdit.files[0]);
        });
    </script>
@endpush
