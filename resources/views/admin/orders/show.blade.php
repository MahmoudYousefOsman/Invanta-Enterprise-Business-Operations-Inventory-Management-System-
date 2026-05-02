@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            {{-- بيانات الشركة --}}
                            <div class="col-6">
                                <p class="h3">بيانات الشركة</p>
                                <address>
                                    Invanta<br>
                                    القاهرة - مصر<br>
                                </address>
                                <div class="col-6 ">
                                    <p class="h3">ملاحظات علي الفاتوره</p>
                                    <p>
                                        {{$order->notes}}
                                    </p>
                                </div>
                            </div>

                            @if($order->client)
                                {{-- بيانات العميل --}}
                                <div class="col-6 text-end">
                                    <p class="h3">بيانات العميل</p>
                                    <address>
                                        {{ $order->client->name }} <br>
                                        {{ $order->client->phone }} <br>
                                        {{ $order->client->address ?? '---' }}
                                    </address>
                                </div>
                            @endif

                            {{-- رقم الفاتورة --}}
                            <div class="col-12 my-5">
                                <h1>فاتورة رقم {{ $order->code }}</h1>
                            </div>
                        </div >

                        {{-- جدول تفاصيل الفاتورة --}}
                        <div class="row justify-content-center">
                            <div class="col-11">
                                <table class="table table-transparent table-responsive ">
                                    <thead>
                                    <tr>
                                        <th class="text-center" style="width: 1%">#</th>
                                        <th>المنتج</th>
                                        <th class="text-center" style="width: 1%">الكمية</th>
                                        <th class="text-end" style="width: 1%">سعر الوحدة</th>
                                        <th class="text-end" style="width: 1%">الإجمالي</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $subTotal = 0;
                                    @endphp
                                    @foreach($order->orderDetails as $detail)
                                        @php
                                            $lineTotal = $detail->total_price;
                                            $subTotal += $lineTotal;
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $detail->product->code }}</td>
                                            <td>
                                                <p class="strong mb-1">{{ $detail->product->name ?? '---' }}</p>
                                            </td>
                                            <td class="text-center">{{ $detail->quantity }}</td>
                                            <td class="text-end">{{ number_format($detail->sale_price, 2) }} ج.م</td>
                                            <td class="text-end">{{ number_format($lineTotal, 2) }} ج.م</td>
                                        </tr>
                                    @endforeach

                                    {{-- الإجمالي قبل الخصم --}}
                                    <tr>
                                        <td colspan="4" class="strong text-end">الإجمالي قبل الخصم</td>
                                        <td class="strong text-end">{{ number_format($subTotal, 2) }} ج.م</td>
                                    </tr>

                                    {{-- الخصم --}}
                                    <tr>
                                        <td colspan="4" class="strong text-end">الخصم</td>
                                        <td class="strong text-end">
                                            {{ number_format($order->discount ?? 0, 2) }} ج.م
                                        </td>
                                    </tr>

                                    {{-- الإجمالي الكلي بعد الخصم --}}
                                    <tr>
                                        <td colspan="4" class="strong text-end">الإجمالي الكلي</td>
                                        <td class="strong text-end">
                                            {{ number_format($order->total_price, 2) }} ج.م
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <p class="text-secondary text-center mt-5">
                            شكراً لتعاملكم معنا 🤝 نتطلع لخدمتكم مرة أخرى!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
