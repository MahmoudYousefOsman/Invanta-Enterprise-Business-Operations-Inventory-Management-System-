@extends('admin.layouts.master')

@section('content')
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">

            <div class="row row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">{{ __('Admin Details') }}</h3>
                            <div>
                                @if ($permission->can("edit_admin"))
                                    <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-primary btn-sm">
                                        {{ __('Edit') }}
                                    </a>
                                @endif

                                @if ($permission->can("delete_admin"))
                                    @if ($checkAdmin)
                                        <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST"
                                            class="d-inline-block"
                                            onsubmit="return confirm('هل أنت متأكد؟\nسيتم حذف كل المحتوى المرتبط بهذا المستخدم ولن تستطيع التراجع عن العملية.')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3 text-center">
                                    <div class="avatar avatar-xl mb-3"
                                         style="background-image: url('{{ $admin->profile_pic ? asset('storage/'.$admin->profile_pic) : asset('default-avatar.png') }}')">
                                    </div>

                                    <h4>{{ $admin->name }}</h4>

                                    <span class="badge text-white {{ $admin->active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $admin->active ? __('Active') : __('Inactive') }}
                                    </span>
                                </div>
                                <div class="col-md-9">
                                    <div class="table-responsive">
                                        <table class="table table-vcenter">
                                            <tbody>
                                                <tr>
                                                    <th>ID</th>
                                                    <td>{{ $admin->id }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Name</th>
                                                    <td>{{ $admin->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Email</th>
                                                    <td>{{ $admin->email }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Active</th>
                                                    <td>{{ $admin->active ? 'Yes' : 'No' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Created At</th>
                                                    <td>{{ $admin->created_at->diffForHumans() }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- row -->
                        </div> <!-- card-body -->
                    </div> <!-- card -->
                </div>
            </div>

        </div>
    </div>
@endsection