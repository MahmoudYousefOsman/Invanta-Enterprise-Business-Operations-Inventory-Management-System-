@extends('admin.layouts.master')
@section('content')
    <div class="page-body">
        <div class="container-xl col-lg-10 mx-auto">
            <div class="row justify-content-center">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h2"> التصنيف الرئيسي {{ $category->name}} </h3>
{{--                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-primary ms-3">Edit</a>--}}
                    </div>
                    <div class="list-group list-group-flush overflow-auto" style="max-height: 35rem">
                        <div class="list-group-header sticky-top">التصنيفات الفرعيه التابعه له</div>
                        @foreach($category->children as $child)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="col text-truncate d-flex align-items-center">
                                    @if($child->children->isNotEmpty())
                                        <button class="btn btn-link p-0  text-decoration-none me-2" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#child-{{ $child->id }}"
                                                aria-expanded="false" aria-controls="child-{{ $child->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none"
                                                 stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                 stroke-linejoin="round"
                                                 class="icon icon-tabler icons-tabler-outline icon-tabler-fold-down">
                                                <path stroke="none"
                                                      d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M12 11v8l3 -3m-6 0l3 3"/>
                                                <path d="M9 7l1 0"/>
                                                <path d="M14 7l1 0"/>
                                                <path d="M19 7l1 0"/>
                                                <path d="M4 7l1 0"/>
                                            </svg>
                                        </button>
                                    @endif
                                    <span class="h4 d-inline-block">{{ $child->name }}</span>
                                </div>

                                <div class="d-flex gap-2">
                                    @if ($permission->can("edit_category"))
                                        <a href="{{ route('admin.categories.edit', $child->id) }}" class="btn btn-sm btn-primary">تعديل</a>
                                    @endif
                                    @if ($permission->can("delete_category"))
                                        <form action="{{ route('admin.categories.destroy', $child->id) }}" method="POST" class="d-inline delete-category-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger delete-category-btn">حذف</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            @if($child->children->isNotEmpty())
                                <div class="collapse" id="child-{{ $child->id }}">
                                    <div class="list-group list-group-flush ps-4">
                                        @foreach($child->children as $subChild)
                                            <div class="list-group-item border-0 d-flex justify-content-between align-items-center">
                                                <div class="col text-truncate">
                                                    <span class="h5 d-block">{{ $subChild->name }}</span>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    @if ($permission->can("edit_category"))
                                                        <a href="{{ route('admin.categories.edit', $subChild->id) }}" class="btn btn-sm btn-primary">تعديل</a>
                                                    @endif
                                                    @if ($permission->can("delete_category"))
                                                        <form action="{{ route('admin.categories.destroy', $subChild->id) }}" method="POST" class="d-inline delete-category-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger delete-category-btn">حذف</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.btn-link[data-bs-toggle="collapse"]').forEach(button => {
            button.addEventListener('click', function () {
                const plusIcon = this.querySelector('.icon-plus');
                const minusIcon = this.querySelector('.icon-minus');
                if (this.getAttribute('aria-expanded') === 'true') {
                    plusIcon.classList.add('d-none');
                    minusIcon.classList.remove('d-none');
                } else {
                    plusIcon.classList.remove('d-none');
                    minusIcon.classList.add('d-none');
                }
            });
        });

        // معالج حذف التصنيفات مع تأكيد
        document.querySelectorAll('.delete-category-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                if (!confirm('هل أنت متأكد من حذف هذا التصنيف؟')) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection
