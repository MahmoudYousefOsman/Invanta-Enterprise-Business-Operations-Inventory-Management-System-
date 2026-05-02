@extends('admin.layouts.master')
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="card-title mb-0">إضافة مشتريات جديدة</h2>
                </div>
                <div class="card-body">
                    {{-- أخطاء الفاليديشن --}}
                    @if ($errors->any())
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="purchaseForm" action="{{ route('admin.purchases.store') }}" method="POST">
                        @csrf

                        {{-- المورد + نوع الفاتورة + المبلغ المدفوع + التاريخ --}}
                        <div class="row g-2 mb-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">المورد</label>
                                <select name="supplier_id" class="form-select" required>
                                    <option value="">-- اختر المورد --</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" @selected(old('supplier_id') == $supplier->id)>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">تاريخ الفاتورة</label>
                                <input type="date" name="date" class="form-control"
                                       value="{{ old('date', date('Y-m-d')) }}" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">نوع فاتورة المشتريات</label>
                                <select name="invoice_type" id="paymentType" class="form-select" required>
                                    <option value="">-- اختر نوع الفاتورة --</option>
                                    <option value="paid" @selected(old('invoice_type') == 'paid')>مدفوع</option>
                                    <option value="partial" @selected(old('invoice_type') == 'partial')>مدفوع جزئياً</option>
                                    <option value="unpaid" @selected(old('invoice_type') == 'unpaid')>آجل</option>
                                </select>
                            </div>

                            <div class="col-md-3" id="partialAmountDiv" style="display:none;">
                                <label class="form-label">المبلغ المدفوع</label>
                                <input type="number" name="paid_amount" id="paidAmount" class="form-control"
                                       value="{{ old('paid_amount', 0) }}" min="0" step="0.01" placeholder="ادخل المبلغ المدفوع">
                            </div>
                        </div>

                        {{-- ملاحظات --}}
                        <div class="mb-3">
                            <label class="form-label">ملاحظات</label>
                            <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                        </div>

                        {{-- اختيار نوع المنتج + المنتج --}}
                        <div class="row g-2 align-items-end mb-3">
                            <div class="col-md-4">
                                <label class="form-label">نوع المنتجات</label>
                                <select id="productType" class="form-select" required>
                                    <option value="">-- اختر نوع المنتجات --</option>
                                    <option value="phone">منتجات بيع</option>
                                    <option value="fix">منتجات صيانة</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">اختر المنتج</label>
                                <select id="productSelect" class="form-select" disabled>
                                    <option value="">-- اختر نوع المنتجات أولاً --</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <button type="button" id="addProduct" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="18" height="18"
                                         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                         fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                    إضافة منتج
                                </button>
                            </div>
                        </div>

                        {{-- جدول التفاصيل --}}
                        <div class="table-responsive mb-3">
                            <table class="table card-table table-vcenter text-center" id="purchaseDetailsTable">
                                <thead class="table-light">
                                <tr>
                                    <th>المنتج</th>
                                    <th>المتاح</th>
                                    <th>الكمية المطلوبة </th>
                                    <th>سعر الشراء</th>
                                    <th>الإجمالي</th>
                                    <th>حذف</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        {{-- الخصم والإجمالي والمتبقي --}}
                        <div class="card card-sm bg-light mb-3 p-3">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <label class="form-label">الخصم</label>
                                    <input type="number" id="discount" name="discount" class="form-control"
                                           value="{{ old('discount', 0) }}" min="0" step="0.01">
                                </div>

                                <div class="col-md-4 text-end">
                                    <label class="form-label">الإجمالي الكلي</label>
                                    <input type="text" id="totalPrice" name="total_price"
                                           class="form-control text-end fw-bold"
                                           value="{{ old('total_price', '0.00') }}" readonly>
                                </div>

                                <div class="col-md-4 text-end" id="remainingDiv" style="display:none;">
                                    <label class="form-label">المبلغ المتبقي</label>
                                    <input type="text" id="remainingAmount" name="remaining_amount"
                                           class="form-control text-end fw-bold"
                                           value="0.00" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success">
                                <i class="ti ti-device-floppy"></i> حفظ
                            </button>
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
        document.addEventListener("DOMContentLoaded", function () {

            const tableBody = document.querySelector('#purchaseDetailsTable tbody');
            const productSelect = document.getElementById('productSelect');
            const addBtn = document.getElementById('addProduct');
            const discountInput = document.getElementById('discount');
            const totalPriceInput = document.getElementById('totalPrice');

            const paymentTypeSelect = document.getElementById('paymentType');
            const paidAmountInput = document.getElementById('paidAmount');
            const partialDiv = document.getElementById('partialAmountDiv');
            const remainingDiv = document.getElementById('remainingDiv');
            const remainingAmount = document.getElementById('remainingAmount');
            const productTypeSelect = document.getElementById('productType');

            let productTomSelect;



            /* =====================================================
               ✅ TomSelect - اختيار المنتجات
            ===================================================== */
            productTomSelect = new TomSelect(productSelect, {
                placeholder: '-- اختر المنتج --',
                searchField: ['text'],
                valueField: 'value',
                labelField: 'text',
                maxItems: 1,
                closeAfterSelect: false,
                openOnFocus: true
            });



            /* =====================================================
               ✅ تحميل المنتجات حسب النوع
            ===================================================== */
            productTypeSelect.addEventListener('change', function(){

                const type = this.value;

                productTomSelect.clear();
                productTomSelect.clearOptions();
                productTomSelect.disable();

                if(!type) return;

                fetch(`{{ route('admin.purchases.create') }}?type=${type}`,{
                    headers:{'X-Requested-With':'XMLHttpRequest'}
                })
                    .then(res=>res.json())
                    .then(data=>{

                        data.forEach(p=>{
                            productTomSelect.addOption({
                                value: p.id,
                                text: p.name,
                                price: p.purchase_price || 0,
                                stock: p.quantity || 0
                            });
                        });

                        productTomSelect.enable();
                        productTomSelect.refreshOptions(false);
                    })
                    .catch(()=>alert('حدث خطأ أثناء تحميل المنتجات'));
            });



            /* =====================================================
               ✅ إضافة المنتج للجدول
            ===================================================== */
            addBtn.addEventListener('click', function(){

                const id = productTomSelect.getValue();
                if(!id) return;

                const selected = productTomSelect.options[id];

                const price = parseFloat(selected.price || 0).toFixed(2);
                const stock = selected.stock ?? 0;


                /* لو موجود زود كمية */
                const existing = tableBody.querySelector(
                    `[name="products[${id}][quantity]"]`
                );

                if(existing){
                    existing.value = parseInt(existing.value) + 1;
                    existing.dispatchEvent(new Event('input'));
                    return;
                }


                const tr = document.createElement('tr');

                tr.innerHTML = `
            <td>${selected.text}
                <input type="hidden" name="products[${id}][id]" value="${id}">
            </td>

            <td>${stock}</td>

            <td>
                <input type="number"
                       name="products[${id}][quantity]"
                       value="1"
                       min="1"
                       class="form-control quantity text-center">
            </td>

            <td>
                <input type="text"
                       name="products[${id}][price]"
                       value="${price}"
                       readonly
                       class="form-control price text-center">
            </td>

            <td class="lineTotal fw-bold">${price}</td>

            <td>
                <button type="button" class="btn btn-danger btn-sm removeRow">X</button>
            </td>
        `;

                tableBody.appendChild(tr);


                tr.querySelector('.quantity').addEventListener('input', function(){
                    const qty = parseFloat(this.value)||0;
                    tr.querySelector('.lineTotal').textContent = (qty*price).toFixed(2);
                    updateTotal();
                });

                tr.querySelector('.removeRow').onclick = ()=>{
                    tr.remove();
                    updateTotal();
                };

                updateTotal();
            });



            /* =====================================================
               ✅ الحسابات (زي ما كانت)
            ===================================================== */
            discountInput.addEventListener('input', updateTotal);
            paymentTypeSelect.addEventListener('change', updateRemaining);
            paidAmountInput.addEventListener('input', updateRemaining);


            function updateTotal(){
                let subtotal = 0;

                document.querySelectorAll('.lineTotal').forEach(el=>{
                    subtotal += parseFloat(el.textContent)||0;
                });

                let total = subtotal - (parseFloat(discountInput.value)||0);
                if(total < 0) total = 0;

                totalPriceInput.value = total.toFixed(2);

                updateRemaining();
            }


            function updateRemaining(){
                const total = parseFloat(totalPriceInput.value)||0;
                const paid = parseFloat(paidAmountInput.value)||0;

                if(paymentTypeSelect.value === 'partial'){
                    partialDiv.style.display = 'block';
                    remainingDiv.style.display = 'block';

                    let remaining = total - paid;
                    if(remaining < 0) remaining = 0;

                    remainingAmount.value = remaining.toFixed(2);
                }else{
                    partialDiv.style.display = 'none';
                    remainingDiv.style.display = 'none';
                    remainingAmount.value = 0;
                    paidAmountInput.value = 0;
                }
            }

        });
    </script>

@endpush

