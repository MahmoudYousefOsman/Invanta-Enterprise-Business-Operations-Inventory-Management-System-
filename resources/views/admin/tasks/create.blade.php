@extends('admin.layouts.master')
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-11 mx-auto">
                    <form action="{{ route('admin.task.store') }}" method="POST">
                        @csrf
                        {{-- بيانات الطلب --}}
                        <div class="card">
                            <div class="card-header">
                                <h3>إضافة طلب صيانه جديد</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    {{-- العميل --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">العميل</label>
                                        <select name="client_id" class="form-select" required>
                                            <option value="">اختر العميل</option>
                                            @foreach($clients as $client)
                                                <option value="{{ $client->id }}"
                                                        @if(old('client_id') == $client->id || session('client_id') == $client->id) selected @endif>
                                                    {{ $client->name .' - '. $client->phone }}
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
                                                <option value="{{ $engineer->id }}">{{ $engineer->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('engineer_id')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- نوع الجهاز --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">نوع الجهاز</label>
                                        <input type="text" name="device_type" class="form-control" required>
                                        @error('device_type')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- الرقم التسلسلي --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">الرقم التسلسلي للجهاز</label>
                                        <input type="text" name="serial_number" class="form-control">
                                        @error('serial_number')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- الوصف --}}
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">الوصف</label>
                                        <textarea name="description" class="form-control" rows="3" required></textarea>
                                        @error('description')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- ملاحظات --}}
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">ملاحظات</label>
                                        <textarea name="notes" class="form-control" rows="2"></textarea>
                                        @error('notes')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- الحالة --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">الحالة</label>
                                        <select name="status" class="form-select">
                                            <option value="new">جديدة</option>
                                            <option value="completed">مكتملة</option>
                                            <option value="cancelled">ملغاة</option>
                                        </select>
                                        @error('status')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- التكلفة --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">التكلفة</label>
                                        <input type="number" step="0.01" id="cost" name="cost" class="form-control" required>
                                        @error('cost')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- المدفوع --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">المدفوع</label>
                                        <input type="number" step="0.01" id="payed" name="payed" class="form-control">
                                        <div id="payedError" class="text-danger small d-none">المبلغ المدفوع لا يجب أن يكون أكبر من التكلفة الإجمالية</div>
                                        @error('payed')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- المتبقي --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">المتبقي</label>
                                        <input type="number" step="0.01" id="remaining" class="form-control" readonly>
                                    </div>

                                    {{-- العمولة --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">العمولة (%)</label>
                                        <input type="number" step="0.01" name="commission" id="commission" class="form-control" placeholder="اكتب النسبة المئوية مثلاً 15">
                                        @error('commission')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- تاريخ الاستلام --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">تاريخ الاستلام</label>
                                        <input type="date" name="receipt_date" class="form-control" value="{{ old('receipt_date', now()->format('Y-m-d')) }}" required>
                                        @error('receipt_date')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- تاريخ التسليم --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">تاريخ التسليم</label>
                                        <input type="date" name="due_date" class="form-control">
                                        @error('due_date')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- الأصناف المستخدمة --}}
                        <div class="card mt-4">
                            <div class="card-body">
                                <h3 class="card-title">الأصناف المستخدمة</h3>

                                {{-- إضافة صنف --}}
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <select id="productSelect" class="form-select">
                                            <option value="" disabled selected>اختر الصنف</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}"
                                                        data-name="{{ $product->name }}"
                                                        data-code="{{ $product->code ?? '' }}"
                                                        data-stock="{{ $product->quantity }}">
                                                    {{ $product->name }} ({{ $product->code ?? '' }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" id="quantityInput" class="form-control" placeholder="الكمية" min="1" value="1">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" id="addProductBtn" class="btn btn-success">إضافة</button>
                                    </div>
                                </div>

                                {{-- جدول الأصناف --}}
                                <table class="table" id="itemsTable">
                                    <thead>
                                    <tr>
                                        <th>الصنف</th>
                                        <th>الكمية</th>
                                        <th>إجراء</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="empty-row">
                                        <td colspan="3" class="text-center text-muted">لم يتم إضافة أصناف بعد</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mt-3 text-end card-footer">
                            <button type="submit" class="btn btn-primary">حفظ + طباعه الايصال</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <script>
        // Initialize Tom Select
        const productTS = new TomSelect('#productSelect', {
            placeholder: "اختر الصنف",
            allowEmptyOption: true,
            searchField: ['text','data-code'], // search by name & code
            render: {
                option: function(item, escape) {
                    const code = item.$option?.dataset?.code || '';
                    return `<div>${escape(item.text)} <small class="text-muted">(${escape(code)})</small></div>`;
                }
            }
        });

        // حساب المتبقي والتحقق من الصحة
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

        // إضافة الأصناف
        const addBtn = document.getElementById('addProductBtn');
        const productSelectEl = document.getElementById('productSelect');
        const qtyInput = document.getElementById('quantityInput');
        const tableBody = document.querySelector('#itemsTable tbody');
        const form = document.querySelector('form');

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

        addBtn.addEventListener('click', function () {
            const productId = productSelectEl.value;
            const selectedOption = productSelectEl.options[productSelectEl.selectedIndex];
            const productName = selectedOption?.dataset.name;
            const productCode = selectedOption?.dataset.code;
            const productStock = parseInt(selectedOption?.dataset.stock);
            const qty = parseInt(qtyInput.value);

            if (!productId || qty <= 0) {
                Swal.fire('تنبيه', 'اختر الصنف وأدخل كمية صحيحة', 'warning');
                return;
            }

            if (qty > productStock) {
                Swal.fire('خطأ', `الكمية المتاحة من ${productName} هي ${productStock}`, 'error');
                return;
            }

            if (tableBody.querySelector(`input[name="products[${productId}][item_id]"]`)) {
                Swal.fire('تنبيه', 'تم إضافة هذا الصنف مسبقًا', 'info');
                return;
            }

            const emptyRow = tableBody.querySelector('.empty-row');
            if (emptyRow) emptyRow.remove();

            const row = document.createElement('tr');
            row.innerHTML = `
            <td>
                <input type="hidden" name="products[${productId}][item_id]" value="${productId}">
                <input type="hidden" name="products[${productId}][quantity]" value="${qty}">
                ${productName} (${productCode})
            </td>
            <td>${qty}</td>
            <td>
                <button type="button" class="btn btn-sm btn-danger removeRowBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                    </svg>
                </button>
            </td>
        `;
            tableBody.appendChild(row);

            // Remove from select
            productTS.removeOption(productId);

            // Reset select and quantity
            productTS.clear();
            qtyInput.value = 1;
        });

        // حذف صنف
        document.addEventListener('click', function (e) {
            if (e.target.closest('.removeRowBtn')) {
                const row = e.target.closest('tr');
                const productId = row.querySelector('input[name^="products"]').value;
                const productName = row.querySelector('td').textContent.trim().split('(')[0];

                // Add back to select
                const option = document.createElement('option');
                option.value = productId;
                option.text = productName;
                productTS.addOption(option);

                row.remove();

                if (!tableBody.querySelector('tr')) {
                    tableBody.innerHTML = `<tr class="empty-row"><td colspan="3" class="text-center text-muted">لم يتم إضافة أصناف بعد</td></tr>`;
                }
            }
        });
    </script>
@endpush
