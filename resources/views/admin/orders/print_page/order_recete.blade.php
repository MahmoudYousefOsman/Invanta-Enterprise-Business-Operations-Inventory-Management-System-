<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>طباعة الأوردر</title>

    <style>
        body {
            font-family: sans-serif;
            direction: rtl;
            text-align: right;
            margin: 0;
            padding: 0;
        }

        /* مقاس الورقة — ريسيت صغير */
        @page {
            size: 80mm auto;
            margin: 5mm;
        }

        .receipt {
            width: 80mm;
            padding: 10px;
            border: 1px dashed #000;
            margin: auto;
            font-size: 14px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 8px;
        }

        .row {
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 13px;
        }

        table th, table td {
            border-bottom: 1px dashed #aaa;
            padding: 4px 0;
        }

        .total-box {
            margin-top: 10px;
            padding: 8px;
            background: #f5f5f5;
            border: 1px solid #ddd;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body onload="window.print()">

<div class="receipt">

    <div class="title">سنتر شارع عبد العزيز </div>
    <div class="title">فاتورة بيع</div>
    @if($order->client)
        <div class="row"><b>العميل:</b> {{ $order->client?->name }}</div>
        <div class="row"><b>الهاتف:</b> {{ $order->client?->phone }}</div>
    @endif
    <div class="row"><b>ملاحظات:</b> {{ $order->notes }}</div>
    <div class="row"><b>التاريخ:</b> {{ $order->created_at->format('Y-m-d') }}</div>
    <div class="row"><b>رقم الفاتورة:</b> {{ $order->code }}</div>

    <table>
        <thead>
        <tr>
            <th>المنتج</th>
            <th>الكمية</th>
            <th>السعر</th>
        </tr>
        </thead>

        <tbody>
        @foreach($order->orderDetails as $detail)
            <tr>
                <td>{{ $detail->product->name }}</td>
                <td>{{ $detail->quantity }}</td>
                <td>{{ number_format($detail->sale_price, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="total-box">
        <div><b>الإجمالي:</b> {{ number_format($order->orderDetails->sum('sale_price'), 2) }}</div>
        <div><b>الخصم:</b> {{ number_format($order->discount, 2) }}</div>
        <div><b>الإجمالي النهائي:</b> {{ number_format($order->total_price, 2) }}</div>
    </div>

</div>

</body>
</html>
