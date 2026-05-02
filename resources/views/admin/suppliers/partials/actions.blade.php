{{--@if (Auth::guard("admin")->user()->can("view_ads"))--}}
<div class="d-flex justify-content-center align-items-center gap-2">

<a class="btn btn-icon btn-outline-info ajax-edit" href="{{route('admin.suppliers.edit',$supplier->id)}}"
   title="تعديل البيانات">
    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24"
         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round"
         stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
        <path d="M16 5l3 3"/>
    </svg>
</a>

{{--@endif--}}

{{--<a class="btn btn-icon btn-outline-success mx-1" href="{{ route('admin.suppliers.show', $id) }}">--}}

{{--</a>--}}

{{--@if (Auth::guard("admin")->user()->can("delete_ads"))--}}
<form action="{{route('admin.suppliers.destroy', $supplier->id)}}" method="post" class="d-inline-block"
      onsubmit="return confirm('هل أنت متأكد؟ لا يمكن التراجع عن هذا الإجراء.')">
    @csrf
    @method('delete')
    <button class="btn btn-icon btn-outline-danger" title="حذف المورد">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24"
             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round"
             stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M4 7l16 0"/>
            <path d="M10 11l0 6"/>
            <path d="M14 11l0 6"/>
            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
        </svg>
    </button>
</form>
</div>

{{--@endif--}}

