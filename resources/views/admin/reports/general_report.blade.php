@extends('admin.layouts.master')
@section('title', 'التقرير العام')

@push('styles')
<style>
    .gr-icon {
        width: 44px; height: 44px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .gr-icon-blue   { background: rgba(37,99,235,.12);  color: #2563eb; }
    .gr-icon-violet { background: rgba(124,58,237,.12); color: #7c3aed; }
    .gr-icon-amber  { background: rgba(245,158,11,.12); color: #f59e0b; }
    .gr-icon-rose   { background: rgba(244,63,94,.12);  color: #f43f5e; }
    .gr-icon-green  { background: rgba(16,185,129,.12); color: #10b981; }
    .gr-icon-cyan   { background: rgba(6,182,212,.12);  color: #06b6d4; }

    .gr-profit-card {
        border-radius: var(--inv-radius, 16px);
        background: linear-gradient(135deg, #065f46 0%, #059669 50%, #10b981 100%);
        color: #fff;
        overflow: hidden;
        position: relative;
        box-shadow: 0 10px 25px rgba(16, 185, 129, 0.22);
        border: none;
        transition: transform .25s ease, box-shadow .25s ease;
    }
    .gr-profit-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 14px 30px rgba(16, 185, 129, 0.32);
    }
    .gr-profit-card::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 160px; height: 160px;
        border-radius: 50%;
        background: rgba(255,255,255,.08);
    }
    .gr-profit-card.loss {
        background: linear-gradient(135deg, #991b1b 0%, #dc2626 50%, #ef4444 100%);
        box-shadow: 0 10px 25px rgba(220, 38, 38, 0.22);
    }
    .gr-profit-card.loss:hover {
        box-shadow: 0 14px 30px rgba(220, 38, 38, 0.32);
    }

    @media (min-width: 576px) {
        .border-sm-start {
            border-inline-start: 1px solid var(--tblr-border-color, rgba(0,0,0,0.08));
            padding-inline-start: 1.5rem !important;
        }
    }
</style>
@endpush

@section('content')
<div class="page-header d-print-none">
    <div class="col-lg-11 mx-lg-auto">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">التقارير</div>
                <h2 class="page-title text-primary">التقرير العام للأرباح</h2>
            </div>
            <div class="col-auto d-flex gap-2">
                <button onclick="window.print()" class="btn btn-outline-primary d-flex align-items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"/><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"/><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"/></svg>
                    طباعة التقرير
                </button>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="col-lg-11 mx-lg-auto">

        {{-- ── 1. شريط الفلترة والأكشن الأفقي ────────────────── --}}
        <div class="card mb-4 d-print-none shadow-sm" style="border-radius: var(--inv-radius-sm); border: 1px solid var(--tblr-border-color);">
            <div class="card-body py-3">
                <form method="GET" action="{{ route('admin.general.report') }}">
                    <div class="row g-3 align-items-center justify-content-between">
                        <div class="col-md-auto d-flex align-items-center gap-2">
                            <div class="gr-icon gr-icon-blue" style="width:36px; height:36px; border-radius:8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="10" cy="10" r="7"/><path d="M21 21l-6 -6"/></svg>
                            </div>
                            <div>
                                <span class="fw-bold fs-4">تصفية التقرير المالي</span>
                                <div class="text-muted small" style="font-size:0.75rem;">اختر الفترة الزمنية لعرض الأرباح والمؤشرات المحدثة</div>
                            </div>
                        </div>
                        <div class="col-md-auto">
                            <div class="row g-2 align-items-center">
                                <div class="col-sm-5 d-flex align-items-center gap-2">
                                    <label class="form-label small fw-semibold text-muted mb-0 text-nowrap">من تاريخ</label>
                                    <input type="date" name="from_date" class="form-control form-control-sm" value="{{ request('from_date') }}">
                                </div>
                                <div class="col-sm-5 d-flex align-items-center gap-2">
                                    <label class="form-label small fw-semibold text-muted mb-0 text-nowrap">إلى تاريخ</label>
                                    <input type="date" name="to_date" class="form-control form-control-sm" value="{{ request('to_date') }}">
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-primary btn-sm w-100 d-flex align-items-center justify-content-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"/><path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"/></svg>
                                        تحديث
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- ── 2. المؤشرات المالية الرئيسية (4 كروت) ───────── --}}
        <div class="row row-deck g-3 mb-4">
            {{-- كارت صافي الأرباح --}}
            <div class="col-sm-6 col-lg-3">
                <div class="card gr-profit-card p-3 h-100 {{ ($profit ?? 0) < 0 ? 'loss' : '' }}">
                    <div class="d-flex flex-column justify-content-between h-100">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span style="color:rgba(255,255,255,.85); font-size:.85rem; font-weight:600;">صافي الربح الإجمالي</span>
                            <div style="width:38px;height:38px;border-radius:10px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;">
                                @if(($profit ?? 0) >= 0)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="2.5" stroke="#fff" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8"/><path d="M14 7l7 0l0 7"/></svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="2.5" stroke="#fff" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7l6 6l4 -4l8 8"/><path d="M14 17l7 0l0 -7"/></svg>
                                @endif
                            </div>
                        </div>
                        <div>
                            <div style="font-size:1.6rem; font-weight:800; color:#fff; line-height:1.2; letter-spacing: -.02em;">
                                {{ number_format($profit ?? 0, 2) }} ج.م
                            </div>
                            <small style="color:rgba(255,255,255,.75); font-size:0.72rem; margin-top: 6px; display: block; cursor: help;" 
                                   data-bs-toggle="tooltip" 
                                   data-bs-placement="top" 
                                   title="المبيعات (الطلبات + المهام المنجزة) − التكاليف (المشتريات + المرتجعات)">
                                <i class="fa-solid fa-circle-info me-1"></i>
                                الإيرادات − المصروفات
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- كارت إجمالي الإيرادات --}}
            <div class="col-sm-6 col-lg-3">
                <div class="card inv-lift p-3 h-100">
                    <div class="d-flex flex-column justify-content-between h-100">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-muted small fw-bold">إجمالي الإيرادات</span>
                            <div class="gr-icon gr-icon-blue" style="width: 38px; height: 38px; border-radius: 10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9"/><path d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 1 0 0 4h2a2 2 0 1 1 0 4h-2a2 2 0 0 1 -1.8 -1"/><path d="M12 6v2"/><path d="M12 16v2"/></svg>
                            </div>
                        </div>
                        <div>
                            <div class="fs-2 fw-bold mb-2">{{ number_format($totalSales ?? 0, 2) }} ج.م</div>
                            <div class="d-flex justify-content-between text-muted small border-top pt-2" style="font-size: 0.72rem;">
                                <span>الطلبات: <strong>{{ number_format($ordersTotal ?? 0, 2) }}</strong></span>
                                <span>المهام: <strong>{{ number_format($tasksTotal ?? 0, 2) }}</strong></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- كارت إجمالي المشتريات --}}
            <div class="col-sm-6 col-lg-3">
                <div class="card inv-lift p-3 h-100">
                    <div class="d-flex flex-column justify-content-between h-100">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-muted small fw-bold">إجمالي المشتريات</span>
                            <div class="gr-icon gr-icon-amber" style="width: 38px; height: 38px; border-radius: 10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6.331 8h11.339a2 2 0 0 1 1.977 2.304l-1.255 8.152a3 3 0 0 1 -2.966 2.544h-6.86a3 3 0 0 1 -2.966 -2.544l-1.255 -8.152a2 2 0 0 1 1.977 -2.304z"/><path d="M9 11v-5a3 3 0 0 1 6 0v5"/></svg>
                            </div>
                        </div>
                        <div>
                            <div class="fs-2 fw-bold mb-2">{{ number_format($purchasesTotal ?? 0, 2) }} ج.م</div>
                            <div class="text-muted small border-top pt-2" style="font-size: 0.72rem;">
                                <span>إجمالي مصروفات التوريد والشراء</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- كارت إجمالي المرتجعات --}}
            <div class="col-sm-6 col-lg-3">
                <div class="card inv-lift p-3 h-100">
                    <div class="d-flex flex-column justify-content-between h-100">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-muted small fw-bold">إجمالي المرتجعات</span>
                            <div class="gr-icon gr-icon-rose" style="width: 38px; height: 38px; border-radius: 10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.933 13.041a8 8 0 1 1 -9.925 -8.788c3.899 -1 7.935 1.007 9.425 4.747"/><path d="M20 4v5h-5"/></svg>
                            </div>
                        </div>
                        <div>
                            <div class="fs-2 fw-bold mb-2">{{ number_format($returnsTotal ?? 0, 2) }} ج.م</div>
                            <div class="text-muted small border-top pt-2" style="font-size: 0.72rem;">
                                <span>إجمالي خسائر وقيم المرتجعات</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── 3. تحليل الحالات والنسب المئوية (كارتين عريضين) ── --}}
        <div class="row row-deck g-3 mb-4">
            {{-- كارت تحليل المبيعات والطلبات --}}
            <div class="col-lg-6">
                <div class="card inv-lift h-100">
                    <div class="card-body">
                        <div class="row align-items-center h-100">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div class="gr-icon gr-icon-violet" style="width:32px; height:32px; border-radius:8px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="9" cy="19" r="2"/><circle cx="17" cy="19" r="2"/><path d="M17 17h-11v-14h-2"/><path d="M6 5l14 1l-1 7h-13"/></svg>
                                    </div>
                                    <span class="fw-bold text-secondary small">عمليات البيع والطلبات</span>
                                </div>
                                <div class="text-muted small">إجمالي الطلبات الفعلي</div>
                                <div class="fs-1 fw-bold mb-1">{{ $ordersCount ?? 0 }} <span class="fs-4 fw-normal text-muted">طلب</span></div>
                                <div class="text-primary fw-semibold small">بقيمة إجمالية: {{ number_format($ordersTotal ?? 0, 2) }} ج.م</div>
                            </div>
                            <div class="col-sm-6 border-sm-start d-flex flex-column justify-content-center h-100">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1 small">
                                        <span class="text-muted">طلبات مدفوعة</span>
                                        <span class="fw-bold text-success">{{ $ordersPaid ?? 0 }}</span>
                                    </div>
                                    @php
                                        $paidPercent = $ordersCount > 0 ? ($ordersPaid / $ordersCount) * 100 : 0;
                                    @endphp
                                    <div class="progress progress-sm" style="height: 6px; border-radius:3px;">
                                        <div class="progress-bar bg-success" style="width: {{ $paidPercent }}%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex justify-content-between mb-1 small">
                                        <span class="text-muted">طلبات غير مدفوعة</span>
                                        <span class="fw-bold text-warning">{{ $ordersUnpaid ?? 0 }}</span>
                                    </div>
                                    @php
                                        $unpaidPercent = $ordersCount > 0 ? ($ordersUnpaid / $ordersCount) * 100 : 0;
                                    @endphp
                                    <div class="progress progress-sm" style="height: 6px; border-radius:3px;">
                                        <div class="progress-bar bg-warning" style="width: {{ $unpaidPercent }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- كارت تحليل خدمات الصيانة والمهام --}}
            <div class="col-lg-6">
                <div class="card inv-lift h-100">
                    <div class="card-body">
                        <div class="row align-items-center h-100">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div class="gr-icon gr-icon-cyan" style="width:32px; height:32px; border-radius:8px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 10h3v-3l-3.5 -3.5a6 6 0 0 1 8 8l6 6a2 2 0 0 1 -3 3l-6 -6a6 6 0 0 1 -8 -8l3.5 3.5"/></svg>
                                    </div>
                                    <span class="fw-bold text-secondary small">عمليات الصيانة والمهام</span>
                                </div>
                                <div class="text-muted small">إجمالي المهام المسجلة</div>
                                <div class="fs-1 fw-bold mb-1">{{ $tasksCount ?? 0 }} <span class="fs-4 fw-normal text-muted">مهمة</span></div>
                                <div class="text-success fw-semibold small">بقيمة إجمالية: {{ number_format($tasksTotal ?? 0, 2) }} ج.م</div>
                            </div>
                            <div class="col-sm-6 border-sm-start d-flex flex-column justify-content-center h-100">
                                @php
                                    $totalTasksCalculated = ($tasksCompleted ?? 0) + ($tasksPending ?? 0) + ($tasksCancelled ?? 0);
                                    $compPercent = $totalTasksCalculated > 0 ? (($tasksCompleted ?? 0) / $totalTasksCalculated) * 100 : 0;
                                    $pendPercent = $totalTasksCalculated > 0 ? (($tasksPending ?? 0) / $totalTasksCalculated) * 100 : 0;
                                    $cancPercent = $totalTasksCalculated > 0 ? (($tasksCancelled ?? 0) / $totalTasksCalculated) * 100 : 0;
                                @endphp
                                <div class="d-flex justify-content-between mb-1 small">
                                    <span class="text-muted">التوزيع النسبي للمهام</span>
                                    <span class="fw-bold text-primary" style="font-size:0.75rem;">منجزة / جديدة / ملغية</span>
                                </div>
                                <div class="progress progress-sm mb-3" style="height: 8px; border-radius:4px;">
                                    <div class="progress-bar bg-success" style="width: {{ $compPercent }}%" data-bs-toggle="tooltip" title="منجزة: {{ $tasksCompleted }}"></div>
                                    <div class="progress-bar bg-primary" style="width: {{ $pendPercent }}%" data-bs-toggle="tooltip" title="جديدة: {{ $tasksPending }}"></div>
                                    <div class="progress-bar bg-danger" style="width: {{ $cancPercent }}%" data-bs-toggle="tooltip" title="ملغية: {{ $tasksCancelled }}"></div>
                                </div>
                                <div class="row g-1 text-muted" style="font-size: 0.72rem;">
                                    <div class="col-4"><span class="badge bg-success" style="width:6px;height:6px;padding:0;border-radius:50%;display:inline-block;margin-left:4px;"></span>منجزة: {{ $tasksCompleted }}</div>
                                    <div class="col-4"><span class="badge bg-primary" style="width:6px;height:6px;padding:0;border-radius:50%;display:inline-block;margin-left:4px;"></span>جديدة: {{ $tasksPending }}</div>
                                    <div class="col-4"><span class="badge bg-danger" style="width:6px;height:6px;padding:0;border-radius:50%;display:inline-block;margin-left:4px;"></span>ملغية: {{ $tasksCancelled }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── 4. الرسوم البيانية (Charts Grid) ──────────────── --}}
        <div class="row row-cards mb-4">
            {{-- الاتجاه الشهري --}}
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h3 class="card-title fw-bold mb-0">الاتجاه الشهري للإيرادات والمصروفات</h3>
                                <div class="text-muted small">آخر 7 أشهر</div>
                            </div>
                            <div class="d-flex gap-3 small text-muted" style="font-size:0.75rem;">
                                <span><span class="badge bg-primary" style="width:8px;height:8px;padding:0;border-radius:50%;display:inline-block;margin-left:4px;"></span>أوردرات</span>
                                <span><span class="badge bg-success" style="width:8px;height:8px;padding:0;border-radius:50%;display:inline-block;margin-left:4px;"></span>مهام</span>
                                <span><span class="badge bg-warning" style="width:8px;height:8px;padding:0;border-radius:50%;display:inline-block;margin-left:4px;"></span>مشتريات</span>
                            </div>
                        </div>
                        <div style="height: 280px;">
                            <canvas id="monthlyTrendChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- توزيع حالة المهام --}}
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-body p-3">
                        <h3 class="card-title fw-bold mb-1">توزيع حالة المهام</h3>
                        <div class="text-muted small mb-3">{{ ($tasksCount ?? 0) }} مهمة إجمالاً</div>
                        <div style="height: 210px; display:flex; align-items:center; justify-content:center;">
                            <canvas id="tasksDonutChart"></canvas>
                        </div>
                        <div class="mt-3 d-flex flex-column gap-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="d-flex align-items-center gap-2 small">
                                    <span style="width:8px;height:8px;border-radius:50%;background:#10b981;display:inline-block;"></span> منجزة
                                </span>
                                <span class="fw-bold small">{{ $tasksCompleted ?? 0 }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="d-flex align-items-center gap-2 small">
                                    <span style="width:8px;height:8px;border-radius:50%;background:#2563eb;display:inline-block;"></span> جديدة
                                </span>
                                <span class="fw-bold small">{{ $tasksPending ?? 0 }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="d-flex align-items-center gap-2 small">
                                    <span style="width:8px;height:8px;border-radius:50%;background:#f43f5e;display:inline-block;"></span> ملغية
                                </span>
                                <span class="fw-bold small">{{ $tasksCancelled ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── 5. صف ثاني من الرسوم البيانية ────────────────── --}}
        <div class="row row-cards mb-4">
            {{-- توزيع المعاملات --}}
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-body p-3">
                        <h3 class="card-title fw-bold mb-1">توزيع المعاملات (الطلبات vs المهام)</h3>
                        <div class="text-muted small mb-3">{{ ($ordersCount ?? 0) + ($tasksCount ?? 0) }} معاملة إجمالاً</div>
                        <div style="height: 210px; display:flex; align-items:center; justify-content:center;">
                            <canvas id="transactionsDonutChart"></canvas>
                        </div>
                        <div class="mt-3 d-flex flex-column gap-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="d-flex align-items-center gap-2 small">
                                    <span style="width:8px;height:8px;border-radius:50%;background:#2563eb;display:inline-block;"></span> إجمالي الطلبات
                                </span>
                                <span class="fw-bold small">{{ $ordersCount ?? 0 }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="d-flex align-items-center gap-2 small">
                                    <span style="width:8px;height:8px;border-radius:50%;background:#7c3aed;display:inline-block;"></span> إجمالي المهام
                                </span>
                                <span class="fw-bold small">{{ $tasksCount ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- مقارنة الإيرادات والمصروفات --}}
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h3 class="card-title fw-bold mb-0">مقارنة الإيرادات والمصروفات</h3>
                                <div class="text-muted small">شهر بشهر آخر 7 أشهر</div>
                            </div>
                        </div>
                        <div style="height: 260px;">
                            <canvas id="revenueVsExpenseChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function () {
    const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
    const gridColor  = isDark ? 'rgba(255,255,255,.05)' : 'rgba(15,23,42,.06)';
    const textColor  = isDark ? '#94a3b8' : '#64748b';

    const monthLabels   = {!! json_encode($monthLabels) !!};
    const monthOrders   = {!! json_encode($monthOrders) !!};
    const monthTasks    = {!! json_encode($monthTasks) !!};
    const monthPurchases = {!! json_encode($monthPurchases) !!};

    const tasksPending    = {{ $tasksPending ?? 0 }};
    const tasksCompleted  = {{ $tasksCompleted ?? 0 }};
    const tasksCancelled  = {{ $tasksCancelled ?? 0 }};

    const ordersCount  = {{ $ordersCount ?? 0 }};
    const tasksCount   = {{ $tasksCount ?? 0 }};

    // Initialize Bootstrap Tooltips
    setTimeout(() => {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        if (typeof bootstrap !== 'undefined') {
            [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        }
    }, 400);

    // ── 1. Monthly Trend Line ──────────────────────────────
    const ctxTrend = document.getElementById('monthlyTrendChart').getContext('2d');

    const gradOrders = ctxTrend.createLinearGradient(0, 0, 0, 280);
    gradOrders.addColorStop(0, 'rgba(37,99,235,0.18)');
    gradOrders.addColorStop(1, 'rgba(37,99,235,0.01)');

    const gradTasks = ctxTrend.createLinearGradient(0, 0, 0, 280);
    gradTasks.addColorStop(0, 'rgba(16,185,129,0.18)');
    gradTasks.addColorStop(1, 'rgba(16,185,129,0.01)');

    const gradPurchases = ctxTrend.createLinearGradient(0, 0, 0, 280);
    gradPurchases.addColorStop(0, 'rgba(245,158,11,0.18)');
    gradPurchases.addColorStop(1, 'rgba(245,158,11,0.01)');

    new Chart(ctxTrend, {
        type: 'line',
        data: {
            labels: monthLabels,
            datasets: [
                {
                    label: 'أوردرات',
                    data: monthOrders,
                    borderColor: '#2563eb',
                    backgroundColor: gradOrders,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2.5,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: isDark ? '#1e293b' : '#fff',
                    pointBorderWidth: 1.5,
                },
                {
                    label: 'مهام',
                    data: monthTasks,
                    borderColor: '#10b981',
                    backgroundColor: gradTasks,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2.5,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: isDark ? '#1e293b' : '#fff',
                    pointBorderWidth: 1.5,
                },
                {
                    label: 'مشتريات',
                    data: monthPurchases,
                    borderColor: '#f59e0b',
                    backgroundColor: gradPurchases,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2.5,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#f59e0b',
                    pointBorderColor: isDark ? '#1e293b' : '#fff',
                    pointBorderWidth: 1.5,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.dataset.label}: ${Number(ctx.raw).toLocaleString('ar-EG', {minimumFractionDigits:2})} ج.م`
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: textColor, font: { size: 11 } }
                },
                y: {
                    grid: { color: gridColor },
                    ticks: { color: textColor }
                }
            }
        }
    });

    // ── 2. Tasks Donut ────────────────────────────────────
    const donutOpts = {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '70%',
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => ` ${ctx.label}: ${ctx.raw}`
                }
            }
        }
    };

    new Chart(document.getElementById('tasksDonutChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['منجزة', 'جديدة', 'ملغية'],
            datasets: [{
                data: [tasksCompleted, tasksPending, tasksCancelled],
                backgroundColor: ['#10b981', '#2563eb', '#f43f5e'],
                borderWidth: 0,
                hoverOffset: 6
            }]
        },
        options: donutOpts
    });

    // ── 3. Transactions Donut ─────────────────────────────
    new Chart(document.getElementById('transactionsDonutChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['الطلبات', 'المهام'],
            datasets: [{
                data: [ordersCount, tasksCount],
                backgroundColor: ['#2563eb', '#7c3aed'],
                borderWidth: 0,
                hoverOffset: 6
            }]
        },
        options: donutOpts
    });

    // ── 4. Revenue vs Expense Grouped Bar ─────────────────
    const totalByMonth = monthOrders.map((v, i) => v + monthTasks[i]);

    new Chart(document.getElementById('revenueVsExpenseChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: monthLabels,
            datasets: [
                {
                    label: 'الإيرادات',
                    data: totalByMonth,
                    backgroundColor: '#2563eb',
                    borderRadius: 5,
                    barPercentage: 0.55,
                    categoryPercentage: 0.7
                },
                {
                    label: 'المصروفات',
                    data: monthPurchases,
                    backgroundColor: '#f59e0b',
                    borderRadius: 5,
                    barPercentage: 0.55,
                    categoryPercentage: 0.7
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { color: textColor, font: { size: 12 } }
                },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.dataset.label}: ${Number(ctx.raw).toLocaleString('ar-EG', {minimumFractionDigits:2})} ج.م`
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: textColor, font: { size: 11 } }
                },
                y: {
                    grid: { color: gridColor },
                    ticks: { color: textColor }
                }
            }
        }
    });

    // إعادة بناء عند تغيير الثيم
    document.addEventListener('invanta:theme', () => location.reload());
})();
</script>
@endpush
