@extends('admin.layouts.master')
@section('title', 'تفاصيل المهمة')

@php
    $taskStatus = [
        'new'       => ['class' => 'unpaid',  'text' => 'جديدة'],
        'completed' => ['class' => 'paid',    'text' => 'مكتملة'],
        'cancelled' => ['class' => 'partial', 'text' => 'ملغاة'],
    ];
    $ts = $taskStatus[$task->status] ?? ['class' => 'partial', 'text' => ucfirst($task->status)];
@endphp

@section('content')
    <div class="page-header d-print-none">
        <div class="col-lg-10 mx-auto">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">طلبات الصيانة</div>
                    <h2 class="page-title">تفاصيل المهمة #{{ $task->id }}
                        <span class="inv-status {{ $ts['class'] }} ms-2">{{ $ts['text'] }}</span>
                    </h2>
                </div>
                <div class="col-auto ms-auto d-flex" style="gap:.5rem;">
                    <a href="{{ route('admin.task.index') }}" class="btn btn-outline-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6 -6"/></svg>
                        رجوع
                    </a>
                    <a href="{{ route('admin.task.print', $task->id) }}" target="_blank" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"/><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"/><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"/></svg>
                        طباعة الإيصال
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="col-lg-10 mx-auto">

            {{-- تفاصيل المهمة --}}
            <div class="card mb-4">
                <div class="card-header"><h3 class="card-title">تفاصيل المهمة</h3></div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <dl class="row mb-0">
                                <dt class="col-5 text-muted fw-normal">العميل</dt>
                                <dd class="col-7 fw-semibold">{{ $task->client?->name }}</dd>
                                <dt class="col-5 text-muted fw-normal">المهندس</dt>
                                <dd class="col-7 fw-semibold">{{ $task->engineer?->name }}</dd>
                                <dt class="col-5 text-muted fw-normal">تاريخ الاستلام</dt>
                                <dd class="col-7">{{ $task->receipt_date }}</dd>
                                <dt class="col-5 text-muted fw-normal">تاريخ التسليم</dt>
                                <dd class="col-7">{{ $task->due_date ?? '---' }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="row mb-0">
                                <dt class="col-5 text-muted fw-normal">نوع الجهاز</dt>
                                <dd class="col-7 fw-semibold">{{ $task->device_type }}</dd>
                                <dt class="col-5 text-muted fw-normal">الرقم التسلسلي</dt>
                                <dd class="col-7">{{ $task->serial_number ?? '---' }}</dd>
                                <dt class="col-5 text-muted fw-normal">الوصف</dt>
                                <dd class="col-7">{{ $task->description }}</dd>
                                <dt class="col-5 text-muted fw-normal">ملاحظات</dt>
                                <dd class="col-7">{{ $task->notes ?? '---' }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between text-muted small">
                    <span>بواسطة: <strong>{{ $task->admin?->name ?? 'المدير' }}</strong></span>
                    <span>📆 {{ $task->created_at->diffForHumans() }}</span>
                </div>
            </div>

            {{-- تفاصيل الدفع --}}
            <div class="row row-cards mb-4">
                <div class="col-md-4">
                    <div class="card inv-stat h-100">
                        <div class="card-body d-flex align-items-center" style="gap:1rem;">
                            <div class="inv-stat-icon inv-grad-blue">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3l0 18"/><path d="M17 8a4 4 0 0 0 -4 -4h-2a3.5 3.5 0 0 0 0 7h2a3.5 3.5 0 0 1 0 7h-2a4 4 0 0 1 -4 -4"/></svg>
                            </div>
                            <div>
                                <div class="inv-stat-value">{{ number_format($task->cost) }}</div>
                                <div class="inv-stat-label">التكلفة</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card inv-stat h-100">
                        <div class="card-body d-flex align-items-center" style="gap:1rem;">
                            <div class="inv-stat-icon inv-grad-emerald">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10"/></svg>
                            </div>
                            <div>
                                <div class="inv-stat-value">{{ number_format($task->payed) }}</div>
                                <div class="inv-stat-label">المدفوع</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card inv-stat h-100">
                        <div class="card-body d-flex align-items-center" style="gap:1rem;">
                            <div class="inv-stat-icon inv-grad-rose">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/></svg>
                            </div>
                            <div>
                                <div class="inv-stat-value">{{ number_format($task->cost - $task->payed) }}</div>
                                <div class="inv-stat-label">المتبقي</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- المنتجات المستخدمة --}}
            <div class="card mb-4">
                <div class="card-header"><h3 class="card-title">المنتجات المستخدمة في المهمة</h3></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                            <tr>
                                <th>الصنف</th>
                                <th class="text-center" style="width:20%">الكمية</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($task->products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td class="text-center">{{ $product->pivot->quantity }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted py-4">لا يوجد منتجات مرتبطة بهذه المهمة</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
