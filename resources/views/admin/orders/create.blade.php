@extends('admin.layouts.master')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="card">

            <div class="card-header">
                <h2 class="card-title">إضافة أوردر جديد</h2>
            </div>

            <div class="card-body">

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger mb-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="orderForm" action="{{ route('admin.orders.store') }}" method="POST">
                    @csrf

                    {{-- العميل + التاريخ --}}
                    <div class="row g-2 mb-3 align-items-end">
                        <div class="col-md-6">
                            <label class="form-label">العميل</label>
                            <select name="client_id" class="form-select">
                                <option value="">اختر العميل</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}"
                                        @selected(old('client_id') == $client->id)>
                                        {{ $client->name }} - {{ $client->phone }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">التاريخ</label>
                            <input type="date" name="order_date"
                                   class="form-control"
                                   value="{{ old('order_date', date('Y-m-d')) }}">
                        </div>
                    </div>

                    {{-- ملاحظات --}}
                    <div class="mb-3">
                        <label class="form-label">ملاحظات</label>
                        <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                    </div>

                    {{-- اختيار المنتجات --}}
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
                                <option value="">-- اختر النوع أولاً --</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button type="button" id="addProduct" class="btn btn-primary">
                                + إضافة
                            </button>
                        </div>
                    </div>

                    {{-- جدول --}}
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered text-center" id="orderDetailsTable">
                            <thead class="table-light">
                            <tr>
                                <th>المنتج</th>
                                <th>المتاح</th>
                                <th>الكمية</th>
                                <th>سعر البيع</th>
                                <th>الإجمالي</th>
                                <th>حذف</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    {{-- الحسابات --}}
                    <div class="card bg-light p-3 mb-3">
                        <div class="row align-items-center">

                            <div class="col-md-4">
                                <label class="form-label">الخصم</label>
                                <input type="number" id="discount" name="discount"
                                       class="form-control"
                                       value="0" min="0">
                            </div>

                            <div class="col-md-4 text-end">
                                <label class="form-label">الإجمالي</label>
                                <input type="text" id="totalPrice"
                                       name="total_price"
                                       class="form-control text-end fw-bold"
                                       readonly>
                            </div>

                        </div>
                    </div>

                    <div class="text-end">
                        <button class="btn btn-success">
                            حفظ
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

    const tableBody = document.querySelector('#orderDetailsTable tbody');
    const productSelect = document.getElementById('productSelect');
    const productTypeSelect = document.getElementById('productType');
    const addBtn = document.getElementById('addProduct');
    const discountInput = document.getElementById('discount');
    const totalPriceInput = document.getElementById('totalPrice');

    let productTomSelect;


    /* =========================
       TomSelect
    ========================= */
    productTomSelect = new TomSelect(productSelect, {
        placeholder: '-- اختر المنتج --',
        searchField: ['text'],
        valueField: 'value',
        labelField: 'text',
        maxItems: 1
    });


    /* =========================
       تحميل المنتجات
    ========================= */
    productTypeSelect.addEventListener('change', function(){

        const type = this.value;

        productTomSelect.clear();
        productTomSelect.clearOptions();
        productTomSelect.disable();

        if(!type) return;

        fetch(`{{ route('admin.orders.create') }}?type=${type}`,{
            headers:{'X-Requested-With':'XMLHttpRequest'}
        })
        .then(res=>res.json())
        .then(data=>{

            data.forEach(p=>{
                productTomSelect.addOption({
                    value: p.id,
                    text: p.name,
                    price: p.sale_price || 0,
                    stock: p.quantity || 0
                });
            });

            productTomSelect.enable();
            productTomSelect.refreshOptions(false);
        })
        .catch(()=>alert('خطأ في تحميل المنتجات'));
    });


    /* =========================
       إضافة المنتج
    ========================= */
    addBtn.addEventListener('click', function(){

        const id = productTomSelect.getValue();
        if(!id) return;

        const selected = productTomSelect.options[id];

        const price = parseFloat(selected.price || 0).toFixed(2);
        const stock = selected.stock ?? 0;

        const existing = tableBody.querySelector(`[name="products[${id}][quantity]"]`);

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
                       class="form-control text-center">
            </td>

            <td class="lineTotal fw-bold">${price}</td>

            <td>
                <button type="button" class="btn btn-danger btn-sm removeRow">X</button>
            </td>
        `;

        tableBody.appendChild(tr);


        tr.querySelector('.quantity').addEventListener('input', function(){
            const qty = parseFloat(this.value)||0;
            tr.querySelector('.lineTotal').textContent = (qty * price).toFixed(2);
            updateTotal();
        });

        tr.querySelector('.removeRow').onclick = ()=>{
            tr.remove();
            updateTotal();
        };

        updateTotal();
    });


    /* =========================
       الحسابات
    ========================= */
    discountInput.addEventListener('input', updateTotal);

    function updateTotal(){

        let subtotal = 0;

        document.querySelectorAll('.lineTotal').forEach(el=>{
            subtotal += parseFloat(el.textContent)||0;
        });

        let total = subtotal - (parseFloat(discountInput.value)||0);

        if(total < 0) total = 0;

        totalPriceInput.value = total.toFixed(2);
    }

});
</script>

@endpush
