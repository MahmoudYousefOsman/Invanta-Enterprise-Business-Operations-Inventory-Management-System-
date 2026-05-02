@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="col-10 mx-auto">
        <h3 class="mb-4 mt-4">📊 التقرير العام</h3>

        {{-- بطاقة الفلتر --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.general.report') }}">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label class="form-label">من تاريخ</label>
                            <input type="date"
                                   name="from_date"
                                   class="form-control"
                                   value="{{ request('from_date') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">إلى تاريخ</label>
                            <input type="date"
                                   name="to_date"
                                   class="form-control"
                                   value="{{ request('to_date') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                🔍 بحث
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- البطاقات الرئيسية --}}
        <div class="row row-cards mb-4">
            {{-- المهام --}}
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-center">
                            <span class="bg-blue text-white avatar avatar-lg me-3">
                                📋
                            </span>
                            <div>
                                <div class="text-muted fs-5">عدد المهام</div>
                                <div class="h1 mb-0 fw-bold">
                                    {{ number_format($tasksTotal ?? 0) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- الطلبات --}}
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-center">
                            <span class="bg-green text-white avatar avatar-lg me-3">
                                🛒
                            </span>
                            <div>
                                <div class="text-muted fs-5">عدد الطلبات</div>
                                <div class="h1 mb-0 fw-bold">
                                    {{ number_format($ordersTotal ?? 0) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- المشتريات --}}
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-center">
                            <span class="bg-orange text-white avatar avatar-lg me-3">
                                📦
                            </span>
                            <div>
                                <div class="text-muted fs-5">عدد المشتريات</div>
                                <div class="h1 mb-0 fw-bold">
                                    {{ number_format($purchasesTotal ?? 0) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- المرتجعات --}}
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-center">
                            <span class="bg-red text-white avatar avatar-lg me-3">
                                🔄
                            </span>
                            <div>
                                <div class="text-muted fs-5">عدد المرتجعات</div>
                                <div class="h1 mb-0 fw-bold">
                                    {{ number_format($returnsTotal ?? 0) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- بطاقة صافي الربح --}}
        <div class="row mb-5">
            <div class="col-12 col-lg-6 mx-auto">
                <div class="card shadow-lg border-0">
                    <div class="card-body text-center py-5">
                        <span class="bg-purple text-white avatar avatar-xxl mb-3">
                            📈
                        </span>
                        <h4 class="text-muted mt-3">صافي الربح</h4>
                        <h1 class="display-4 fw-bold
                            {{ ($profit ?? 0) >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ number_format($profit ?? 0, 2) }}
                        </h1>
                        <small class="text-muted">
                            المبيعات - (المشتريات + المرتجعات)
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
