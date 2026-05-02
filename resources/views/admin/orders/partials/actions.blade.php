<div class="d-flex justify-content-center align-items-center gap-2">


<a class="btn btn-icon btn-outline-success mx-1" href="{{ route('admin.orders.show', $order->id) }}">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
         stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24" role="img" aria-labelledby="showTitle2">
        <title id="showTitle2">Show</title>
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M1.5 12s4-7.5 10.5-7.5S22.5 12 22.5 12s-4 7.5-10.5 7.5S1.5 12 1.5 12z"/>
        <circle cx="12" cy="12" r="3"/>
    </svg>
</a>
    <a class="btn btn-icon btn-outline-primary mx-1"
       href="{{ route('admin.order.print', $order->id) }}"
       target="_blank">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
             viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 9V2h12v7"/>
            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
            <path d="M6 14h12v8H6z"/>
        </svg>
    </a>
{{--@if (Auth::guard("admin")->user()->can("delete_ads"))--}}
<form action="{{route('admin.orders.destroy', $order->id)}}" method="post" class="d-inline-block"
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
</div>
