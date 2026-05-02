@extends('admin.layouts.master')
@section('content')
    <div class="page-body">
        <div class="container-xl col-lg-10 mx-auto">
            <h2 class="mb-4">تفاصيل المهمة</h2>
            <form  method="POST" action="{{ route('admin.engineer.task.updateStatus', $task) }}">
                @csrf
                {{-- معلومات أساسية --}}
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="card-title">المعلومات الأساسية</h3>
                        <p><strong>العميل:</strong> {{ $task->client?->name }}</p>
                        <p><strong>الجهاز:</strong> {{ $task->device_type }}</p>
                        <p><strong>الرقم التسلسلي:</strong> {{ $task->serial_number }}</p>
                        <p><strong>الوصف:</strong> {{ $task->description }}</p>
                        <p><strong>تاريخ الاستلام:</strong> {{ $task->receipt_date }}</p>
                        <p><strong>تاريخ التسليم:</strong> {{ $task->due_date ?? '—' }}</p>
                        <p><strong>قيمة العمولة:</strong>
                            <span id="commissionValue">{{ $task->commission_pound }} ج.م</span>
                        </p>

                        {{-- تغيير حالة المهمة --}}
                        <div class="mb-3">
                            <label for="status" class="form-label">حالة المهمة</label>
                            <select name="newStatus" id="status" class="form-select">
                                <option value="new" {{ $task->status == 'new' ? 'selected' : '' }}>جديدة</option>
                                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>مكتملة
                                </option>
                                <option value="cancelled" {{ $task->status == 'cancelled' ? 'selected' : '' }}>ملغية
                                </option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" @disabled($task->status == 'cancelled')>
                            تحديث الحالة
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

