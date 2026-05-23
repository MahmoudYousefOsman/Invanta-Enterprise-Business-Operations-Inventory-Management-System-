@extends('admin.layouts.master')
@section('content')
    <div class="page-header d-print-none">
        <div class="col-lg-11 mx-lg-auto">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">نظرة عامة</div>
                    <h2 class="page-title">لوحة الإحصاءات</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="col-lg-11 mx-lg-auto">
            <div class="row row-deck row-cards">

                @php
                    $cards = [
                        ['label' => 'إجمالي العملاء',        'sub' => 'العدد الكلي للعملاء',        'value' => $allClients,        'grad' => 'inv-grad-blue',    'icon' => 'users'],
                        ['label' => 'إجمالي الأوردرات',      'sub' => 'خلال آخر شهر',              'value' => $ordersLastMonth,   'grad' => 'inv-grad-violet',  'icon' => 'cart'],
                        ['label' => 'طلبات الصيانة',         'sub' => 'خلال آخر شهر',              'value' => $tasksLastMonth,    'grad' => 'inv-grad-amber',   'icon' => 'tool'],
                        ['label' => 'عملاء الأوردرات',       'sub' => 'عملاء قاموا بالشراء',       'value' => $clientsWithOrders, 'grad' => 'inv-grad-teal',    'icon' => 'bag'],
                        ['label' => 'عملاء الصيانة',         'sub' => 'عملاء لديهم صيانة',         'value' => $clientsWithTasks,  'grad' => 'inv-grad-rose',    'icon' => 'wrench'],
                    ];
                @endphp

                @foreach($cards as $c)
                    <div class="col-sm-6 col-lg-4">
                        <div class="card inv-stat inv-lift h-100">
                            <div class="card-body d-flex align-items-center" style="gap:1rem;">
                                <div class="inv-stat-icon {{ $c['grad'] }}">
                                    @switch($c['icon'])
                                        @case('users')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/><path d="M3 21v-2a4 4 0 0 1 4 -4h4"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/><path d="M21 21v-2a4 4 0 0 0 -3 -3.85"/></svg>
                                            @break
                                        @case('cart')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="9" cy="19" r="2"/><circle cx="17" cy="19" r="2"/><path d="M17 17h-11v-14h-2"/><path d="M6 5l14 1l-1 7h-13"/></svg>
                                            @break
                                        @case('tool')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 10h3v-3l-3.5 -3.5a6 6 0 0 1 8 8l6 6a2 2 0 0 1 -3 3l-6 -6a6 6 0 0 1 -8 -8l3.5 3.5"/></svg>
                                            @break
                                        @case('bag')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6.331 8h11.339a2 2 0 0 1 1.977 2.304l-1.255 8.152a3 3 0 0 1 -2.966 2.544h-6.86a3 3 0 0 1 -2.966 -2.544l-1.255 -8.152a2 2 0 0 1 1.977 -2.304z"/><path d="M9 11v-5a3 3 0 0 1 6 0v5"/></svg>
                                            @break
                                        @default
                                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 10h3v-3l-3.5 -3.5a6 6 0 0 1 8 8l6 6a2 2 0 0 1 -3 3l-6 -6a6 6 0 0 1 -8 -8l3.5 3.5"/></svg>
                                    @endswitch
                                </div>
                                <div>
                                    <div class="inv-stat-value">{{ $c['value'] }}</div>
                                    <div class="inv-stat-label">{{ $c['label'] }}</div>
                                    <div class="text-muted small">{{ $c['sub'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Orders chart --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title d-flex align-items-center" style="gap:.5rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" stroke-width="2" stroke="var(--inv-brand-500)" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 19l4 -6l4 2l4 -5l4 6"/><path d="M3 3v18h18"/></svg>
                                الأوردرات خلال آخر شهر
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="ordersChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            (function () {
                const ctx = document.getElementById('ordersChart').getContext('2d');
                let chart;

                function buildChart() {
                    const dark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                    const grid = dark ? 'rgba(255,255,255,.06)' : 'rgba(15,23,42,.07)';
                    const tick = dark ? '#94a3b8' : '#64748b';

                    const gradient = ctx.createLinearGradient(0, 0, 0, 360);
                    gradient.addColorStop(0, 'rgba(37, 99, 235, 0.9)');
                    gradient.addColorStop(1, 'rgba(37, 99, 235, 0.15)');

                    if (chart) chart.destroy();
                    chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: {!! json_encode($ordersPerDay->keys()) !!},
                            datasets: [{
                                label: 'عدد الأوردرات',
                                data: {!! json_encode($ordersPerDay->values()) !!},
                                backgroundColor: gradient,
                                borderColor: '#2563eb',
                                borderWidth: 1,
                                borderRadius: 8,
                                maxBarThickness: 38
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: { legend: { display: false } },
                            scales: {
                                x: { grid: { color: grid }, ticks: { color: tick } },
                                y: { beginAtZero: true, grid: { color: grid }, ticks: { stepSize: 1, color: tick } }
                            }
                        }
                    });
                }

                buildChart();
                document.addEventListener('invanta:theme', buildChart);
            })();
        </script>
    @endpush
@endsection
