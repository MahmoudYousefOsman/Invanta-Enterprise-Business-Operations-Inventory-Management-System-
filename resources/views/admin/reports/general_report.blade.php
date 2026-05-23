@extends('admin.layouts.master')
@section('title', 'التقرير العام')
@section('content')
    <div class="page-header d-print-none">
        <div class="col-lg-11 mx-lg-auto">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">التقارير</div>
                    <h2 class="page-title">التقرير العام</h2>
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

            {{-- فلتر التاريخ --}}
            <div class="card mb-4 d-print-none">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.general.report') }}">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-5">
                                <label class="form-label">من تاريخ</label>
                                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                            </div>
                            <div class="col-md-5">
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

            {{-- البطاقات الرئيسية --}}
            <div class="row row-deck row-cards mb-2">
                @php
                    $generalCards = [
                        ['label' => 'إجمالي المهام',     'value' => $tasksTotal,     'grad' => 'inv-grad-blue',   'icon' => '<path d="M7 10h3v-3l-3.5 -3.5a6 6 0 0 1 8 8l6 6a2 2 0 0 1 -3 3l-6 -6a6 6 0 0 1 -8 -8l3.5 3.5"/>'],
                        ['label' => 'إجمالي الطلبات',    'value' => $ordersTotal,    'grad' => 'inv-grad-violet', 'icon' => '<circle cx="9" cy="19" r="2"/><circle cx="17" cy="19" r="2"/><path d="M17 17h-11v-14h-2"/><path d="M6 5l14 1l-1 7h-13"/>'],
                        ['label' => 'إجمالي المشتريات',  'value' => $purchasesTotal, 'grad' => 'inv-grad-amber',  'icon' => '<path d="M6.331 8h11.339a2 2 0 0 1 1.977 2.304l-1.255 8.152a3 3 0 0 1 -2.966 2.544h-6.86a3 3 0 0 1 -2.966 -2.544l-1.255 -8.152a2 2 0 0 1 1.977 -2.304z"/><path d="M9 11v-5a3 3 0 0 1 6 0v5"/>'],
                        ['label' => 'إجمالي المرتجعات',  'value' => $returnsTotal,   'grad' => 'inv-grad-rose',   'icon' => '<path d="M19.933 13.041a8 8 0 1 1 -9.925 -8.788c3.899 -1 7.935 1.007 9.425 4.747"/><path d="M20 4v5h-5"/>'],
                    ];
                @endphp
                @foreach($generalCards as $c)
                    <div class="col-md-6 col-lg-3">
                        <div class="card inv-stat inv-lift h-100">
                            <div class="card-body d-flex align-items-center" style="gap:1rem;">
                                <div class="inv-stat-icon {{ $c['grad'] }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/>{!! $c['icon'] !!}</svg>
                                </div>
                                <div>
                                    <div class="inv-stat-value">{{ number_format($c['value'] ?? 0, 2) }}</div>
                                    <div class="inv-stat-label">{{ $c['label'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- بطاقة صافي الربح --}}
            <div class="row mt-2">
                <div class="col-12 col-lg-7 mx-auto">
                    <div class="card inv-stat">
                        <div class="card-body text-center py-5">
                            <div class="inv-stat-icon {{ ($profit ?? 0) >= 0 ? 'inv-grad-emerald' : 'inv-grad-rose' }} mx-auto mb-3" style="width:64px;height:64px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8"/><path d="M14 7l7 0l0 7"/></svg>
                            </div>
                            <div class="text-muted">صافي الربح</div>
                            <div class="display-5 fw-bold {{ ($profit ?? 0) >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ number_format($profit ?? 0, 2) }}
                            </div>
                            <small class="text-muted">المبيعات − (المشتريات + المرتجعات)</small>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
