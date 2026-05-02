@extends('admin.layouts.master')
@section('content')
    <div class="page-body">
        <div class="container-xl col-lg-10 mx-auto">

            {{-- بطاقة معلومات المهندس --}}
            <div class="card card-md mb-4 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="card-title mb-1">{{ $engineer->name }}</h2>
                        <div class="text-muted">كشف حساب عن شهر {{ now()->translatedFormat('F Y') }}</div>
                    </div>
                    <div class="text-end">
                        <div class="h2 text-success mb-0">
                            {{ number_format($monthlyTotal, 2) }} ج.م
                        </div>
                        <small class="text-muted">إجمالي العمولة</small>
                    </div>
                    <div class="text-end">
                        <div class="h2 text-primary mb-0">
                            {{ $engineer->salary }} ج.م
                        </div>
                        <small class="text-muted">المرتب</small>
                    </div>
                    <div class="text-end">
                        <div class="h2 text-success mb-0">
                            {{ ($engineer->salary + number_format($monthlyTotal, 2) ) }} ج.م
                        </div>
                        <small class="text-muted">اجمالي المستحق </small>
                    </div>
                </div>
            </div>

            {{-- جدول المهام --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">المهام</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>العميل</th>
                            <th>الحاله</th>
                            <th>قيمة العمولة</th>
                            <th>تاريخ الاستلام</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($monthlyTasks as $task)
                            <tr>
                                <td>{{ $task->id }}</td>
                                <td>{{ $task->client?->name ?? '—' }}</td>
                                <td>
                                    @if($task->status === 'new')
                                        <span class="badge bg-blue-lt">جديدة</span>
                                    @elseif($task->status === 'completed')
                                        <span class="badge bg-green-lt">مكتملة</span>
                                    @elseif($task->status === 'cancelled')
                                        <span class="badge bg-red-lt">ملغية</span>
                                    @endif
                                </td>
                                @if($task->status == 'cancelled')
                                    <td class="text-red fw-bold">
                                        {{ $task->commission_pound }} ج.م
                                    </td>
                                @else
                                    <td class="text-success fw-bold">
                                        {{  $task->commission_pound }} ج.م
                                    </td>
                                @endif

                                <td>{{ \Carbon\Carbon::parse($task->receipt_date)->format('Y-m-d') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">لا توجد مهام لهذا المهندس في هذا الشهر
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
