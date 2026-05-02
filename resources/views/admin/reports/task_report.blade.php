@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="col-11 mx-auto">
        <h3 class="mb-4 mt-4">📦 تقرير الصيانة</h3>

        <form method="GET" class="row mb-4" action="{{ route('admin.task.report') }}">
            <div class="col-md-3">
                <label class="form-label">المهندس</label>
                <select name="engineer_id" class="form-control">
                    <option value="">كل المهندسين</option>
                    @foreach($engineers as $engineer)
                        <option value="{{ $engineer->id }}"
                            {{ request('engineer_id') == $engineer->id ? 'selected' : '' }}>
                            {{ $engineer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">من تاريخ</label>
                <input type="date" name="from_date" class="form-control"
                       value="{{ request('from_date') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">إلى تاريخ</label>
                <input type="date" name="to_date" class="form-control"
                       value="{{ request('to_date') }}">
            </div>

            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">بحث</button>
            </div>
        </form>

        {{-- الإجماليات --}}
        <div class="row row-cards mb-3">
            <div class="col-md-6">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <span class="bg-success text-white avatar me-3">
                                💰
                            </span>
                            <div>
                                <div class="font-weight-medium">إجمالي المبيعات</div>
                                <div class="text-muted fs-3 fw-bold">
                                    {{ number_format($totalSales, 2) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <span class="bg-primary text-white avatar me-3">
                                📈
                            </span>
                            <div>
                                <div class="font-weight-medium">إجمالي الربح</div>
                                <div class="text-muted fs-3 fw-bold">
                                    {{ number_format($profit, 2) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- الجدول --}}
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>المهندس</th>
                                <th>التاريخ</th>
                                <th>التكلفة / الإجمالي</th>
                                <th>الربح</th>
                                <th>عرض</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tasks as $task)
                                <tr>
                                    <td class="text-muted">{{ $loop->iteration }}</td>
                                    <td>{{ $task->engineer->name ?? 'غير محدد' }}</td>
                                    <td>{{ $task->created_at->format('Y-m-d') }}</td>
                                    <td class="text-success fw-bold">
                                        {{ number_format($task->cost, 2) }}
                                    </td>
                                    <td class="fw-bold text-primary">
                                        {{ number_format($task->profit, 2) }}
                                    </td>
                                    <td>
                                        <a class="btn btn-icon btn-outline-success mx-1"
                                           href="{{ route('admin.task.show', $task->id) }}"
                                           title="عرض التفاصيل">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="none" stroke="currentColor" stroke-width="1.2"
                                                 viewBox="0 0 24 24" role="img">
                                                <title>عرض</title>
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M1.5 12s4-7.5 10.5-7.5S22.5 12 22.5 12s-4 7.5-10.5 7.5S1.5 12 1.5 12z"/>
                                                <circle cx="12" cy="12" r="3"/>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        لا توجد بيانات
                                    </td>
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
