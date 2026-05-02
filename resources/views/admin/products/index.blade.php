@extends('admin.layouts.master')
@section('content')

    @php
        $type = request()->segment(3); // = maintenance or iphone

        // Mapping للأنواع حسب الـ DB
        $map = [
            'iphone' => 'phone',
            'maintenance' => 'fix',
        ];

        $dbType = $map[$type] ?? null;

        // نصوص حسب النوع
        $title = 'قائمة كل المنتجات';
        $btnText = 'اضافة منتج';
        $btnRoute = route('admin.product.create');

        if ($dbType === 'phone') {
            $title = 'قائمة منتجات البيع';
            $btnText = 'اضافة منتج بيع';
            $btnRoute = route('admin.product.create', ['type' => 'phone']);
        }

        if ($dbType === 'fix') {
            $title = 'قائمة منتجات الصيانة';
            $btnText = 'اضافة منتج صيانة';
            $btnRoute = route('admin.products.maintenance.createProductMaintenance', ['type' => 'fix']);
        }
    @endphp


    <div class="page-body">
        <!-- DataTable Card -->
        <div class="container-xl col-lg-10 mx-auto">
            <div class="row justify-content-center">
                <div class="mb-3 text-end">
                    <a href="{{ $btnRoute }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                             viewBox="0 0 24 24"
                             stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                             stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M12 5l0 14"/>
                            <path d="M5 12l14 0"/>
                        </svg>
                        {{$btnText}}
                    </a>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <div class="me-3">
                                <h3 class="card-title mb-0">{{ $title }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="table-default">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="barcodeModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="barcodeForm" method="GET" action="{{ route('admin.print.barcode') }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Generate Barcode</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        {{-- hidden id --}}
                        <input type="hidden" name="ids" id="barcode_ids">

                        {{-- quantity --}}
                        <label class="form-label">Number of barcodes</label>
                        <input
                            type="number"
                            name="qty"
                            class="form-control"
                            value="1"
                            min="1"
                            required
                        >
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            Print
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('style')
    <link
        href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.0/b-3.0.0/b-html5-3.0.0/b-print-3.0.0/sl-2.0.0/datatables.min.css"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
@endpush

@push('scripts')
    <script
        src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.0/b-3.0.0/b-html5-3.0.0/b-print-3.0.0/sl-2.0.0/datatables.min.js"></script>
    {{ $dataTable->scripts() }}
    <script>
        $(document).ready(function() {
            var table = $('#product-table').DataTable();
            var selectedIds = []; // store selected row IDs

            // When table draws (pagination, search, etc.), restore checkbox states
            table.on('draw', function() {
                table.$('input.row-select').each(function() {
                    var id = $(this).closest('tr').attr('id');
                    $(this).prop('checked', selectedIds.includes(id));
                });

                // Update master checkbox
                var allChecked = table.$('input.row-select').length > 0 &&
                    table.$('input.row-select:checked').length === table.$('input.row-select').length;
                $('#select-all').prop('checked', allChecked);
            });

            // Master checkbox
            $('#select-all').on('change', function() {
                var checked = this.checked;
                table.$('input.row-select').each(function() {
                    var id = $(this).closest('tr').attr('id');
                    $(this).prop('checked', checked);
                    if(checked && !selectedIds.includes(id)) selectedIds.push(id);
                    if(!checked) selectedIds = selectedIds.filter(x => x !== id);
                });
            });

            // Row checkbox click
            table.on('change', 'input.row-select', function() {
                var id = $(this).closest('tr').attr('id');
                if(this.checked) {
                    if(!selectedIds.includes(id)) selectedIds.push(id);
                } else {
                    selectedIds = selectedIds.filter(x => x !== id);
                }

                // Update master checkbox
                var allChecked = table.$('input.row-select').length > 0 &&
                    table.$('input.row-select:checked').length === table.$('input.row-select').length;
                $('#select-all').prop('checked', allChecked);
            });

            // Print barcode button
            $('#print-barcode-btn').click(function() {
                if(selectedIds.length === 0){
                    alert('يرجى تحديد منتج واحد على الأقل.');
                    return;
                }
                var url = '{{ route("admin.print.barcode") }}?ids=' + selectedIds.join(',');
                window.open(url, '_blank');
            });
        });
    </script>
    <script>
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.open-barcode-modal');
            if (!btn) return;
            document.getElementById('barcode_ids').value = btn.dataset.id;
        });
    </script>
@endpush
