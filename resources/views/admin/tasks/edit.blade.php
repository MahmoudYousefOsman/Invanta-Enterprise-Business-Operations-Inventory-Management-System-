@extends('admin.layouts.master')
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3>تعديل طلب الصيانه</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.task.update', $task->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- العميل --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">العميل</label>
                                <select name="client_id" class="form-select" required>
                                    <option value="">اختر العميل</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}"
                                            {{ old('client_id', $task->client_id) == $client->id ? 'selected' : '' }}>
                                            {{ $client->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- المهندس --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">المهندس</label>
                                <select name="engineer_id" class="form-select" required>
                                    <option value="">اختر المهندس</option>
                                    @foreach($engineers as $engineer)
                                        <option value="{{ $engineer->id }}"
                                            {{ old('engineer_id', $task->engineer_id) == $engineer->id ? 'selected' : '' }}>
                                            {{ $engineer->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('engineer_id')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- نوع الجهاز --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">نوع الجهاز</label>
                                <input type="text" name="device_type" class="form-control"
                                       value="{{ old('device_type', $task->device_type) }}" required>
                                @error('device_type')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- الرقم التسلسلي --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">الرقم التسلسلي</label>
                                <input type="text" name="serial_number" class="form-control"
                                       value="{{ old('serial_number', $task->serial_number) }}" required>
                                @error('serial_number')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- الوصف --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">الوصف</label>
                                <textarea name="description" class="form-control" rows="3"
                                          required>{{ old('description', $task->description) }}</textarea>
                                @error('description')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- ملاحظات --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">ملاحظات</label>
                                <textarea name="notes" class="form-control"
                                          rows="2">{{ old('notes', $task->notes) }}</textarea>
                                @error('notes')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- الحالة --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">الحالة</label>
                                <select name="status" class="form-select">
                                    <option value="new" {{ old('status', $task->status) == 'new' ? 'selected' : '' }}>
                                        جديدة
                                    </option>
                                    <option
                                        value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>
                                        مكتملة
                                    </option>
                                    <option
                                        value="cancelled" {{ old('status', $task->status) == 'cancelled' ? 'selected' : '' }}>
                                        ملغاة
                                    </option>
                                </select>
                                @error('status')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- التكلفة --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">التكلفة</label>
                                <input type="number" step="0.01" id="cost" name="cost"
                                       value="{{ old('cost', $task->cost) }}" class="form-control" required>
                                @error('cost')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- المدفوع --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">المدفوع</label>
                                <input type="number" step="0.01" id="payed" name="payed"
                                       value="{{ old('payed', $task->payed) }}" class="form-control">
                                <div id="payedError" class="text-danger small d-none">المبلغ المدفوع لا يجب أن يكون أكبر من التكلفة الإجمالية</div>
                                @error('payed')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- المتبقي --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">المتبقي</label>
                                <input type="number" step="0.01" id="remaining" class="form-control"
                                       value="{{ $task->cost - $task->payed }}" readonly>
                            </div>

                            {{-- تاريخ الاستلام --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">تاريخ الاستلام</label>
                                <input type="date" name="receipt_date" class="form-control"
                                       value="{{ old('receipt_date', $task->receipt_date) }}" required>
                                @error('receipt_date')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- تاريخ التسليم --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">تاريخ التسليم</label>
                                <input type="date" name="due_date" class="form-control"
                                       value="{{ old('due_date', $task->due_date) }}">
                                @error('due_date')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3 text-end">
                            <button type="submit" class="btn btn-primary">تحديث المهمة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const form = document.querySelector('form');

        function calculateRemaining() {
            let cost = parseFloat(document.getElementById('cost').value) || 0;
            let payed = parseFloat(document.getElementById('payed').value) || 0;
            let remaining = cost - payed;
            document.getElementById('remaining').value = remaining.toFixed(2);

            // التحقق من أن المدفوع لا يتجاوز التكلفة
            const payedError = document.getElementById('payedError');
            if (payed > cost && payed !== 0) {
                payedError.classList.remove('d-none');
            } else {
                payedError.classList.add('d-none');
            }
        }

        document.getElementById('cost').addEventListener('input', calculateRemaining);
        document.getElementById('payed').addEventListener('input', calculateRemaining);

        // التحقق قبل الحفظ
        form.addEventListener('submit', function (e) {
            let cost = parseFloat(document.getElementById('cost').value) || 0;
            let payed = parseFloat(document.getElementById('payed').value) || 0;

            if (payed > cost && payed !== 0) {
                e.preventDefault();
                Swal.fire('خطأ', 'المبلغ المدفوع لا يجب أن يكون أكبر من التكلفة الإجمالية', 'error');
                return false;
            }
        });
    </script>
@endpush
