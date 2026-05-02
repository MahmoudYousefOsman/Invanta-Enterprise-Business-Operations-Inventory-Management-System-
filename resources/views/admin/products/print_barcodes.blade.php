<!DOCTYPE html>
<html>
<head>
    <title>Print Barcode</title>

    <style>
        @page {
            size: 1.5in 1in;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .qr-box {
            width: 1.5in;
            height: 1in;

            box-sizing: border-box;
            padding: 4px;

            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;

            text-align: center;

            border: 1px dashed #ccc; /* شكل شيك */
            border-radius: 4px;

            page-break-after: always;
        }

        /* اسم المنتج */
        .qr-box h4 {
            margin: 0;
            font-size: 9px;
            font-weight: bold;

            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;

            width: 100%;
        }

        /* الباركود */
        .qr-box img {
            width: 100%;
            height: 0.35in;
            object-fit: contain;
        }

        /* السعر */
        .price {
            font-size: 11px;
            font-weight: bold;
            color: #000;
        }

        /* اسم البراند */
        .brand {
            font-size: 6px;
            color: #555;
        }

        @media print {
            .qr-box {
                border: none; /* لو مش عايز البوردر في الطباعة */
            }
        }
    </style>
</head>

<body onload="window.print()">

@foreach($barcodes as $item)
    <div class="qr-box">

        <h4>{{ $item['name'] }}</h4>

        <img src="{{ $item['qr'] }}">

        <div class="price">
            {{ $item['price'] ?? '' }} ج
        </div>

        <div class="brand">
            Invanta
        </div>

    </div>
@endforeach

</body>
</html>
