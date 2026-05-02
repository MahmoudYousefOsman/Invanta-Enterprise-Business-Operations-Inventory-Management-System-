@extends('admin.layouts.master')
@section('content')
    <div class="page-header d-print-none">
        <div class="col-lg-11 mx-lg-auto">
            <div class="row g-2 align-items-center">
                <div class="col d-flex align-items-center">
                    <!-- أيقونة إحصاءات -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="28" height="28" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M3 12h6v8h-6z"/>
                        <path d="M9 8h6v12h-6z"/>
                        <path d="M15 4h6v16h-6z"/>
                    </svg>
                    <h2 class="page-title mb-0">الإحصاءات</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="col-lg-11 mx-lg-auto">
            <div class="row row-deck row-cards">

                <!-- إجمالي العملاء -->
                <div class="col-sm-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="h1 mb-0 me-2">إجمالي العملاء</div>
                            <div class="d-flex align-items-center">
                                <div class="h1 mb-0 me-2">{{ $allClients }}
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="url(#grad1)">
                                        <defs>
                                            <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
                                                <stop offset="0%" style="stop-color:#ff6b6b;stop-opacity:1" />
                                                <stop offset="100%" style="stop-color:#fbc531;stop-opacity:1" />
                                            </linearGradient>
                                        </defs>
                                        <path d="M12 2a5 5 0 0 1 5 5v3h-10V7a5 5 0 0 1 5-5z"/>
                                        <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/>
                                    </svg>
                                </div>
                                <div class="ms-auto">
                                   <svg width="100" height="100" viewBox="0 0 36 36">
                                        <circle cx="18" cy="18" r="16" fill="#f0f0f0"/>
                                        <circle cx="18" cy="18" r="16" fill="none" stroke="#ff6b6b" stroke-width="4"
                                                stroke-dasharray="80, 100" stroke-linecap="round"/>
                                        <text x="18" y="22" text-anchor="middle" font-size="8" fill="#ff6b6b">80%</text>
                                    </svg>
                                </div>
                            </div>
                            <div class="text-muted">العدد الكلي للعملاء</div>
                        </div>
                    </div>
                </div>

                <!-- إجمالي الطلبات (آخر شهر) -->
                <div class="col-sm-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="h1 mb-0 me-2">إجمالي الاوردات</div>
                            <div class="d-flex align-items-center">
                                <div class="h1 mb-0 me-2">{{ $ordersLastMonth }}
                                   <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-2" width="28" height="28"
                                         viewBox="0 0 24 24" stroke-width="2" stroke="#28a745" fill="none"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M3 12l6 -6l6 6"/>
                                        <path d="M9 6v12"/>
                                    </svg>
                                </div>
                                <div class="ms-auto">
                                   <svg width="100" height="80" viewBox="0 0 60 40">
                                        <rect x="5" y="15" width="8" height="25" fill="#ff6b6b"/>
                                        <rect x="20" y="5" width="8" height="35" fill="#6bc1ff"/>
                                        <rect x="35" y="10" width="8" height="30" fill="#ffd93d"/>
                                        <rect x="50" y="20" width="8" height="20" fill="#4cd137"/>
                                    </svg>
                                </div>
                            </div>
                            <div class=" text-muted">اجمالي عدد الاوردرات</div>
                        </div>
                    </div>
                </div>

                <!-- إجمالي طلبات الصيانة (آخر شهر) -->
                <div class="col-sm-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="h1 mb-0 me-2">إجمالي طلبات الصيانة</div>
                            <div class="d-flex align-items-center">
                                <div class="h1 mb-0 me-2">{{ $tasksLastMonth }}
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                                        <path d="M3 12l6-6 6 6 6-6" stroke="#ff6b6b" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </div>
                                <div class="ms-auto">
                                    <svg width="100" height="80" viewBox="0 0 60 40">
                                        <polyline points="0,30 15,20 30,25 45,10 60,15"
                                                  fill="none" stroke="#6bc1ff" stroke-width="2"/>
                                        <circle cx="15" cy="20" r="3" fill="#ff6b6b"/>
                                        <circle cx="30" cy="25" r="3" fill="#ffd93d"/>
                                        <circle cx="45" cy="10" r="3" fill="#4cd137"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="text-muted">اجمالي عدد طلبات الصيانه</div>
                        </div>
                    </div>
                </div>

                <!-- العملاء الذين لديهم طلبات -->
                <div class="col-sm-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="h1 mb-0 me-2">عملاء الطلبات</div>
                            <div class="d-flex align-items-center">
                                <div class="h1 mb-0 me-2">{{ $clientsWithOrders }}
                                     <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-2" width="28" height="28"
                                         viewBox="0 0 24 24" stroke-width="2" stroke="#28a745" fill="none"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M3 12l6 -6l6 6"/>
                                        <path d="M9 6v12"/>
                                    </svg>
                                </div>
                                <div class="ms-auto">
                                    <svg width="100" height="80" viewBox="0 0 60 40">
                                        <rect x="5" y="20" width="8" height="15" fill="#206bc4"/>
                                        <rect x="20" y="10" width="8" height="25" fill="#206bc4"/>
                                        <rect x="35" y="5" width="8" height="30" fill="#206bc4"/>
                                        <rect x="50" y="15" width="8" height="20" fill="#206bc4"/>
                                    </svg>
                                </div>
                            </div>
                            <div class=" text-muted">عدد العملاء الشراء</div>
                        </div>
                    </div>
                </div>

                <!-- العملاء الذين لديهم صيانة -->
                <div class="col-sm-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="h1 mb-0 me-2">عملاء الصيانة</div>
                            <div class="d-flex align-items-center">
                                <div class="h1 mb-0 me-2">{{ $clientsWithTasks }}
                                       <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-2" width="28" height="28"
                                         viewBox="0 0 24 24" stroke-width="2" stroke="#28a745" fill="none"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M3 12l6 -6l6 6"/>
                                        <path d="M9 6v12"/>
                                    </svg>
                                </div>
                                <div class="ms-auto">
                                    <svg width="80" height="80" viewBox="0 0 36 36">
                                        <circle cx="18" cy="18" r="15.9155" fill="transparent"
                                                stroke="#e6e6e6" stroke-width="3"/>
                                        <circle cx="18" cy="18" r="15.9155" fill="transparent"
                                                stroke="#206bc4" stroke-width="3"
                                                stroke-dasharray="60, 100" stroke-linecap="round"/>
                                        <circle cx="18" cy="18" r="10" fill="white"/>
                                    </svg>
                                </div>
                            </div>
                            <div class=" text-muted">عدد العملاء الصيانه</div>

                        </div>

                    </div>

                </div>
                <!-- الرسم البياني للأوردرات -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title d-flex align-items-center">
                                    <!-- SVG أيقونة -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="#4f46e5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M4 19l4 -6l4 2l4 -5l4 6" />
                                        <path d="M3 3v18h18" />
                                    </svg>
                                    الأوردرات خلال آخر شهر
                                </h3>
                                <canvas id="ordersChart" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('ordersChart').getContext('2d');

            // 🎨 نعمل Gradient من فوق لتحت
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(32, 107, 196, 0.9)');
            gradient.addColorStop(1, 'rgba(32, 107, 196, 0.2)');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($ordersPerDay->keys()) !!},
                    datasets: [{
                        label: 'عدد الأوردرات',
                        data: {!! json_encode($ordersPerDay->values()) !!},
                        backgroundColor: gradient,
                        borderColor: '#206bc4',
                        borderWidth: 1,
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {display: false}
                    },
                    scales: {
                        x: {
                            ticks: {color: '#6c757d'}
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {stepSize: 1, color: '#6c757d'}
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection
