@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="col-11 mx-auto">
        <h3 class="mb-4 mt-4">📦 تقرير المرتجعات</h3>

        {{-- نموذج البحث --}}
        <form method="GET" class="row mb-4" action="{{ route('admin.return.report.index') }}">
            <div class="row g-2 mb-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">نوع المرتجع</label>
                    <select id="returnType" name="type" class="form-select">
                        <option value="">كل الأنواع</option>
                        <option value="client" {{ request('type') == 'client' ? 'selected' : '' }}>مرتجع عميل</option>
                        <option value="supplier" {{ request('type') == 'supplier' ? 'selected' : '' }}>مرتجع مورد</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">العميل / المورد</label>
                    <select id="typeIdSelect" name="type_id" class="form-select">
                        <option value="">الكل</option>
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label">من تاريخ</label>
                <input type="date" name="from_date" class="form-control"
                       value="{{ request('from_date') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">إلى تاريخ</label>
                <input type="date" name="to_date" class="form-control"
                       value="{{ request('to_date') }}">
            </div>

            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">بحث</button>
            </div>
        </form>

        {{-- الإجماليات --}}
        <div class="row row-cards mb-4">
            <div class="col-md-6">
                <div class="card card-sm">
                    <div class="card-body d-flex align-items-center">
                        <span class="avatar bg-success text-white me-3">💰</span>
                        <div>
                            <div class="fw-medium">إجمالي المبلغ</div>
                            <div class="fs-3 text-muted fw-bold">
                                {{ number_format($totalSales, 2) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-sm">
                    <div class="card-body d-flex align-items-center">
                        <span class="avatar bg-primary text-white me-3">📄</span>
                        <div>
                            <div class="fw-medium">إجمالي عدد المرتجعات</div>
                            <div class="fs-3 text-muted fw-bold">
                                {{ $returnsCount }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @php
            $selectedType = request('type');
        @endphp

        {{-- الجداول --}}
        @if(!$selectedType)
            {{-- مرتجعات العملاء --}}
            <h4 class="mt-4 mb-2">مرتجعات العملاء</h4>
            @include('admin.reports.partials.returns-table', [
                'returns' => $clientReturns,
                'type' => 'client'
            ])

            {{-- مرتجعات الموردين --}}
            <h4 class="mt-5 mb-2">مرتجعات الموردين</h4>
            @include('admin.reports.partials.returns-table', [
                'returns' => $supplierReturns,
                'type' => 'supplier'
            ])
        @else
            {{-- نوع واحد محدد --}}
            <h4 class="mt-4 mb-2">
                {{ $selectedType == 'client' ? 'مرتجعات العملاء' : 'مرتجعات الموردين' }}
            </h4>
            @include('admin.reports.partials.returns-table', [
                'returns' => $returns,
                'type' => $selectedType
            ])
        @endif
    </div>
</div>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
<script>
    const clients = @json($clients->map(fn($c) => [
        'id' => $c->id,
        'name' => $c->name . ' - ' . ($c->phone ?? '')
    ]));

    const suppliers = @json($suppliers->map(fn($s) => [
        'id' => $s->id,
        'name' => $s->name . ' - ' . ($s->phone ?? '')
    ]));

    const returnType = new TomSelect('#returnType', {
        onChange(value) {
            fillTypeSelect(value);
        }
    });

    const typeIdSelect = new TomSelect('#typeIdSelect', {
        valueField: 'id',
        labelField: 'name',
        searchField: 'name',
        placeholder: 'الكل'
    });

    function fillTypeSelect(type) {
        typeIdSelect.clearOptions();
        let list = [];
        if (type === 'client') list = clients;
        if (type === 'supplier') list = suppliers;

        list.forEach(i => typeIdSelect.addOption(i));
        typeIdSelect.refreshOptions(false);
    }

    // تعبئة تلقائية عند تحميل الصفحة
    @if(request('type'))
        fillTypeSelect('{{ request('type') }}');
        @if(request('type_id'))
            typeIdSelect.setValue('{{ request('type_id') }}');
        @endif
    @endif
</script>
@endpush
