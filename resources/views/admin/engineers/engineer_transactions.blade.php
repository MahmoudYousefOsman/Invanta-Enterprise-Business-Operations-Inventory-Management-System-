@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">

            {{-- ====== بحث ====== --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">بحث عن حركات المهندس</h3>
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">اسم المهندس</label>
                            <select name="engineer_id" class="form-select">
                                <option value="">-- اختر المهندس --</option>
                                @foreach($engineers as $engineer)
                                    <option value="{{ $engineer->id }}" {{ request('engineer_id') == $engineer->id ? 'selected' : '' }}>
                                        {{ $engineer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">من تاريخ</label>
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">إلى تاريخ</label>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-30">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="20" height="20"
                                         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                         fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8" />
                                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                    </svg>
                                    بحث
                                </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ====== جدول الصيانة ====== --}}
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">الصيانة</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter table-striped">
                        <thead>
                        <tr>
                            <th>المهندس</th>
                            <th>العميل</th>
                            <th>التكلفه</th>
                            <th>العموله</th>
                            <th>الحالة</th>
                            <th>تاريخ الإستلام</th>
                            <th>موعد التسليم</th>
                            <th>عرض</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($tasks as $task)
                            <tr>
                                <td>{{ $task->engineer->name ?? '-' }}</td>
                                <td>{{ $task->client->name ?? '-' }}</td>
                                <td>{{ $task->cost }}</td>
                                <td>{{$task->commission ?? '-'}}</td>

                                <td> @if($task->status === 'new')
                                        <span class="badge bg-blue-lt">جديد</span>
                                    @elseif($task->status === 'completed')
                                        <span class="badge bg-green-lt">مكتمل</span>
                                    @elseif($task->status === 'cancelled')
                                        <span class="badge bg-red-lt">ملغي</span>
                                    @else
                                        <span class="badge bg-secondary-lt">غير معروف</span>
                                    @endif
                                </td>
                                <td>{{ $task->receipt_date ?? '-'}}</td>
                                <td>{{ $task->due_date ?? '-' }}</td>
                                <td>
                                    <a class="btn btn-icon btn-outline-success mx-1" href="{{ route('admin.task.show', $task->id) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                                             stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24" role="img" aria-labelledby="showTitle2">
                                            <title id="showTitle2">Show</title>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M1.5 12s4-7.5 10.5-7.5S22.5 12 22.5 12s-4 7.5-10.5 7.5S1.5 12 1.5 12z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">لا توجد صيانة</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="m-3">
                    {{ $tasks->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
