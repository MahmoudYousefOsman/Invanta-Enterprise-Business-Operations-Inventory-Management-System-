<div class="d-flex justify-content-center align-items-center gap-2">

    <a class="btn btn-icon btn-outline-info ajax-edit" href="{{route('admin.product.edit',$id)}}">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24"
             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round"
             stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
            <path d="M16 5l3 3"/>
        </svg>
    </a>
    <button
        type="button"
        class="btn btn-icon btn-outline-success open-barcode-modal"
        data-id="{{ $id }}"
        data-bs-toggle="modal"
        data-bs-target="#barcodeModal"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2"
             stroke-linecap="round" stroke-linejoin="round"
             class="icon icon-tabler icons-tabler-outline icon-tabler-barcode">
            <path stroke="none"
                  d="M0 0h24v24H0z"
                  fill="none"/>
            <path d="M4 7v-1a2 2 0 0 1 2 -2h2"/>
            <path d="M4 17v1a2 2 0 0 0 2 2h2"/>
            <path d="M16 4h2a2 2 0 0 1 2 2v1"/>
            <path d="M16 20h2a2 2 0 0 0 2 -2v-1"/>
            <path d="M5 11h1v2h-1z"/>
            <path d="M10 11l0 2"/>
            <path d="M14 11h1v2h-1z"/>
            <path d="M19 11l0 2"/>
        </svg>
    </button>

    <form action="{{route('admin.product.destroy', $id)}}" method="post" class="d-inline-block"
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
</div>

