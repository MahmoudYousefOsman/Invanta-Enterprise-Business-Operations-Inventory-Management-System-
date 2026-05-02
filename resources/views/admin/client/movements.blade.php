@extends('admin.layouts.master')
@section('content')
    <div class="page-body">
        <div class="container-xl">

            {{-- ====== بحث ====== --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">بحث عن حركات عميل</h3>
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">اسم العميل</label>
                            <select name="client_id" class="form-select">
                                <option value="">-- اختر العميل --</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">نوع الحركة</label>
                            <select name="type" class="form-select">
                                <option value="">الكل</option>
                                <option value="order" {{ request('type')=='order'?'selected':'' }}>أوردر</option>
                                <option value="repair" {{ request('type')=='repair'?'selected':'' }}>صيانة</option>
                            </select>
                        </div>

                        <div class="col-md-4 d-flex align-items-end">
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

            {{-- ====== جدول الأوردرات ====== --}}
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">الأوردرات</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter table-striped">
                        <thead>
                        <tr>
                            <th>العميل</th>
                            <th>القيمة</th>
                            <th>التاريخ</th>
                            <th>عرض</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->client->name ?? '-' }}</td>
                                <td>{{ $order->total_price }}</td>
                                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a class="btn btn-icon btn-outline-success mx-1" href="{{ route('admin.orders.show', $order->id) }}">
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
                                <td colspan="4" class="text-center text-muted">لا توجد أوردرات</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="m-3">
                    {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
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
                            <th>العميل</th>
                            <th>القيمة</th>
                            <th>التاريخ</th>
                            <th>عرض</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($tasks as $task)
                            <tr>
                                <td>{{ $task->client->name ?? '-' }}</td>
                                <td>{{ $task->cost }}</td>
                                <td>{{ $task->created_at->format('Y-m-d') }}</td>
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
                                <td colspan="4" class="text-center text-muted">لا توجد صيانة</td>
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
