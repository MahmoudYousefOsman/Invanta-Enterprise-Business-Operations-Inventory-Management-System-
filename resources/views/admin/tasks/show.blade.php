@extends('admin.layouts.master')

@section('title', 'تفاصيل المهمة')

@section('content')
    <div class="page-body">
        <div class="col-lg-10 mx-auto">
            {{-- 📌 تفاصيل المهمة --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h3 class="mb-0">تفاصيل المهمة</h3>
                </div>
                <div class="card-body row g-3">
                    <div class="col-md-6">
                        <p><strong class="text-dark">👤 العميل:</strong> <span class="text-primary">{{ $task->client?->name }}</span></p>
                        <p><strong class="text-dark">🛠️ المهندس:</strong> <span class="text-info">{{ $task->engineer?->name }}</span></p>
                        <p><strong class="text-dark">📌 الحالة:</strong>
                            <span class="badge bg-{{ $task->status == 'new' ? 'blue' : ($task->status == 'pending' ? 'green' : 'red') }}-lt">
                            {{ ucfirst($task->status) }}
                        </span>
                        </p>
                        <p><strong class="text-dark">📅 تاريخ الاستلام:</strong> <span class="text-warning">{{ $task->receipt_date }}</span></p>
                        <p><strong class="text-dark">📅 تاريخ التسليم:</strong> <span class="text-success">{{ $task->due_date }}</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong class="text-dark">💻 نوع الجهاز:</strong> <span class="text-secondary">{{ $task->device_type }}</span></p>
                        <p><strong class="text-dark">🔢 الرقم التسلسلي:</strong> <span class="text-danger">{{ $task->serial_number }}</span></p>
                        <p><strong class="text-dark">📝 الوصف:</strong> <span class="text-muted">{{ $task->description }}</span></p>
                        <p><strong class="text-dark">🗒️ ملاحظات:</strong> <span class="text-muted">{{ $task->notes }}</span></p>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between text-muted small">
                    <span>بواسطة: <strong>{{ $task->admin?->name ?? 'المدير' }}</strong></span>
                    <span>📆 {{ $task->created_at->diffForHumans() }}</span>
                </div>
            </div>

            {{-- 📌 تفاصيل التكلفة --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h3 class="mb-0">تفاصيل الدفع</h3>
                </div>
                <div class="card-body row text-center">
                    <div class="col-md-4">
                        <h5 class="text-dark">💰 التكلفة</h5>
                        <p class="text-primary fs-5">{{ number_format($task->cost) }} ج.م</p>
                    </div>
                    <div class="col-md-4">
                        <h5 class="text-dark">💵 المدفوع</h5>
                        <p class="text-success fs-5">{{ number_format($task->payed) }} ج.م</p>
                    </div>
                    <div class="col-md-4">
                        <h5 class="text-dark">📉 المتبقي</h5>
                        <p class="text-danger fs-5">{{ number_format($task->cost - $task->payed) }} ج.م</p>
                    </div>
                </div>
            </div>

            {{-- 📌 المنتجات المرتبطة --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h3 class="mb-0">المنتجات المستخدمة في المهمة</h3>
                </div>
                <div class="card-body">
                    @if($task->products->count() > 0)
                        <div class="table-responsive">
                            <table class="table" id="itemsTable">
                                <thead>
                                <tr>
                                    <th>الصنف</th>
                                    <th>الكمية</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($task->products as $product)
                                    <tr>
                                        <td>
                                            {{ $product->name }}
                                        </td>
                                        <td>{{ $product->pivot->quantity }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">لا يوجد منتجات مرتبطة بهذه المهمة
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">لا يوجد منتجات مرتبطة بهذه المهمة</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
