@extends('admin.layouts.master')
@section('content')
    <div class="page-body">
        <!-- DataTable Card -->
        <div class="container-xl col-lg-10 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div class="me-3">
                            <h3 class="card-title mb-0">قائمة الطلبات</h3>
                        </div>

                        <div>
                            <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                     viewBox="0 0 24 24"
                                     stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M12 5l0 14"/>
                                    <path d="M5 12l14 0"/>
                                </svg>
                                إضافة طلب جديد
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="table-default">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link
        href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.0/b-3.0.0/b-html5-3.0.0/b-print-3.0.0/sl-2.0.0/datatables.min.css"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
@endpush

@push('scripts')
    <script
        src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.0/b-3.0.0/b-html5-3.0.0/b-print-3.0.0/sl-2.0.0/datatables.min.js"></script>
    {{ $dataTable->scripts() }}

    @if(session('print_url'))
        <script>
            window.open("{{ session('print_url') }}", "_blank");
        </script>
    @endif
@endpush
