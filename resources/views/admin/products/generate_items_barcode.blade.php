@extends('admin.layouts.master')

@section('content')

    <div class="page-body">
        <div class="container-xl col-lg-11 mx-lg-auto">

            <div class="card p-4">

                {{-- ========= Add product row ========= --}}
                <div class="row g-2">

                    <div class="col-md-6">
                        <select id="product_select" class="form-control">
                            <option value="">-- اختر المنتج --</option>

                            @foreach($products as $product)
                                <option
                                    value="{{ $product->id }}"
                                    data-name="{{ $product->name }}">
                                    {{ $product->name }} ({{ $product->code }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <input
                            type="number"
                            id="qty_input"
                            class="form-control"
                            placeholder="Qty"
                            value="1"
                            min="1">
                    </div>

                    <div class="col-md-2">
                        <button type="button" id="add_btn" class="btn btn-success w-100">
                            Add
                        </button>
                    </div>

                </div>


                {{-- ========= Table + Print ========= --}}
                <form method="GET" action="{{ route('admin.print.items.barcode') }}">

                    <table class="table mt-4" id="barcode_table">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th width="140">Qty</th>
                            <th width="80"></th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <button type="submit" class="btn btn-primary mt-3">
                        Print All
                    </button>

                </form>

            </div>
        </div>
    </div>

@endsection


@push('scripts')

    {{-- ========= TomSelect CDN ========= --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /* =========================
               TomSelect Init
            ========================= */
            const productTomSelect = new TomSelect('#product_select', {
                placeholder: "-- اختر المنتج --",
                allowEmptyOption: true,
                maxOptions: 5000,
                searchField: ['text'],
                dropdownParent: 'body',
            });


            /* =========================
               Add Product
            ========================= */
            document.getElementById('add_btn').addEventListener('click', function () {

                let id  = productTomSelect.getValue();
                let qty = document.getElementById('qty_input').value;

                if (!id || qty <= 0) return;

                let option = productTomSelect.options[id];

                let name = option.dataset?.name || option.text;
                let text = option.text;

                let row = `
        <tr data-id="${id}" data-text="${text}">
            <td>
                ${name}
                <input type="hidden" name="items[${id}][id]" value="${id}">
            </td>

            <td>
                <input type="number"
                       name="items[${id}][qty]"
                       class="form-control"
                       value="${qty}"
                       min="1">
            </td>

            <td>
                <button type="button" class="btn btn-danger remove">X</button>
            </td>
        </tr>
    `;

                document.querySelector('#barcode_table tbody')
                    .insertAdjacentHTML('beforeend', row);


                /* ========= FIXES ========= */

                // remove option
                productTomSelect.removeOption(id);

                // clear selection
                productTomSelect.clear(true);

                // refresh placeholder
                productTomSelect.refreshOptions(false);

                // focus back to select
                setTimeout(() => productTomSelect.focus(), 50);

                // reset qty
                document.getElementById('qty_input').value = 1;
            });



            /* =========================
               Remove Product
            ========================= */
            document.addEventListener('click', function (e) {

                if (!e.target.classList.contains('remove')) return;

                let row = e.target.closest('tr');

                let id   = row.dataset.id;
                let text = row.dataset.text;

                productTomSelect.addOption({
                    value: id,
                    text: text
                });

                row.remove();
            });


            /* =========================
               Enter key adds quickly
            ========================= */
            document.getElementById('qty_input').addEventListener('keypress', function(e){
                if(e.key === 'Enter'){
                    e.preventDefault();
                    document.getElementById('add_btn').click();
                }
            });

        });
    </script>

@endpush
