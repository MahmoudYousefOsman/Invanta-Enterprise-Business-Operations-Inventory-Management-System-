<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>طباعة إيصال الصيانة</title>

    <style>
        body {
            font-family: "Tahoma", sans-serif;
            margin: 0;
            padding: 0;
        }

        .page {
            width: 148mm; /* A5 */
            min-height: 210mm;
            margin: auto;
            padding: 10mm;
            box-sizing: border-box;
            border: 1px solid #000;
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo img {
            width: 150px;
        }

        h2, h3 {
            text-align: center;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 14px;
        }

        td {
            padding: 4px 0;
            vertical-align: top;
        }

        .section-title {
            margin-top: 15px;
            font-weight: bold;
            font-size: 15px;
            text-decoration: underline;
        }

        /* --- للطباعة --- */
        @media print {
            .no-print {
                display: none;
            }
            body {
                margin: 0;
            }
            .page {
                border: none;
                padding: 0;
            }
        }
    </style>
</head>

<body onload="window.print()">

<!-- =======================
     ===  الوجه الأمامي ===
     ======================= -->
<div class="page">

    <div class="logo">
        <img src="{{ asset('assets/admin/img/invanta.jpeg') }}" alt="Invanta Logo">
    </div>

    <h3 class="pt-7"> اذن استلام صيانة للاصلاح في خلال 14 يوم بعد الميعاد والشركه غير مسئوله عن الجهاز</h3>

    <table>
        <tr>
            <td><strong>العميل:</strong> {{ $task->client->name }}</td>
            <td><strong>رقم الهاتف:</strong> {{ $task->client->phone }}</td>
        </tr>
        <tr>
            <td><strong>العنوان:</strong> {{ $task->client->address ?? '---' }}</td>
            <td><strong>تاريخ الاستلام:</strong> {{ $task->receipt_date }}</td>
        </tr>
        <tr>
            <td><strong>نوع الجهاز:</strong> {{ $task->device_type }}</td>
            <td><strong>الرقم التسلسلي:</strong> {{ $task->serial_number ?? '---' }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>الوصف:</strong> {{ $task->description }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>ملاحظات:</strong> {{ $task->notes ?? '---' }}</td>
        </tr>
    </table>

    <h3>التكلفة المالية</h3>
    <table>
        <tr>
            <td><strong>التكلفة:</strong> {{ $task->cost }}</td>
            <td><strong>المدفوع:</strong> {{ $task->payed ?? 0 }}</td>
            <td><strong>المتبقي:</strong> {{ $task->cost - ($task->payed ?? 0) }}</td>
        </tr>
    </table>

    <p><strong>المهندس المسؤول:</strong> {{ $task->engineer->name }}</p>

    <br><br>
    <p>أوافق على جميع ما ذكر في الإيصال</p>
    <p>التوقيع: ____________________</p>
</div>

<!-- =======================
     ===  الوجه الخلفي ===
     ======================= -->
<div class="page">

    <div class="logo">
        <img src="{{ asset('assets/admin/img/invanta.jpeg') }}" alt="Invanta Logo">
    </div>

    <h3>الشروط والأحكام</h3>

    <p style="line-height: 1.7; font-size: 14px;">
        - الصيانة تتم بدون الرجوع للعميل في حدود (100) جنيه. <br>
        - يتحمل العميل مبلغ (75) جنيه مصاريف إخطار بالأعطال في حالة عدم رغبته في إصلاح الجهاز. <br>
        - المركز مسؤول عن العيب فقط وغير مسؤول عن أي عيوب أخرى غير ظاهرة. <br>
        - الضمان لمدة أسبوع على نفس العطل فقط. <br>
        - في حالة عدم استلام الجهاز خلال 24 ساعة لا يتحمل المركز مسؤولية الأعطال الناتجة عن التأخير. <br>
        - المركز غير مسؤول عن حفظ بيانات الجهاز بعد شهر من تاريخ الإبلاغ بالإصلاح. <br>
        - في حالة رفض العميل الإصلاح يتم رفع الجهاز من الاستخدام بعد المدة المحددة. <br>
        - تدوين العطل بناءً على وصف العميل لحين التأكد منه. <br>
        - برجاء الاحتفاظ بالإيصال عند الحضور.
    </p>

    <br><br>
    <p style="text-align:center; font-weight:bold;">
        الاستعلام عن الجهاز وخدمة العملاء:<br>
         — 01001706328 —
    </p>
</div>

</body>
</html>
