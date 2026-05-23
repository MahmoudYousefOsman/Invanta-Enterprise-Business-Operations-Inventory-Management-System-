@extends('admin.layouts.master')
@section('title', 'تقرير المرتجعات')
@section('content')
    <div class="page-header d-print-none">
        <div class="col-lg-11 mx-lg-auto">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">التقارير</div>
                    <h2 class="page-title">تقرير المرتجعات</h2>
                </div>
                <div class="col-auto">
                    <button onclick="window.print()" class="btn btn-outline-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"/><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"/><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"/></svg>
                        طباعة
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="col-lg-11 mx-lg-auto">

            {{-- نموذج البحث --}}
            <div class="card mb-4 d-print-none">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.return.report.index') }}">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">نوع المرتجع</label>
                                <select id="returnType" name="type" class="form-select">
                                    <option value="">كل الأنواع</option>
                                    <option value="client" {{ request('type') == 'client' ? 'selected' : '' }}>مرتجع عميل</option>
                                    <option value="supplier" {{ request('type') == 'supplier' ? 'selected' : '' }}>مرتجع مورد</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">العميل / المورد</label>
                                <select id="typeIdSelect" name="type_id" class="form-select">
                                    <option value="">الكل</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">من تاريخ</label>
                                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">إلى تاريخ</label>
                                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">بحث</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- الإجماليات --}}
            <div class="row row-cards mb-4">
                <div class="col-md-6">
                    <div class="card inv-stat h-100">
                        <div class="card-body d-flex align-items-center" style="gap:1rem;">
                            <div class="inv-stat-icon inv-grad-emerald">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3l0 18"/><path d="M17 8a4 4 0 0 0 -4 -4h-2a3.5 3.5 0 0 0 0 7h2a3.5 3.5 0 0 1 0 7h-2a4 4 0 0 1 -4 -4"/></svg>
                            </div>
                            <div>
                                <div class="inv-stat-value">{{ number_format($totalSales, 2) }}</div>
                                <div class="inv-stat-label">إجمالي المبلغ</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card inv-stat h-100">
                        <div class="card-body d-flex align-items-center" style="gap:1rem;">
                            <div class="inv-stat-icon inv-grad-rose">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4"/><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"/></svg>
                            </div>
                            <div>
                                <div class="inv-stat-value">{{ $returnsCount }}</div>
                                <div class="inv-stat-label">إجمالي عدد المرتجعات</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @php $selectedType = request('type'); @endphp

            {{-- الجداول --}}
            @if(!$selectedType)
                <h3 class="mt-4 mb-2">مرتجعات العملاء</h3>
                @include('admin.reports.partials.returns-table', ['returns' => $clientReturns, 'type' => 'client'])

                <h3 class="mt-5 mb-2">مرتجعات الموردين</h3>
                @include('admin.reports.partials.returns-table', ['returns' => $supplierReturns, 'type' => 'supplier'])
            @else
                <h3 class="mt-4 mb-2">
                    {{ $selectedType == 'client' ? 'مرتجعات العملاء' : 'مرتجعات الموردين' }}
                </h3>
                @include('admin.reports.partials.returns-table', ['returns' => $returns, 'type' => $selectedType])
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
