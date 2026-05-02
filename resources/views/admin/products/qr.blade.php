<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>طباعة الباركود</title>
    <style>
        @page {
            size: 1.5in 1in landscape;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .label {
            width: 1.5in;
            height: 1in;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 4px 6px;
            overflow: hidden;
            page-break-after: always; /* عشان كل ليبل يطلع في صفحة لوحده */
        }

        .label:last-child {
            page-break-after: avoid;
        }

        .item-name {
            font-size: 9px;
            font-weight: bold;
            margin: 2px 0 4px 0;
            line-height: 1.1;
            max-height: 22px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .barcode-container {
            margin: 3px 0;
        }

        .barcode-container img {
            width: 1.15in;     /* كبرنا الباركود جدًا */
            height: auto;
            max-height: 0.55in;
            image-rendering: crisp-edges; /* عشان يبان حاد وواضح */
        }

        .price {
            font-size: 11px;
            font-weight: bold;
            color: #000;
            margin: 2px 0 1px 0;
        }

        .company {
            font-size: 7px;
            color: #333;
            margin: 0;
        }

        /* تحسين جودة الطباعة */
        img {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    </style>
</head>
<body onload="window.print()">

@for ($i = 1; $i <= $numOfPrint; $i++)
    <div class="label">
        <div class="item-name">{{ $item->name }}</div>

        <div class="barcode-container">
            <img src="{{ $item->qr }}" alt="Barcode">
        </div>

        <div class="price">{{ $item->sale_price }} جنيه</div>
        <div class="company">Invanta</div>
    </div>
@endfor

</body>
</html>
