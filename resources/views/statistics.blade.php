@extends('admin.layouts.master')

@push('styles')
    <style>
        /* Modern dashboard design custom tokens */
        :root {
            --inv-glow-blue: rgba(37, 99, 235, 0.15);
            --inv-card-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
            --inv-card-hover-shadow: 0 10px 25px rgba(15, 23, 42, 0.08);
        }

        .dashboard-welcome {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: #ffffff !important;
            border-radius: 16px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 6px 24px rgba(15, 23, 42, 0.18);
            border: none;
        }
        
        .dashboard-welcome .text-muted {
            color: #94a3b8 !important;
        }

        .dashboard-welcome::after {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            width: 320px;
            height: 100%;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.18) 0%, transparent 75%);
            pointer-events: none;
        }

        .inv-card {
            border-radius: 12px;
            border: 1px solid var(--tblr-border-color, rgba(15, 23, 42, 0.06));
            background: var(--tblr-card-bg, #ffffff);
            box-shadow: var(--inv-card-shadow);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .inv-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--inv-card-hover-shadow);
        }

        .sparkline-container {
            position: relative;
            width: 100%;
            height: 48px;
        }

        /* Radial Progress Ring Component */
        .radial-progress-container {
            position: relative;
            width: 90px;
            height: 90px;
            margin: 0 auto;
        }

        .radial-progress-svg {
            transform: rotate(-90deg);
        }

        .radial-progress-bg {
            fill: none;
            stroke: var(--tblr-border-color, rgba(15, 23, 42, 0.06));
            stroke-width: 8;
        }

        .radial-progress-bar {
            fill: none;
            stroke: #2563eb;
            stroke-width: 8;
            stroke-linecap: round;
            transition: stroke-dashoffset 0.8s ease-in-out;
        }

        .radial-progress-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--tblr-body-color);
        }

        /* Micro status card adjustments */
        .stat-card-micro {
            border-radius: 12px;
            border: 1px solid var(--tblr-border-color, rgba(15, 23, 42, 0.06));
            transition: all 0.25s ease;
        }
        
        .stat-card-micro:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
        }

        .inv-icon-wrapper {
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }


        /* Storage multi-segment bar custom classes */
        .storage-bar-regular { background-color: #2563eb !important; }
        .storage-bar-system { background-color: #06b6d4 !important; }
        .storage-bar-shared { background-color: #10b981 !important; }
        .storage-bar-free { background-color: #e2e8f0 !important; }
        [data-bs-theme="dark"] .storage-bar-free { background-color: #334155 !important; }

        /* Notification feed items custom styling */
        .feed-container {
            border-right: 2px solid var(--tblr-border-color, rgba(15, 23, 42, 0.06));
            padding-right: 1.5rem;
            margin-right: 0.5rem;
        }

        .feed-item {
            position: relative;
            padding-bottom: 1.25rem;
        }

        .feed-item::before {
            content: '';
            position: absolute;
            right: -28px;
            top: 6px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: var(--tblr-primary, #2563eb);
            border: 2px solid var(--tblr-body-bg, #ffffff);
            z-index: 2;
        }

        .feed-item:last-child {
            padding-bottom: 0;
        }

        .feed-icon {
            position: absolute;
            right: -42px;
            top: 0;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            z-index: 1;
        }
        
        .avatar-letter {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #e2e8f0;
            color: #334155;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
        }
        [data-bs-theme="dark"] .avatar-letter {
            background-color: #334155;
            color: #cbd5e1;
        }
    </style>
@endpush

@section('content')
    <div class="page-header d-print-none">
        <div class="col-lg-12">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">نظرة عامة</div>
                    <h2 class="page-title text-primary">لوحة الإحصاءات والتقارير العامة</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">

                <!-- Row 1: Welcome Box, Total Users, Active Users -->
                
                <!-- Welcome Banner Card -->
                <div class="col-lg-6 col-xl-5">
                    <div class="card dashboard-welcome h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <h2 class="fw-bold mb-2 text-white">مرحباً بعودتك، {{ $adminName }}</h2>
                                    <p class="text-muted small mb-3">
                                        لديك <span class="text-warning fw-bold">{{ $newMessagesCount }}</span> طلبات صيانة معلقة، بالإضافة إلى <span class="text-info fw-bold">{{ $newNotificationsCount }}</span> عملاء جدد هذا الشهر.
                                    </p>
                                </div>
                                <div class="col-5 text-center">
                                    <!-- Premium Clean Dashboard Illustration -->
                                    <svg viewBox="0 0 200 150" class="w-100" style="max-height: 120px;">
                                        <defs>
                                            <linearGradient id="illusGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                                <stop offset="0%" stop-color="#3b82f6" />
                                                <stop offset="100%" stop-color="#1d4ed8" />
                                            </linearGradient>
                                            <linearGradient id="illusGradCyan" x1="0%" y1="0%" x2="100%" y2="100%">
                                                <stop offset="0%" stop-color="#06b6d4" />
                                                <stop offset="100%" stop-color="#0891b2" />
                                            </linearGradient>
                                        </defs>
                                        <!-- Outer Grid Circle -->
                                        <circle cx="100" cy="75" r="55" fill="none" stroke="rgba(59, 130, 246, 0.12)" stroke-width="1.5" stroke-dasharray="4 4"/>
                                        <circle cx="100" cy="75" r="40" fill="none" stroke="rgba(59, 130, 246, 0.08)" stroke-width="1"/>
                                        
                                        <!-- Dashboard Screens Represented as Vector Elements -->
                                        <rect x="55" y="45" width="90" height="60" rx="6" fill="#1e293b" stroke="rgba(255,255,255,0.06)" stroke-width="2" />
                                        <rect x="63" y="53" width="74" height="34" rx="3" fill="#0f172a" />
                                        
                                        <!-- Graph Bars inside Screen -->
                                        <rect x="70" y="70" width="8" height="12" rx="1" fill="url(#illusGrad)" />
                                        <rect x="82" y="64" width="8" height="18" rx="1" fill="url(#illusGradCyan)" />
                                        <rect x="94" y="58" width="8" height="24" rx="1" fill="url(#illusGrad)" />
                                        <rect x="106" y="67" width="8" height="15" rx="1" fill="url(#illusGradCyan)" />
                                        <rect x="118" y="61" width="8" height="21" rx="1" fill="url(#illusGrad)" />
                                        
                                        <!-- Screen Stand -->
                                        <path d="M92 105 h16 l4 15 h-24 z" fill="#334155" />
                                        <rect x="80" y="120" width="40" height="4" rx="1" fill="#475569" />
                                        
                                        <!-- Floating Badge (Checkmark) -->
                                        <g transform="translate(135, 35)">
                                            <circle cx="12" cy="12" r="14" fill="#10b981" />
                                            <path d="M7 12 l3 3 l7 -7" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            
                            <div class="border-top border-dark border-opacity-20 pt-3 mt-3">
                                <div class="row text-center text-sm-start">
                                    <div class="col-sm-6 mb-2 mb-sm-0">
                                        <div class="text-muted small">مبيعات اليوم</div>
                                        <div class="d-flex align-items-center justify-content-center justify-content-sm-start">
                                            <span class="fs-2 fw-bold me-2">{{ number_format($todaySalesSum, 2) }} ج.م</span>
                                            @if($todaySalesGrowth >= 0)
                                                <span class="badge bg-green text-green-fg py-1">+{{ number_format($todaySalesGrowth, 1) }}%</span>
                                            @else
                                                <span class="badge bg-red text-red-fg py-1">{{ number_format($todaySalesGrowth, 1) }}%</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="text-muted small">معدل النمو الشهري</div>
                                        <div class="d-flex align-items-center justify-content-center justify-content-sm-start">
                                            <span class="fs-2 fw-bold me-2">{{ number_format($growthRatePercent, 1) }}%</span>
                                            @if($growthRatePercent >= 0)
                                                <span class="text-green small d-flex align-items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8"/><path d="M14 7l7 0l0 7"/></svg>
                                                    تصاعدي
                                                </span>
                                            @else
                                                <span class="text-danger small d-flex align-items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7l6 6l4 -4l8 8"/><path d="M14 17l7 0l0 -7"/></svg>
                                                    تنازلي
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Users Card -->
                <div class="col-sm-6 col-lg-3 col-xl-3">
                    <div class="card inv-card h-100">
                        <div class="card-body d-flex flex-column justify-content-between p-3">
                            <div>
                                <div class="text-muted small fw-bold mb-1">إجمالي العملاء</div>
                                <div class="d-flex align-items-baseline">
                                    <span class="fs-1 fw-bold me-2">{{ number_format($totalClientsCount) }}</span>
                                    @if($clientsGrowthPercent >= 0)
                                        <span class="text-green small d-inline-flex align-items-center fw-bold">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" class="me-0.5"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8"/><path d="M14 7l7 0l0 7"/></svg>
                                            {{ number_format($clientsGrowthPercent, 1) }}%
                                        </span>
                                    @else
                                        <span class="text-danger small d-inline-flex align-items-center fw-bold">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" class="me-0.5"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7l6 6l4 -4l8 8"/><path d="M14 17l7 0l0 -7"/></svg>
                                            {{ number_format(abs($clientsGrowthPercent), 1) }}%
                                        </span>
                                    @endif
                                </div>
                                <div class="text-muted small">عملاء مسجلين بقاعدة البيانات</div>
                            </div>
                            <div class="sparkline-container mt-3">
                                <canvas id="totalUsersSparkline" height="45"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Users Card -->
                <div class="col-sm-6 col-lg-3 col-xl-4">
                    <div class="card inv-card h-100">
                        <div class="card-body p-3">
                            <div class="row align-items-center h-100">
                                <div class="col-7 d-flex flex-column justify-content-between h-100" style="min-height: 120px;">
                                    <div>
                                        <div class="text-muted small fw-bold mb-1">العملاء النشطون</div>
                                        <div class="d-flex align-items-baseline">
                                            <span class="fs-1 fw-bold me-2">{{ number_format($activeClientsCount) }}</span>
                                            @if($activeClientsGrowthPercent >= 0)
                                                <span class="text-green small d-inline-flex align-items-center fw-bold">
                                                    +{{ number_format($activeClientsGrowthPercent, 1) }}%
                                                </span>
                                            @else
                                                <span class="text-danger small d-inline-flex align-items-center fw-bold">
                                                    {{ number_format($activeClientsGrowthPercent, 1) }}%
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-muted small">عملاء قاموا بعمليات شراء أو صيانة في آخر 30 يوماً.</div>
                                </div>
                                <div class="col-5 text-center">
                                    <div class="radial-progress-container">
                                        <svg class="radial-progress-svg" width="90" height="90" viewBox="0 0 100 100">
                                            <circle class="radial-progress-bg" cx="50" cy="50" r="40" />
                                            <circle class="radial-progress-bar" cx="50" cy="50" r="40" style="--percent: {{ $activeClientsPercent }}; stroke-dasharray: 251.2; stroke-dashoffset: calc(251.2 - (251.2 * {{ $activeClientsPercent }}) / 100);" />
                                        </svg>
                                        <div class="radial-progress-text">{{ $activeClientsPercent }}%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row 2: 4 Cards (Sales, Revenue, New Clients, Active Subscriptions) -->
                
                <!-- Sales Sparkline Card -->
                <div class="col-sm-6 col-lg-3">
                    <div class="card inv-card">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-muted small fw-bold">المبيعات والأوردرات</span>
                                <span class="small text-muted">آخر 7 أيام</span>
                            </div>
                            <div class="d-flex align-items-baseline mb-2">
                                <span class="fs-2 fw-bold me-2">{{ number_format($salesCount7Days) }}</span>
                                @if($salesGrowth7Days >= 0)
                                    <span class="text-green small fw-bold d-inline-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" class="me-0.5"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8"/><path d="M14 7l7 0l0 7"/></svg>
                                        {{ number_format($salesGrowth7Days, 1) }}%
                                    </span>
                                @else
                                    <span class="text-danger small fw-bold d-inline-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" class="me-0.5"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7l6 6l4 -4l8 8"/><path d="M14 17l7 0l0 -7"/></svg>
                                        {{ number_format(abs($salesGrowth7Days), 1) }}%
                                    </span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1 small text-muted">
                                    <span>معدل التحويل</span>
                                    <span>{{ $conversionRate }}%</span>
                                </div>
                                <div class="progress progress-xs">
                                    <div class="progress-bar bg-blue" style="width: {{ $conversionRate }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revenue Sparkline Card -->
                <div class="col-sm-6 col-lg-3">
                    <div class="card inv-card">
                        <div class="card-body p-3 d-flex flex-column justify-content-between" style="min-height: 118px;">
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted small fw-bold">إجمالي الإيرادات</span>
                                    <span class="small text-muted">آخر 7 أيام</span>
                                </div>
                                <div class="d-flex align-items-baseline">
                                    <span class="fs-2 fw-bold me-2">{{ number_format($revenue7Days, 0) }} ج.م</span>
                                    @if($revenueGrowth7Days >= 0)
                                        <span class="text-green small fw-bold d-inline-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" class="me-0.5"><path d="M3 17l6 -6l4 4l8 -8"/><path d="M14 7l7 0l0 7"/></svg>
                                            {{ number_format($revenueGrowth7Days, 1) }}%
                                        </span>
                                    @else
                                        <span class="text-danger small fw-bold d-inline-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" class="me-0.5"><path d="M3 7l6 6l4 -4l8 8"/><path d="M14 17l7 0l0 -7"/></svg>
                                            {{ number_format(abs($revenueGrowth7Days), 1) }}%
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="sparkline-container mt-2">
                                <canvas id="revenueSparkline" height="42"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- New Clients Sparkline Card -->
                <div class="col-sm-6 col-lg-3">
                    <div class="card inv-card">
                        <div class="card-body p-3 d-flex flex-column justify-content-between" style="min-height: 118px;">
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted small fw-bold">العملاء الجدد</span>
                                    <span class="small text-muted">آخر 7 أيام</span>
                                </div>
                                <div class="d-flex align-items-baseline">
                                    <span class="fs-2 fw-bold me-2">{{ number_format($newClients7Days) }}</span>
                                    @if($newClientsGrowth7Days >= 0)
                                        <span class="text-green small fw-bold d-inline-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" class="me-0.5"><path d="M3 17l6 -6l4 4l8 -8"/><path d="M14 7l7 0l0 7"/></svg>
                                            {{ number_format($newClientsGrowth7Days, 1) }}%
                                        </span>
                                    @else
                                        <span class="text-danger small fw-bold d-inline-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" class="me-0.5"><path d="M3 7l6 6l4 -4l8 8"/><path d="M14 17l7 0l0 -7"/></svg>
                                            {{ number_format(abs($newClientsGrowth7Days), 1) }}%
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="sparkline-container mt-2">
                                <canvas id="newClientsSparkline" height="42"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Subscriptions Sparkline Card -->
                <div class="col-sm-6 col-lg-3">
                    <div class="card inv-card">
                        <div class="card-body p-3 d-flex flex-column justify-content-between" style="min-height: 118px;">
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted small fw-bold">طلبات الصيانة النشطة</span>
                                    <span class="small text-muted">قيد العمل</span>
                                </div>
                                <div class="d-flex align-items-baseline">
                                    <span class="fs-2 fw-bold me-2">{{ number_format($activeTasksCount) }}</span>
                                    @if($tasksGrowth7Days >= 0)
                                        <span class="text-green small fw-bold d-inline-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" class="me-0.5"><path d="M3 17l6 -6l4 4l8 -8"/><path d="M14 7l7 0l0 7"/></svg>
                                            {{ number_format($tasksGrowth7Days, 1) }}%
                                        </span>
                                    @else
                                        <span class="text-danger small fw-bold d-inline-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" class="me-0.5"><path d="M3 7l6 6l4 -4l8 8"/><path d="M14 17l7 0l0 -7"/></svg>
                                            {{ number_format(abs($tasksGrowth7Days), 1) }}%
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="sparkline-container mt-2">
                                <canvas id="tasksSparkline" height="42"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row 3: 4 Small Micro Info Cards -->
                
                <!-- Card 1: Sales Count -->
                <div class="col-sm-6 col-lg-3">
                    <div class="card stat-card-micro">
                        <div class="card-body d-flex align-items-center p-3" style="gap:1rem;">
                            <div class="inv-icon-wrapper bg-blue-lt">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="9" cy="19" r="2"/><circle cx="17" cy="19" r="2"/><path d="M17 17h-11v-14h-2"/><path d="M6 5l14 1l-1 7h-13"/></svg>
                            </div>
                            <div>
                                <div class="fw-bold fs-3 mb-0">{{ number_format($salesCount) }} أوردر مبيعات</div>
                                <div class="text-muted small">{{ $unpaidTasksCount }} صيانة بانتظار السداد</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Orders Count -->
                <div class="col-sm-6 col-lg-3">
                    <div class="card stat-card-micro">
                        <div class="card-body d-flex align-items-center p-3" style="gap:1rem;">
                            <div class="inv-icon-wrapper bg-green-lt">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 10h3v-3l-3.5 -3.5a6 6 0 0 1 8 8l6 6a2 2 0 0 1 -3 3l-6 -6a6 6 0 0 1 -8 -8l3.5 3.5"/></svg>
                            </div>
                            <div>
                                <div class="fw-bold fs-3 mb-0">{{ number_format($tasksCount) }} طلب صيانة</div>
                                <div class="text-muted small">{{ $completedTasksCount }} عمليات مكتملة وشحنات</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Shares Count -->
                <div class="col-sm-6 col-lg-3">
                    <div class="card stat-card-micro">
                        <div class="card-body d-flex align-items-center p-3" style="gap:1rem;">
                            <div class="inv-icon-wrapper bg-dark text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M21 12l-18 0"/><path d="M21 12l-6 -6"/><path d="M21 12l-6 6"/></svg>
                            </div>
                            <div>
                                <div class="fw-bold fs-3 mb-0">{{ number_format($purchasesCount) }} عمليات توريد</div>
                                <div class="text-muted small">دفعات الموردين: {{ $supplierPaymentsCount }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Likes Count -->
                <div class="col-sm-6 col-lg-3">
                    <div class="card stat-card-micro">
                        <div class="card-body d-flex align-items-center p-3" style="gap:1rem;">
                            <div class="inv-icon-wrapper bg-azure-lt">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 21a9 9 0 0 1 0 -18a9 9 0 0 1 0 18z"/><path d="M9 12l2 2l4 -4"/></svg>
                            </div>
                            <div>
                                <div class="fw-bold fs-3 mb-0">{{ number_format($productsCount) }} منتجات بالمخزن</div>
                                <div class="text-muted small text-danger fw-bold">{{ $lowStockCount }} أوشكت على النفاد</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row 4: Traffic Summary + Daily Earnings (side by side) -->
                <div class="col-lg-7 mb-3">
                    <div class="card inv-card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title fw-bold">حركة المعاملات والنشاط</h3>
                            <div class="text-muted small">مقارنة المبيعات والصيانة اليومية (آخر 15 يوماً)</div>
                        </div>
                        <div class="card-body">
                            <canvas id="trafficChart" height="260"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Daily Earnings Indicator (next to traffic chart) -->
                <div class="col-lg-5 mb-3">
                    <div class="card inv-card" style="max-height: 370px;">
                        <div class="card-body p-3 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <div class="text-muted small fw-bold mb-0.5">مؤشر الأرباح اليومي</div>
                                    <div class="d-flex align-items-center">
                                        <span class="fs-2 fw-bold me-2">{{ number_format($todayEarningSum, 2) }} ج.م</span>
                                        @if($earningDiffPercent >= 0)
                                            <span class="text-green small fw-bold d-flex align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" class="me-0.5"><path d="M3 17l6 -6l4 4l8 -8"/><path d="M14 7l7 0l0 7"/></svg>
                                                +{{ number_format($earningDiffPercent, 1) }}% مقارنة بيوم أمس
                                            </span>
                                        @else
                                            <span class="text-danger small fw-bold d-flex align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" class="me-0.5"><path d="M3 7l6 6l4 -4l8 8"/><path d="M14 17l7 0l0 -7"/></svg>
                                                {{ number_format($earningDiffPercent, 1) }}% مقارنة بيوم أمس
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-muted small">آخر 15 يوماً</div>
                            </div>
                            <div style="height: 150px;">
                                <canvas id="earningChart" style="width:100%; height:100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row 5: Storage & Dynamic Notifications Feed (Left) & Today Earning & Recent transactions (Right) -->
                
                <!-- Storage & Notifications (Left Column) -->
                <div class="col-lg-5">
                    <div class="space-y-4">
                        <!-- Storage usage card -->
                        <div class="card inv-card">
                            <div class="card-body p-3">
                                <h3 class="card-title fw-bold mb-2">استهلاك قاعدة البيانات والمساحة</h3>
                                <div class="d-flex justify-content-between align-items-baseline mb-2">
                                    <span class="fs-2 fw-bold" id="usedStorageText">مستخدم {{ number_format($usedMB, 0) }} ميجابايت</span>
                                    <span class="text-muted small">من إجمالي {{ number_format($totalMB / 1024, 0) }} جيجابايت</span>
                                </div>
                                
                                <div class="progress progress-md mb-3" style="height: 12px; border-radius: 6px;">
                                    <div class="progress-bar storage-bar-regular" style="width: {{ ($regularMB / $totalMB) * 100 }}%" title="المبيعات والمشتريات"></div>
                                    <div class="progress-bar storage-bar-system" style="width: {{ ($systemMB / $totalMB) * 100 }}%" title="أعضاء النظام والصيانة"></div>
                                    <div class="progress-bar storage-bar-shared" style="width: {{ ($sharedMB / $totalMB) * 100 }}%" title="المنتجات والموردين"></div>
                                    <div class="progress-bar storage-bar-free" style="width: {{ ($freeMB / $totalMB) * 100 }}%" title="سعة فارغة"></div>
                                </div>
                                
                                <div class="row g-2 small text-muted">
                                    <div class="col-6 d-flex align-items-center">
                                        <span class="badge storage-bar-regular me-2" style="width:10px; height:10px; padding:0;"></span>
                                        <span>الأوردرات والتوريد: {{ number_format($regularMB, 0) }} MB</span>
                                    </div>
                                    <div class="col-6 d-flex align-items-center">
                                        <span class="badge storage-bar-system me-2" style="width:10px; height:10px; padding:0;"></span>
                                        <span>النظام والصيانة: {{ number_format($systemMB, 0) }} MB</span>
                                    </div>
                                    <div class="col-6 d-flex align-items-center">
                                        <span class="badge storage-bar-shared me-2" style="width:10px; height:10px; padding:0;"></span>
                                        <span>المنتجات والشركاء: {{ number_format($sharedMB, 0) }} MB</span>
                                    </div>
                                    <div class="col-6 d-flex align-items-center">
                                        <span class="badge storage-bar-free me-2" style="width:10px; height:10px; padding:0;"></span>
                                        <span>مساحة فارغة: {{ number_format($freeMB, 0) }} MB</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Feed/Notifications card -->
                        <div class="card inv-card">
                            <div class="card-header">
                                <h3 class="card-title fw-bold">أحدث الأحداث والنشاطات</h3>
                            </div>
                            <div class="card-body">
                                <div class="feed-container">
                                    @foreach($activityFeed as $feed)
                                        <div class="feed-item">
                                            <div class="feed-icon {{ $feed['bg'] }}">
                                                @switch($feed['icon'])
                                                    @case('user-plus')
                                                        <i class="fa fa-user-plus text-primary"></i>
                                                        @break
                                                    @case('tool')
                                                        <i class="fa fa-wrench text-warning"></i>
                                                        @break
                                                    @case('shopping-cart')
                                                        <i class="fa fa-shopping-cart text-success"></i>
                                                        @break
                                                    @default
                                                        <i class="fa fa-rotate-left text-danger"></i>
                                                @endswitch
                                            </div>
                                            <div>
                                                <div class="fw-bold mb-0.5" style="font-size: 0.9rem;">{{ $feed['text'] }}</div>
                                                <span class="text-muted small">{{ $feed['time_diff'] }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions (Right Column) -->
                <div class="col-lg-7">
                    <div class="card inv-card h-100">
                        <div class="card-header">
                            <h3 class="card-title fw-bold">العمليات الأخيرة بالفروع</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-vcenter table-mobile-md card-table">
                                <thead>
                                    <tr>
                                        <th>العميل</th>
                                        <th>نوع العملية</th>
                                        <th>المبلغ</th>
                                        <th>التاريخ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentTransactions as $tx)
                                        <tr>
                                            <td data-label="العميل">
                                                <div class="d-flex align-items-center" style="gap:0.75rem;">
                                                    <div class="avatar-letter">
                                                        {{ mb_substr($tx['user'], 0, 1) }}
                                                    </div>
                                                    <span class="font-weight-medium">{{ $tx['user'] }}</span>
                                                </div>
                                            </td>
                                            <td data-label="نوع العملية">
                                                <span class="text-secondary">{{ $tx['operation'] }}</span>
                                            </td>
                                            <td data-label="المبلغ" class="text-primary fw-bold">
                                                {{ $tx['amount'] }}
                                            </td>
                                            <td data-label="التاريخ" class="text-muted small">
                                                {{ $tx['date'] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
            // Raw values from blade
            const totalUsersSparklineData = {!! json_encode($totalUsersSparkline) !!};
            const salesSparklineData = {!! json_encode($salesSparkline) !!};
            const revenueSparklineData = {!! json_encode($revenueSparkline) !!};
            const newClientsSparklineData = {!! json_encode($newClientsSparkline) !!};
            const tasksSparklineData = {!! json_encode($tasksSparkline) !!};
            
            const trafficLabels = {!! json_encode($trafficLabels) !!};
            const trafficOrdersData = {!! json_encode($trafficOrders->values()->all()) !!};
            const trafficTasksData = {!! json_encode($trafficTasks->values()->all()) !!};
            
            const earningsLabels = {!! json_encode($earningsLabels) !!};
            const earningsData = {!! json_encode($earningsSparkline) !!};

            let charts = {};

            function buildDashboardCharts() {
                const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                const gridColor = isDark ? 'rgba(255,255,255,.05)' : 'rgba(15,23,42,.06)';
                const textColor = isDark ? '#94a3b8' : '#64748b';

                // Destroy old charts if existing
                Object.values(charts).forEach(c => {
                    if (c && typeof c.destroy === 'function') c.destroy();
                });

                // Sparkline base configurations
                const makeSparklineOptions = (color) => ({
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false }, tooltip: { enabled: true } },
                    scales: {
                        x: { display: false },
                        y: { display: false }
                    },
                    elements: {
                        point: { radius: 0, hoverRadius: 4 },
                        line: { borderWidth: 2, tension: 0.4 }
                    }
                });

                // 1. Total Users Sparkline
                const ctx1 = document.getElementById('totalUsersSparkline').getContext('2d');
                charts.totalUsers = new Chart(ctx1, {
                    type: 'line',
                    data: {
                        labels: Array(totalUsersSparklineData.length).fill(''),
                        datasets: [{
                            data: totalUsersSparklineData,
                            borderColor: '#2563eb',
                            backgroundColor: 'transparent',
                            fill: false
                        }]
                    },
                    options: makeSparklineOptions('#2563eb')
                });

                // 2. Revenue Sparkline
                const ctx2 = document.getElementById('revenueSparkline').getContext('2d');
                charts.revenue = new Chart(ctx2, {
                    type: 'line',
                    data: {
                        labels: Array(revenueSparklineData.length).fill(''),
                        datasets: [{
                            data: revenueSparklineData,
                            borderColor: '#10b981',
                            backgroundColor: 'transparent',
                            fill: false
                        }]
                    },
                    options: makeSparklineOptions('#10b981')
                });

                // 3. New Clients Sparkline
                const ctx3 = document.getElementById('newClientsSparkline').getContext('2d');
                charts.newClients = new Chart(ctx3, {
                    type: 'line',
                    data: {
                        labels: Array(newClientsSparklineData.length).fill(''),
                        datasets: [{
                            data: newClientsSparklineData,
                            borderColor: '#06b6d4',
                            backgroundColor: 'transparent',
                            fill: false
                        }]
                    },
                    options: makeSparklineOptions('#06b6d4')
                });

                // 4. Tasks Sparkline (Bar format sparkline)
                const ctx4 = document.getElementById('tasksSparkline').getContext('2d');
                charts.tasks = new Chart(ctx4, {
                    type: 'bar',
                    data: {
                        labels: Array(tasksSparklineData.length).fill(''),
                        datasets: [{
                            data: tasksSparklineData,
                            backgroundColor: '#8b5cf6',
                            borderRadius: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false }, tooltip: { enabled: true } },
                        scales: { x: { display: false }, y: { display: false } }
                    }
                });

                // 5. Traffic Grouped Column Chart
                const ctxTraffic = document.getElementById('trafficChart').getContext('2d');
                charts.traffic = new Chart(ctxTraffic, {
                    type: 'bar',
                    data: {
                        labels: trafficLabels,
                        datasets: [
                            {
                                label: 'أوردرات مبيعات',
                                data: trafficOrdersData,
                                backgroundColor: '#2563eb',
                                borderRadius: 4,
                                barPercentage: 0.6,
                                categoryPercentage: 0.7
                            },
                            {
                                label: 'طلبات صيانة',
                                data: trafficTasksData,
                                backgroundColor: '#f59e0b',
                                borderRadius: 4,
                                barPercentage: 0.6,
                                categoryPercentage: 0.7
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { color: textColor, font: { family: 'Janna' } }
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { color: textColor, font: { family: 'Janna', size: 10 } }
                            },
                            y: {
                                grid: { color: gridColor },
                                ticks: { color: textColor, stepSize: 1 }
                            }
                        }
                    }
                });

                // 6. Earning Line chart with gradient fill
                const ctxEarning = document.getElementById('earningChart').getContext('2d');
                const earnGradient = ctxEarning.createLinearGradient(0, 0, 0, 140);
                earnGradient.addColorStop(0, 'rgba(37,99,235,0.22)');
                earnGradient.addColorStop(1, 'rgba(37,99,235,0.01)');

                charts.earning = new Chart(ctxEarning, {
                    type: 'line',
                    data: {
                        labels: earningsLabels,
                        datasets: [{
                            label: 'الأرباح اليومية',
                            data: earningsData,
                            borderColor: '#2563eb',
                            borderWidth: 2.5,
                            backgroundColor: earnGradient,
                            fill: true,
                            tension: 0.35,
                            pointBackgroundColor: '#2563eb',
                            pointBorderColor: isDark ? '#1e293b' : '#ffffff',
                            pointBorderWidth: 1.5,
                            pointRadius: 3,
                            pointHoverRadius: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { color: textColor, font: { family: 'Janna', size: 10 } }
                            },
                            y: {
                                grid: { color: gridColor },
                                ticks: { color: textColor }
                            }
                        }
                    }
                });
            }

            buildDashboardCharts();
            document.addEventListener('invanta:theme', buildDashboardCharts);
        })();
    </script>
@endpush
