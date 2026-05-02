@extends('admin.layouts.master')
@section('content')
    <div class="page-body">
        <div class="container-xl">

            {{-- ====== بحث عن المورد ====== --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">بحث حساب المورد</h3>
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">اسم المورد</label>
                            <select name="supplier_id" class="form-select">
                                <option value="">-- اختر المورد --</option>
                                @foreach($suppliers as $supplier)
                                    <option
                                        value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
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
                            <button type="submit" class="btn btn-primary w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="20" height="20"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                     fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"/>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                                </svg>
                                بحث
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ====== جدول حسابات الموردين ====== --}}
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">كشف حساب الموردين</h3>
                </div>

                {{-- ====== ملخص الرصيد ====== --}}
                @if($purchase->count() > 0 && request('supplier_id'))
                    <div class="card-body bg-light">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>الرصيد الحالي للمورد:</h5>
                            </div>
                            <div class="col-md-6">
                                <h5 style="color: #dc3545; font-weight: bold;">
                                    {{ number_format($totalBalance ?? 0, 2) }}
                                </h5>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-vcenter table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم المورد</th>
                            <th>المبلغ الإجمالي</th>
                            <th>نوع الفاتورة</th>
                            <th>التاريخ</th>
                            <th>العمليات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($purchase as $index => $purchases)
                            <tr>
                                <td>{{ ($purchase->currentPage() - 1) * $purchase->perPage() + $loop->iteration }}</td>
                                <td>{{ $purchases->supplier->name ?? '-' }}</td>
                                <td>{{ number_format($purchases->total_price ?? 0, 2) }}</td>
                                <td>
                                    @switch($purchases->invoice_type)
                                        @case('paid')
                                            <span style="color: #28a745; font-weight: 600;">مدفوع</span>
                                            @break

                                        @case('unpaid')
                                            <span style="color: #dc3545; font-weight: 600;">آجل</span>
                                            @break

                                        @case('partial')
                                            <span style="color: #ffc107; font-weight: 600;">جزئياً</span>
                                            @break

                                        @default
                                            <span style="color: #6c757d; font-weight: 600;">غير محدد</span>
                                    @endswitch
                                </td>
                                <td>{{ $purchases->created_at->format('Y-m-d') }}</td>

                                <td>
                                    <a class="btn btn-icon btn-outline-success mx-1"
                                       href="{{ route('admin.purchases.show', $purchases->id) }}"
                                       title="عرض التفاصيل">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                             fill="none" stroke="currentColor" stroke-width="1.2"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M1.5 12s4-7.5 10.5-7.5S22.5 12 22.5 12s-4 7.5-10.5 7.5S1.5 12 1.5 12z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </a>
                                    <a class="btn btn-icon btn-outline-warning mx-1"
                                       href="{{ route('admin.supplier_transactions', ['supplier_id' => $purchases->supplier->id]) }}"
                                       title="كشف الحساب والأرصدة">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-report-money" width="22" height="22"
                                             viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" fill="none" stroke-linecap="round"
                                             stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"/>
                                            <path d="M9 3h6a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2v0a2 2 0 0 1 2 -2z"/>
                                            <path d="M12 12c-.5 0 -1 .5 -1 1v3c0 .5 .5 1 1 1s1 -.5 1 -1v-3c0 -.5 -.5 -1 -1 -1"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    لا توجد حركات للموردين
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- ====== زر تصفية الحساب ====== --}}
                @if($totalBalance > 0 && request('supplier_id'))
                    <div class="card-footer bg-light">
                        <button type="button"
                                class="btn btn-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#settlementModal"
                                data-supplier-id="{{ request('supplier_id') }}"
                                data-supplier-balance="{{ $totalBalance }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="20" height="20"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                 fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 11h6v10h-6z" />
                                <path d="M4 8h16M6 4h12" />
                            </svg>
                            تصفية الحساب
                        </button>
                    </div>
                @endif

                <div class="m-3">
                    {{ $purchase->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>

            {{-- ====== جدول سجل المدفوعات ====== --}}
            @if(request('supplier_id') && count($payments) > 0)
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">سجل المدفوعات السابقة</h3>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-vcenter table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>المبلغ المدفوع</th>
                                <th>تاريخ الدفع</th>
                                <th>طريقة الدفع</th>
                                <th>الملاحظات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($payments as $payment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="badge badge-success">{{ number_format($payment->amount_paid, 2) }}</span>
                                    </td>
                                    <td>{{ $payment->payment_date->format('Y-m-d') }}</td>
                                    <td>
                                        @switch($payment->payment_method)
                                            @case('cash')
                                                <span class="badge badge-primary">نقداً</span>
                                                @break
                                            @case('check')
                                                <span class="badge badge-info">شيك</span>
                                                @break
                                            @case('transfer')
                                                <span class="badge badge-warning">تحويل بنكي</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">{{ $payment->payment_method }}</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $payment->notes ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        لا توجد مدفوعات سابقة
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- ====== Modal تصفية الحساب ====== --}}
    <div class="modal fade" id="settlementModal" tabindex="-1" aria-labelledby="settlementModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.suppliers.settle') }}" id="settlementForm">
                @method('POST')
                @csrf
                <input type="hidden" name="supplier_id" id="supplier_id_input">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="settlementModalLabel">تصفية حساب المورد</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">الرصيد الحالي</label>
                            <div class="alert alert-info" role="alert">
                                <strong id="current_balance_display">0.00</strong>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">المبلغ المدفوع <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="amount_paid" id="amount_paid_input"
                                   class="form-control" placeholder="أدخل المبلغ المدفوع" required>
                            <small class="form-text text-danger d-none" id="error_message">
                                المبلغ لا يمكن أن يتجاوز الرصيد الحالي
                            </small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">طريقة الدفع <span class="text-danger">*</span></label>
                            <select name="payment_method" id="payment_method_input" class="form-select" required>
                                <option value="">-- اختر طريقة الدفع --</option>
                                <option value="cash">نقداً</option>
                                <option value="check">شيك</option>
                                <option value="transfer">تحويل بنكي</option>
                                <option value="other">أخرى</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ملاحظات</label>
                            <textarea name="notes" id="notes_input" class="form-control"
                                      placeholder="أكتب أي ملاحظات (اختيارية)" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary" id="submitSettlementBtn">
                            حفظ التصفية
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const modal = document.getElementById('settlementModal');
            const amountInput = document.getElementById('amount_paid_input');
            const balanceDisplay = document.getElementById('current_balance_display');
            const errorMessage = document.getElementById('error_message');
            const submitBtn = document.getElementById('submitSettlementBtn');
            const form = document.getElementById('settlementForm');
            let currentBalance = 0;

            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const supplierId = button.getAttribute('data-supplier-id');
                const supplierBalance = parseFloat(button.getAttribute('data-supplier-balance')) || 0;

                const input = document.getElementById('supplier_id_input');

                if (input && supplierId) {
                    input.value = supplierId;
                    currentBalance = supplierBalance;
                    balanceDisplay.textContent = supplierBalance.toFixed(2);
                    amountInput.value = '';
                    amountInput.max = supplierBalance;
                    errorMessage.classList.add('d-none');
                    console.log('تم تعيين supplier_id =', supplierId, 'الرصيد =', supplierBalance);
                } else {
                    console.error('فشل في تعيين supplier_id:', {input, supplierId});
                }
            });

            // التحقق من صحة المبلغ المدفوع
            amountInput.addEventListener('input', function () {
                const amount = parseFloat(this.value) || 0;

                if (amount > currentBalance) {
                    errorMessage.classList.remove('d-none');
                    submitBtn.disabled = true;
                } else if (amount <= 0) {
                    errorMessage.classList.add('d-none');
                    submitBtn.disabled = true;
                } else {
                    errorMessage.classList.add('d-none');
                    submitBtn.disabled = false;
                }
            });

            // منع إرسال النموذج إذا كان المبلغ غير صحيح
            form.addEventListener('submit', function (e) {
                const amount = parseFloat(amountInput.value) || 0;
                if (amount <= 0 || amount > currentBalance) {
                    e.preventDefault();
                    alert('الرجاء إدخال مبلغ صحيح');
                }
            });

            // كل ما يقفل الـ Modal
            modal.addEventListener('hidden.bs.modal', function () {
                const formElement = this.querySelector('form');
                const inputElement = document.getElementById('supplier_id_input');
                const paymentMethodInput = document.getElementById('payment_method_input');
                const notesInput = document.getElementById('notes_input');

                if (formElement) formElement.reset();
                if (inputElement) inputElement.value = '';
                if (paymentMethodInput) paymentMethodInput.value = '';
                if (notesInput) notesInput.value = '';

                amountInput.value = '';
                submitBtn.disabled = true;
            });
        });
    </script>
@endpush
