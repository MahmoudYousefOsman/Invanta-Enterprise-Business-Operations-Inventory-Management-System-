@extends('admin.layouts.master')
@section('title', 'تفاصيل المرتجع')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">المرتجعات</div>
                    <h2 class="page-title">فاتورة مرتجع رقم {{ $invoiceReturn->code }}</h2>
                </div>
                <div class="col-auto ms-auto d-flex" style="gap:.5rem;">
                    <a href="{{ route('admin.invoice_return.index') }}" class="btn btn-outline-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6 -6"/></svg>
                        رجوع
                    </a>
                    <button onclick="window.print()" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"/><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"/><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"/></svg>
                        طباعة
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="card inv-invoice">
                <div class="inv-invoice-band">
                    <div>
                        <div class="inv-invoice-brand">Invanta</div>
                        <div class="inv-invoice-sub">القاهرة - مصر · فاتورة مرتجع</div>
                    </div>
                    <div class="text-end">
                        <div class="inv-invoice-no"># {{ $invoiceReturn->code }}</div>
                        <div class="inv-invoice-date">{{ $invoiceReturn->created_at->format('Y-m-d') }}</div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4 g-3 align-items-start">
                        <div class="col-md-6">
                            <div class="inv-party-label">{{ $invoiceReturn->type=='client' ? 'العميل' : 'المورد' }}</div>
                            @if($invoiceReturn->type=='client')
                                <div class="fw-bold fs-3">{{ $invoiceReturn->client->name }}</div>
                                <div class="text-muted">{{ $invoiceReturn->client->phone }}</div>
                                <div class="text-muted">{{ $invoiceReturn->client->address ?? '---' }}</div>
                            @else
                                <div class="fw-bold fs-3">{{ $invoiceReturn->supplier->name }}</div>
                                <div class="text-muted">{{ $invoiceReturn->supplier->phone }}</div>
                                <div class="text-muted">{{ $invoiceReturn->supplier->address ?? '---' }}</div>
                            @endif
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="inv-party-label">نوع المرتجع</div>
                            <span class="inv-status {{ $invoiceReturn->type=='client' ? 'partial' : 'unpaid' }}">
                                {{ $invoiceReturn->type=='client' ? 'مرتجع عميل' : 'مرتجع مورد' }}
                            </span>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-vcenter">
                            <thead>
                            <tr>
                                <th class="text-center" style="width:1%">#</th>
                                <th>المنتج</th>
                                <th class="text-center" style="width:1%">الكمية</th>
                                <th class="text-end" style="width:1%">سعر الوحدة</th>
                                <th class="text-end" style="width:1%">الإجمالي</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $subTotal = 0; @endphp
                            @foreach($invoiceReturn->returns_items as $detail)
                                @php $lineTotal = $detail->price * $detail->quantity; $subTotal += $lineTotal; @endphp
                                <tr>
                                    <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="fw-semibold">{{ $detail->product->name ?? '---' }}</span>
                                        <div class="text-secondary small">{{ $detail->product->description ?? '' }}</div>
                                    </td>
                                    <td class="text-center">{{ $detail->quantity }}</td>
                                    <td class="text-end">{{ number_format($detail->price, 2) }} ج.م</td>
                                    <td class="text-end fw-semibold">{{ number_format($lineTotal, 2) }} ج.م</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row justify-content-end mt-3">
                        <div class="col-md-5 col-lg-4">
                            <div class="inv-summary">
                                <div class="line grand"><span>الإجمالي</span><span>{{ number_format($invoiceReturn->total_price, 2) }} ج.م</span></div>
                            </div>
                        </div>
                    </div>

                    <p class="text-secondary text-center mt-4 mb-0">شكراً لتعاملكم معنا 🤝 نتطلع لخدمتكم مرة أخرى!</p>
                </div>
            </div>
        </div>
    </div>
@endsection
