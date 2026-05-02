@extends('admin.layouts.master')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="card">

            <div class="card-header">
                <h2 class="card-title">إضافة مرتجع جديد</h2>
            </div>

            <div class="card-body">

                {{-- Alerts --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.invoice_return.store') }}" method="POST">
                    @csrf

                    {{-- النوع + العميل/المورد --}}
                    <div class="row g-2 mb-3">

                        <div class="col-md-4">
                            <label class="form-label">نوع المرتجع</label>
                            <select id="returnType" name="type" class="form-select" required>
                                <option value="">اختر النوع</option>
                                <option value="client">مرتجع عميل</option>
                                <option value="supplier">مرتجع مورد</option>
                            </select>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">العميل / المورد</label>
                            <select id="typeIdSelect" name="type_id" class="form-select" required>
                                <option value="">اختر أولاً</option>
                            </select>
                        </div>

                    </div>

                    {{-- المنتجات --}}
                    <div class="row g-2 align-items-end mb-3">

                        <div class="col-md-4">
                            <label class="form-label">نوع المنتجات</label>
                            <select id="productType" class="form-select">
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
                                إضافة
                            </button>
                        </div>

                    </div>

                    {{-- الجدول --}}
                    <div class="table-responsive mb-3">
                        <table class="table text-center" id="returnDetailsTable">
                            <thead class="table-light">
                            <tr>
                                <th>المنتج</th>
                                <th>المتاح</th>
                                <th>الكمية</th>
                                <th>السعر</th>
                                <th>الإجمالي</th>
                                <th>حذف</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    {{-- الإجمالي --}}
                    <div class="card bg-light p-3 mb-3">
                        <div class="text-end">
                            <label class="form-label">الإجمالي</label>
                            <input type="text" id="totalPrice"
                                   name="total_price"
                                   class="form-control text-end fw-bold"
                                   readonly value="0.00">
                        </div>
                    </div>

                    {{-- ملاحظات --}}
                    <div class="mb-3">
                        <label class="form-label">ملاحظات</label>
                        <textarea name="notes" class="form-control"></textarea>
                    </div>

                    <div class="text-end">
                        <button class="btn btn-success">حفظ</button>
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

    const tableBody = document.querySelector('#returnDetailsTable tbody');
    const totalPriceInput = document.getElementById('totalPrice');
    const addBtn = document.getElementById('addProduct');

    const productSelect = document.getElementById('productSelect');
    const productTypeSelect = document.getElementById('productType');

    let currentReturnType = null;

    const clients = @json($clients->map(fn($c)=>['id'=>$c->id,'name'=>$c->name.' - '.$c->phone]));
    const suppliers = @json($suppliers->map(fn($s)=>['id'=>$s->id,'name'=>$s->name]));

    /* ================= TomSelect ================= */

    const returnType = new TomSelect("#returnType", {
        onChange: function(value){
            currentReturnType = value;
            fillType(value);
        }
    });

    const typeSelect = new TomSelect("#typeIdSelect", {
        valueField:'id',
        labelField:'name',
        searchField:'name'
    });

    const productTom = new TomSelect(productSelect, {
        valueField:'value',
        labelField:'text',
        searchField:'text'
    });


    /* ================= Fill Clients/Suppliers ================= */

    function fillType(type){
        typeSelect.clearOptions();

        const list = type === 'client' ? clients : suppliers;

        list.forEach(item=>{
            typeSelect.addOption(item);
        });

        typeSelect.refreshOptions(false);
    }


    /* ================= Load Products ================= */

    productTypeSelect.addEventListener('change', function(){

        const type = this.value;

        productTom.clear();
        productTom.clearOptions();
        productTom.disable();

        if(!type) return;

        fetch(`{{ route('admin.invoice_return.create') }}?type=${type}`,{
            headers:{'X-Requested-With':'XMLHttpRequest'}
        })
        .then(res=>res.json())
        .then(data=>{

            data.forEach(p=>{
                productTom.addOption({
                    value: p.id,
                    text: p.name,
                    sale_price: p.sale_price || 0,
                    purchase_price: p.purchase_price || 0,
                    stock: p.quantity || 0
                });
            });

            productTom.enable();
            productTom.refreshOptions(false);
        });
    });


    /* ================= Add Product ================= */

    addBtn.addEventListener('click', function(){

        if(!currentReturnType) return alert('اختر نوع المرتجع');

        const id = productTom.getValue();
        if(!id) return;

        const selected = productTom.options[id];

        const priceValue = currentReturnType === 'client'
            ? selected.sale_price
            : selected.purchase_price;

        const price = parseFloat(priceValue).toFixed(2);
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


    /* ================= Total ================= */

    function updateTotal(){
        let total = 0;

        document.querySelectorAll('.lineTotal').forEach(el=>{
            total += parseFloat(el.textContent) || 0;
        });

        totalPriceInput.value = total.toFixed(2);
    }

});
</script>

@endpush
