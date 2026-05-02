@extends('admin.layouts.master')
@section('title', 'العملاء')
@section('content')
    <div class="page-body">
        <div class="container-xl col-lg-10 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">قائمة العملاء</h3>
                    <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> إضافة عميل
                    </a>
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
    <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.0/b-3.0.0/b-html5-3.0.0/b-print-3.0.0/sl-2.0.0/datatables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.0/b-3.0.0/b-html5-3.0.0/b-print-3.0.0/sl-2.0.0/datatables.min.js"></script>
    {{ $dataTable->scripts() }}
@endpush
