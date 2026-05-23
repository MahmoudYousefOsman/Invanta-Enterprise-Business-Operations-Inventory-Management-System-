@extends('admin.layouts.master')
@section('title', 'تفاصيل الفاتورة')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">الأوردرات</div>
                    <h2 class="page-title">فاتورة رقم {{ $order->code }}</h2>
                </div>
                <div class="col-auto ms-auto d-flex" style="gap:.5rem;">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
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
                {{-- شريط الفاتورة --}}
                <div class="inv-invoice-band">
                    <div>
                        <div class="inv-invoice-brand">Invanta</div>
                        <div class="inv-invoice-sub">سنتر شارع عبد العزيز · القاهرة - مصر</div>
                    </div>
                    <div class="text-end">
                        <div class="inv-invoice-no"># {{ $order->code }}</div>
                        <div class="inv-invoice-date">{{ $order->created_at->format('Y-m-d') }}</div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4 g-3">
                        @if($order->client)
                            <div class="col-md-6">
                                <div class="inv-party-label">فاتورة إلى</div>
                                <div class="fw-bold fs-3">{{ $order->client->name }}</div>
                                <div class="text-muted">{{ $order->client->phone }}</div>
                                <div class="text-muted">{{ $order->client->address ?? '---' }}</div>
                            </div>
                        @endif
                        @if($order->notes)
                            <div class="col-md-6 {{ $order->client ? 'text-md-end' : '' }}">
                                <div class="inv-party-label">ملاحظات على الفاتورة</div>
                                <div class="text-muted">{{ $order->notes }}</div>
                            </div>
                        @endif
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
                            @foreach($order->orderDetails as $detail)
                                @php $lineTotal = $detail->total_price; $subTotal += $lineTotal; @endphp
                                <tr>
                                    <td class="text-center text-muted">{{ $detail->product->code }}</td>
                                    <td><span class="fw-semibold">{{ $detail->product->name ?? '---' }}</span></td>
                                    <td class="text-center">{{ $detail->quantity }}</td>
                                    <td class="text-end">{{ number_format($detail->sale_price, 2) }} ج.م</td>
                                    <td class="text-end fw-semibold">{{ number_format($lineTotal, 2) }} ج.م</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- ملخص الإجماليات --}}
                    <div class="row justify-content-end mt-3">
                        <div class="col-md-5 col-lg-4">
                            <div class="inv-summary">
                                <div class="line"><span>الإجمالي قبل الخصم</span><span>{{ number_format($subTotal, 2) }} ج.م</span></div>
                                <div class="line"><span>الخصم</span><span>{{ number_format($order->discount ?? 0, 2) }} ج.م</span></div>
                                <div class="line grand"><span>الإجمالي الكلي</span><span>{{ number_format($order->total_price, 2) }} ج.م</span></div>
                            </div>
                        </div>
                    </div>

                    <p class="text-secondary text-center mt-4 mb-0">شكراً لتعاملكم معنا 🤝 نتطلع لخدمتكم مرة أخرى!</p>
                </div>
            </div>
        </div>
    </div>
@endsection
