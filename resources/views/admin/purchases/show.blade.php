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

                            {{-- بيانات المورد --}}
                            <div class="col-6 text-end">
                                <p class="h3">بيانات المورد</p>
                                <address>
                                    {{ $purchase->supplier->name ?? '---' }} <br>
                                    {{ $purchase->supplier->phone ?? '---' }} <br>
                                    {{ $purchase->supplier->address ?? '---' }}
                                </address>
                            </div>

                            {{-- رقم الفاتورة --}}
                            <div class="col-12 my-5">
                                <h1>فاتورة مشتريات رقم {{ $purchase->code }}</h1>
                                @if($purchase->invoice_type == 'partial')
                                    <h3>فاتوره مدفوعه جزئيا و تم دفع مبلغ {{$purchase->paid_amount}}</h3>
                                @elseif($purchase->invoice_type == 'unpaid')
                                    <h3>فاتوره اجل </h3>
                                @elseif($purchase->invoice_type == 'paid')
                                    <h3>فاتوره مدفوعه </h3>

                                @endif

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
                                    @php $subTotal = 0; @endphp
                                    @foreach($purchase->purchaseDetails as $detail)
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

                                    {{-- الإجمالي قبل الخصم --}}
                                    <tr>
                                        <td colspan="4" class="strong text-end">الإجمالي قبل الخصم</td>
                                        <td class="strong text-end">{{ number_format($subTotal, 2) }} ج.م</td>
                                    </tr>

                                    {{-- الخصم --}}
                                    @if($purchase->discount)
                                        <tr>
                                            <td colspan="4" class="strong text-end">الخصم</td>
                                            <td class="strong text-end">
                                                {{ number_format($purchase->discount, 2) }} ج.م
                                            </td>
                                        </tr>
                                    @endif

                                    {{-- الإجمالي الكلي بعد الخصم --}}
                                    <tr>
                                        <td colspan="4" class="strong text-end">الإجمالي الكلي</td>
                                        <td class="strong text-end">
                                            {{ number_format($purchase->total_price, 2) }} ج.م
                                        </td>
                                    </tr>
                                    @if($purchase->invoice_type == 'partial')

                                        <tr>
                                            <td colspan="4" class="strong text-end"> فاتوره مدفوعه جزئيا و تم دفع مبلغ </td>
                                            <td class="strong text-end"> {{ number_format($purchase->paid_amount)}} </td>
                                        </tr>
                                        <tr>

                                            <td colspan="4" class="strong text-end">المبلغ المتبقي </td>
                                            <td class="strong text-end">
                                                {{ number_format($purchase->remaining_amount, 2) }} ج.م
                                            </td>
                                        </tr>
                                    @endif

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
