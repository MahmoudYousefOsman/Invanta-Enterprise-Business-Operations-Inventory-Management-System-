@extends('admin.layouts.master')
@section('title', 'تقرير الطلبات')
@section('content')
    <div class="page-header d-print-none">
        <div class="col-lg-11 mx-lg-auto">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">التقارير</div>
                    <h2 class="page-title">تقرير الطلبات</h2>
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

            {{-- الفلتر --}}
            <div class="card mb-4 d-print-none">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.order.report.search') }}">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">العميل</label>
                                <select name="client_id" class="form-select">
                                    <option value="">كل العملاء</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                            {{ $client->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">من تاريخ</label>
                                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                            </div>
                            <div class="col-md-3">
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
                                <div class="inv-stat-label">إجمالي المبيعات</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card inv-stat h-100">
                        <div class="card-body d-flex align-items-center" style="gap:1rem;">
                            <div class="inv-stat-icon inv-grad-blue">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8"/><path d="M14 7l7 0l0 7"/></svg>
                            </div>
                            <div>
                                <div class="inv-stat-value">{{ number_format($totalProfit, 2) }}</div>
                                <div class="inv-stat-label">إجمالي الربح</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- الجدول --}}
            <div class="card">
                <div class="card-header"><h3 class="card-title">تفاصيل الطلبات</h3></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>كود الطلب</th>
                                    <th>العميل</th>
                                    <th>التاريخ</th>
                                    <th>الإجمالي</th>
                                    <th>الربح</th>
                                    <th class="d-print-none">عرض</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td class="text-muted">{{ $loop->iteration }}</td>
                                        <td><span class="badge bg-blue-lt">{{ $order->code }}</span></td>
                                        <td>{{ $order->client ? $order->client->name : 'غير محدد' }}</td>
                                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                        <td class="text-success fw-bold">{{ number_format($order->total_price, 2) }}</td>
                                        <td class="fw-bold text-primary">{{ number_format($order->profit, 2) }}</td>
                                        <td class="d-print-none">
                                            <a class="btn btn-icon btn-outline-primary" href="{{ route('admin.orders.show', $order->id) }}" title="عرض التفاصيل">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M1.5 12s4-7.5 10.5-7.5S22.5 12 22.5 12s-4 7.5-10.5 7.5S1.5 12 1.5 12z"/><circle cx="12" cy="12" r="3"/></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="text-center text-muted py-4">لا توجد بيانات</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
