<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>طباعة إيصال الصيانة</title>

    <style>
        * { box-sizing: border-box; }

        body {
            font-family: "Segoe UI", Tahoma, sans-serif;
            margin: 0;
            padding: 0;
            color: #1f2937;
            background: #fff;
        }

        .page {
            width: 148mm; /* A5 */
            min-height: 210mm;
            margin: auto;
            padding: 12mm;
            box-sizing: border-box;
            border: 1px solid #d8dee9;
        }
        .page + .page { margin-top: 8mm; }

        .head {
            display: flex;
            align-items: center;
            gap: 14px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 12px;
            margin-bottom: 12px;
        }
        .head img { width: 86px; height: auto; }
        .head .head-text { flex: 1; text-align: center; }
        .head .head-text .shop { font-weight: 800; font-size: 20px; color: #1e3a8a; }
        .head .head-text .doc {
            display: inline-block; margin-top: 4px;
            background: #2563eb; color: #fff; font-weight: 700;
            font-size: 12px; padding: 3px 16px; border-radius: 999px;
        }

        .notice {
            background: #eff5ff;
            border: 1px solid #bfd3fe;
            border-radius: 10px;
            padding: 8px 12px;
            font-size: 13px;
            font-weight: 600;
            color: #1e3a8a;
            text-align: center;
            margin-bottom: 14px;
        }

        .info {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            font-size: 14px;
            margin-bottom: 14px;
        }
        .info td {
            padding: 8px 12px;
            border-bottom: 1px solid #eef2f7;
            vertical-align: top;
            width: 50%;
        }
        .info tr:last-child td { border-bottom: none; }
        .info .label { color: #64748b; font-size: 12px; display: block; margin-bottom: 2px; }
        .info .value { font-weight: 700; }

        .section-title {
            font-weight: 800;
            font-size: 14px;
            color: #1e3a8a;
            margin: 14px 0 8px;
            padding-inline-start: 10px;
            border-inline-start: 4px solid #2563eb;
        }

        .finance {
            display: flex;
            gap: 10px;
            margin-bottom: 16px;
        }
        .finance .box {
            flex: 1;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
        }
        .finance .box .k { font-size: 12px; color: #64748b; }
        .finance .box .v { font-size: 18px; font-weight: 800; margin-top: 4px; }
        .finance .box.remain { background: #eff5ff; border-color: #2563eb; }
        .finance .box.remain .v { color: #1e3a8a; }

        .sign {
            margin-top: 26px;
            display: flex;
            justify-content: space-between;
            font-size: 14px;
        }

        .terms { line-height: 1.9; font-size: 13.5px; }
        .terms li { margin-bottom: 4px; }
        .contact {
            margin-top: 22px;
            text-align: center;
            font-weight: 800;
            color: #1e3a8a;
            border-top: 2px solid #2563eb;
            padding-top: 12px;
        }

        @media print {
            .no-print { display: none; }
            body { margin: 0; }
            .page { border: none; padding: 6mm; }
            .page + .page { page-break-before: always; margin-top: 0; }
        }
    </style>
</head>

<body onload="window.print()">

<!-- ===  الوجه الأمامي === -->
<div class="page">

    <div class="head">
        <img src="{{ asset('assets/admin/img/invanta.jpeg') }}" alt="Invanta Logo">
        <div class="head-text">
            <div class="shop">Invanta</div>
            <div class="doc">إيصال استلام صيانة</div>
        </div>
    </div>

    <div class="notice">
        إذن استلام صيانة للإصلاح خلال 14 يوم، وبعد الميعاد الشركة غير مسؤولة عن الجهاز
    </div>

    <table class="info">
        <tr>
            <td><span class="label">العميل</span><span class="value">{{ $task->client->name }}</span></td>
            <td><span class="label">رقم الهاتف</span><span class="value">{{ $task->client->phone }}</span></td>
        </tr>
        <tr>
            <td><span class="label">العنوان</span><span class="value">{{ $task->client->address ?? '---' }}</span></td>
            <td><span class="label">تاريخ الاستلام</span><span class="value">{{ $task->receipt_date }}</span></td>
        </tr>
        <tr>
            <td><span class="label">نوع الجهاز</span><span class="value">{{ $task->device_type }}</span></td>
            <td><span class="label">الرقم التسلسلي</span><span class="value">{{ $task->serial_number ?? '---' }}</span></td>
        </tr>
        <tr>
            <td colspan="2"><span class="label">الوصف</span><span class="value">{{ $task->description }}</span></td>
        </tr>
        <tr>
            <td colspan="2"><span class="label">ملاحظات</span><span class="value">{{ $task->notes ?? '---' }}</span></td>
        </tr>
    </table>

    <div class="section-title">التكلفة المالية</div>
    <div class="finance">
        <div class="box"><div class="k">التكلفة</div><div class="v">{{ number_format($task->cost, 2) }}</div></div>
        <div class="box"><div class="k">المدفوع</div><div class="v">{{ number_format($task->payed ?? 0, 2) }}</div></div>
        <div class="box remain"><div class="k">المتبقي</div><div class="v">{{ number_format($task->cost - ($task->payed ?? 0), 2) }}</div></div>
    </div>

    <p><strong>المهندس المسؤول:</strong> {{ $task->engineer->name }}</p>

    <div class="sign">
        <span>أوافق على جميع ما ذكر في الإيصال</span>
        <span>التوقيع: ____________________</span>
    </div>
</div>

<!-- ===  الوجه الخلفي === -->
<div class="page">

    <div class="head">
        <img src="{{ asset('assets/admin/img/invanta.jpeg') }}" alt="Invanta Logo">
        <div class="head-text">
            <div class="shop">Invanta</div>
            <div class="doc">الشروط والأحكام</div>
        </div>
    </div>

    <ul class="terms">
        <li>الصيانة تتم بدون الرجوع للعميل في حدود (100) جنيه.</li>
        <li>يتحمل العميل مبلغ (75) جنيه مصاريف إخطار بالأعطال في حالة عدم رغبته في إصلاح الجهاز.</li>
        <li>المركز مسؤول عن العيب فقط وغير مسؤول عن أي عيوب أخرى غير ظاهرة.</li>
        <li>الضمان لمدة أسبوع على نفس العطل فقط.</li>
        <li>في حالة عدم استلام الجهاز خلال 24 ساعة لا يتحمل المركز مسؤولية الأعطال الناتجة عن التأخير.</li>
        <li>المركز غير مسؤول عن حفظ بيانات الجهاز بعد شهر من تاريخ الإبلاغ بالإصلاح.</li>
        <li>في حالة رفض العميل الإصلاح يتم رفع الجهاز من الاستخدام بعد المدة المحددة.</li>
        <li>تدوين العطل بناءً على وصف العميل لحين التأكد منه.</li>
        <li>برجاء الاحتفاظ بالإيصال عند الحضور.</li>
    </ul>

    <div class="contact">
        الاستعلام عن الجهاز وخدمة العملاء<br>
        — 01001706328 —
    </div>
</div>

</body>
</html>
