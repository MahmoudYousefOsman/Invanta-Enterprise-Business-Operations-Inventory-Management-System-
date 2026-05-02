@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="col-11 mx-auto">
        <h3 class="mb-4 mt-4">📦 تقرير الطلبات</h3>

        <form method="GET" class="row mb-4" action="{{ route('admin.order.report.search') }}">
            <div class="col-md-3">
                <label class="form-label">العميل</label>
                <select name="client_id" class="form-control">
                    <option value="">كل العملاء</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}"
                            {{ request('client_id') == $client->id ? 'selected' : '' }}>
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>
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
        <div class="row row-cards mb-3">
            <div class="col-md-6">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <span class="bg-success text-white avatar me-3">
                                💰
                            </span>
                            <div>
                                <div class="font-weight-medium">إجمالي المبيعات</div>
                                <div class="text-muted fs-3 fw-bold">
                                    {{ number_format($totalSales, 2) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <span class="bg-primary text-white avatar me-3">
                                📈
                            </span>
                            <div>
                                <div class="font-weight-medium">إجمالي الربح</div>
                                <div class="text-muted fs-3 fw-bold">
                                    {{ number_format($totalProfit, 2) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- الجدول --}}
        <div class="card">
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
                                <th>عرض</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td class="text-muted">{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="badge bg-blue-lt">
                                            {{ $order->code }}
                                        </span>
                                    </td>
                                    <td>{{ $order->client? $order->client->name : 'غير محدد' }}</td>
                                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                    <td class="text-success fw-bold">
                                        {{ number_format($order->total_price, 2) }}
                                    </td>
                                    <td class="fw-bold text-primary">
                                        {{ number_format($order->profit, 2) }}
                                    </td>
                                    <td>
                                        <a class="btn btn-icon btn-outline-success mx-1"
                                           href="{{ route('admin.orders.show', $order->id) }}"
                                           title="عرض التفاصيل">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="none" stroke="currentColor" stroke-width="1.2"
                                                 viewBox="0 0 24 24" role="img">
                                                <title>عرض</title>
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M1.5 12s4-7.5 10.5-7.5S22.5 12 22.5 12s-4 7.5-10.5 7.5S1.5 12 1.5 12z"/>
                                                <circle cx="12" cy="12" r="3"/>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        لا توجد بيانات
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
