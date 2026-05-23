<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>طباعة الأوردر</title>

    <style>
        * { box-sizing: border-box; }

        body {
            font-family: "Segoe UI", Tahoma, sans-serif;
            direction: rtl;
            text-align: right;
            margin: 0;
            padding: 0;
            color: #111;
            background: #fff;
        }

        @page { size: 80mm auto; margin: 4mm; }

        .receipt {
            width: 80mm;
            padding: 10px 12px;
            margin: auto;
            font-size: 13px;
            line-height: 1.5;
        }

        .brand {
            text-align: center;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }
        .brand .shop {
            font-weight: 800;
            font-size: 17px;
            letter-spacing: .2px;
        }
        .brand .doc {
            display: inline-block;
            margin-top: 6px;
            background: #2563eb;
            color: #fff;
            font-weight: 700;
            font-size: 12px;
            padding: 2px 14px;
            border-radius: 999px;
        }

        .meta { margin-bottom: 10px; }
        .meta .row {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            padding: 2px 0;
        }
        .meta .row .label { color: #555; }
        .meta .row .value { font-weight: 600; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            font-size: 12.5px;
        }
        thead th {
            text-align: right;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .3px;
            color: #2563eb;
            border-bottom: 1.5px solid #2563eb;
            padding: 5px 2px;
        }
        thead th:not(:first-child),
        tbody td:not(:first-child) { text-align: center; }
        tbody td {
            border-bottom: 1px dashed #cbd5e1;
            padding: 5px 2px;
        }

        .totals {
            margin-top: 10px;
            border-top: 1px dashed #94a3b8;
            padding-top: 8px;
        }
        .totals .line {
            display: flex;
            justify-content: space-between;
            padding: 2px 0;
            font-size: 13px;
        }
        .totals .grand {
            margin-top: 6px;
            background: #eff5ff;
            border: 1px solid #2563eb;
            border-radius: 8px;
            padding: 8px 10px;
            font-weight: 800;
            font-size: 15px;
            color: #1e3a8a;
        }

        .foot {
            text-align: center;
            margin-top: 12px;
            padding-top: 8px;
            border-top: 2px solid #2563eb;
            font-size: 12px;
            color: #555;
        }
    </style>
</head>

<body onload="window.print()">

<div class="receipt">

    <div class="brand">
        <div class="shop">سنتر شارع عبد العزيز</div>
        <div class="doc">فاتورة بيع</div>
    </div>

    <div class="meta">
        @if($order->client)
            <div class="row"><span class="label">العميل</span><span class="value">{{ $order->client?->name }}</span></div>
            <div class="row"><span class="label">الهاتف</span><span class="value">{{ $order->client?->phone }}</span></div>
        @endif
        <div class="row"><span class="label">رقم الفاتورة</span><span class="value">{{ $order->code }}</span></div>
        <div class="row"><span class="label">التاريخ</span><span class="value">{{ $order->created_at->format('Y-m-d') }}</span></div>
        @if($order->notes)
            <div class="row"><span class="label">ملاحظات</span><span class="value">{{ $order->notes }}</span></div>
        @endif
    </div>

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

    <div class="totals">
        <div class="line"><span>الإجمالي</span><span>{{ number_format($order->orderDetails->sum('sale_price'), 2) }}</span></div>
        <div class="line"><span>الخصم</span><span>{{ number_format($order->discount, 2) }}</span></div>
        <div class="line grand"><span>الإجمالي النهائي</span><span>{{ number_format($order->total_price, 2) }}</span></div>
    </div>

    <div class="foot">شكراً لتعاملكم معنا 🌟</div>

</div>

</body>
</html>
