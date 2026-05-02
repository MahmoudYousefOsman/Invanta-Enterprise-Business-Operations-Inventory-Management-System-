@extends('admin.layouts.master')
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="card-title mb-0">إضافة منتجات للمورد </h2>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="purchaseForm" action="{{ route('admin.store.supplier.products') }}" method="POST">
                        @csrf

                        <div class="row g-2 mb-3 align-items-end">
                            <div class="col-md-6">
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
                        </div>
                        {{-- اختيار المنتجات --}}
                        <div class="row g-2 align-items-end mb-3">
                            <div class="col-md-6">
                                <label class="form-label">المنتجات</label>
                                <select id="productSelect" multiple class="form-select">
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-stock="{{ $product->stock }}">
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" id="addProduct" class="btn btn-primary w-100">
                                    إضافة المنتجات
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive mb-3">
                            <table class="table card-table table-vcenter text-center" id="purchaseDetailsTable">
                                <thead class="table-light">
                                <tr>
                                    <th>المنتج</th>
                                    <th>الكمية</th>
                                    <th>حذف</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
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
        document.addEventListener('DOMContentLoaded', function () {

            // ✅ تفعيل TomSelect لاختيار منتجات متعددة
            const productSelect = new TomSelect("#productSelect", {
                plugins: ['remove_button'],
                persist: false,
                create: false,
                placeholder: 'اختر منتج أو أكثر',
                maxItems: null
            });

            const selectElement = document.getElementById('productSelect');
            const tableBody = document.querySelector('#purchaseDetailsTable tbody');
            const addBtn = document.getElementById('addProduct');

            // ✅ إضافة المنتجات إلى الجدول مع كمية
            addBtn.addEventListener('click', function () {
                const selectedProducts = productSelect.getValue();
                if (selectedProducts.length === 0) {
                    alert('اختر منتج واحد على الأقل!');
                    return;
                }

                selectedProducts.forEach(productId => {
                    if (tableBody.querySelector(`[data-id="${productId}"]`)) return;

                    // ✅ احصل على العنصر option الحقيقي من الـ <select>
                    const opt = selectElement.querySelector(`option[value="${productId}"]`);
                    if (!opt) return;

                    const name = opt.textContent.trim();

                    const tr = document.createElement('tr');
                    tr.dataset.id = productId;
                    tr.innerHTML = `
                    <td>${name}
                        <input type="hidden" name="products[]" value="${productId}">
                    </td>
                    <td>
                        <input type="number" name="quantities[${productId}]"
                            class="form-control form-control-sm text-center"
                            min="1" step="1" value="1" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-outline-danger btn-sm removeRow">X</button>
                    </td>
                `;
                    tableBody.appendChild(tr);

                    tr.querySelector('.removeRow').addEventListener('click', function () {
                        tr.remove();
                    });
                });

                productSelect.clear();
            });
        });
    </script>
@endpush
