<div class="card admin-card {{$admin->active?'active':''}}">
    <div class="card-header">
        <div>
            <div class="row align-items-center">
                <div class="col-auto">
                    <div class="admin-avatar">
                        <span class="avatar" style="background-image:url({{ asset('storage/' . $admin->profile_pic) }})"></span>
                    </div>
                </div>
                <div class="col">
                    <div class="admin-name">{{$admin->name}}</div>
                    <div class="admin-email text-muted">{{$admin->email}}</div>
                </div>
            </div>
        </div>
        <div class="card-actions">
            <div class="dropdown">
                <a href="#" class="btn-action dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"/>
                        <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"/>
                        <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"/>
                    </svg>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item ajax-edit" href="{{ route("admin.admins.show", $admin->id) }}">تفاصيل المدير</a>

                    @if ($permission->can("edit_admin"))
                        <a class="dropdown-item" href="{{route('admin.admins.edit' , $admin->id)}}">تعديل المدير</a>
                    @endif

{{--                    @if ($permission->can("delete_admin"))--}}
                        @if ($admin->id != auth()->guard('admin')->id())
                            <form action="{{route('admin.admins.destroy', $admin->id)}}" method="post"
                                class="d-inline-block"
                                onsubmit="return confirm('هل أنت متأكد؟\nسيتم حذف كل المحتوى المرتبط بهذا المستخدم ولن تستطيع التراجع عن العملية.')">
                                @csrf
                                @method('delete')

                                <button class="dropdown-item text-danger" type="submit">حذف المدير</button>
                            </form>
                        @endif
{{--                    @endif--}}
                </div>
            </div>
        </div>
    </div>
</div>
