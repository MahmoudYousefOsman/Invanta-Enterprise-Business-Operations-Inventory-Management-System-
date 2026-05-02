{{--@if (Auth::guard("admin")->user()->can("view_ads"))--}}
<a class="btn btn-icon btn-outline-info ajax-edit" href="{{route('admin.engineers.edit',$id)}}">
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

{{--<a class="btn btn-icon btn-outline-success mx-1" href="{{ route('admin.engineers.show', $id) }}">--}}
{{--    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"--}}
{{--         stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24" role="img" aria-labelledby="showTitle2">--}}
{{--        <title id="showTitle2">Show</title>--}}
{{--        <path stroke-linecap="round" stroke-linejoin="round"--}}
{{--              d="M1.5 12s4-7.5 10.5-7.5S22.5 12 22.5 12s-4 7.5-10.5 7.5S1.5 12 1.5 12z"/>--}}
{{--        <circle cx="12" cy="12" r="3"/>--}}
{{--    </svg>--}}
{{--</a>--}}


    {{--@if (Auth::guard("admin")->user()->can("delete_ads"))--}}
    <form action="{{route('admin.engineers.destroy', $id)}}" method="post" class="d-inline-block"
          onsubmit="return confirm('هل أنت متأكد؟ لا يمكن التراجع عن هذا الإجراء.')">
        @csrf
        @method('delete')
        <button class="btn btn-icon btn-outline-danger">
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
{{--@endif--}}

