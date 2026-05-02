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
                            </div>

                            {{-- بيانات العميل --}}
                            <div class="col-6 text-end">
                                <p class="h3">بيانات العميل</p>
                                <address>
                                    @if($invoiceReturn->type=='client')
                                        {{ $invoiceReturn->client->name }} <br>
                                        {{ $invoiceReturn->client->phone }} <br>
                                        {{ $invoiceReturn->client->address ?? '---' }}
                                    @else
                                        {{ $invoiceReturn->supplier->name }} <br>
                                        {{ $invoiceReturn->supplier->phone }} <br>
                                        {{ $invoiceReturn->supplier->address ?? '---' }}
                                    @endif

                                </address>
                            </div>

                            {{-- رقم الفاتورة --}}
                            <div class="col-12 my-5">
                                <h1>فاتورة رقم {{ $invoiceReturn->code }}</h1>
                            </div>
                        </div>

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
                                    @foreach($invoiceReturn->returns_items as $detail)
                                        @php
                                            $lineTotal = $detail->price * $detail->quantity;
                                            $subTotal += $lineTotal;
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                <p class="strong mb-1">{{ $detail->product->name ?? '---' }}</p>
                                                <div class="text-secondary">
                                                    {{ $detail->product->description ?? '' }}
                                                </div>
                                            </td>
                                            <td class="text-center">{{ $detail->quantity }}</td>
                                            <td class="text-end">{{ number_format($detail->price, 2) }} ج.م</td>
                                            <td class="text-end">{{ number_format($lineTotal, 2) }} ج.م</td>
                                        </tr>
                                    @endforeach


                                    {{-- الإجمالي الكلي بعد الخصم --}}
                                    <tr>
                                        <td colspan="4" class="strong text-end">الإجمالي </td>
                                        <td class="strong text-end">
                                            {{ number_format($invoiceReturn->total_price, 2) }} ج.م
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
