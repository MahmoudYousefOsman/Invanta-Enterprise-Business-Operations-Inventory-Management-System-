@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">

            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">منتجات الموردين</h3>
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3" action="{{route('admin.search.supplier.products')}}">
                        <div class="col-md-4">
                            <label class="form-label"> المورد</label>
                            <select name="supplier_id" id="supplierSelect" class="form-select">
                                <option value="">-- اختر المورد --</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">اسم المنتج</label>
                            <select name="product_id" id="productSelect" class="form-select">
                                <option value="">-- اختر المنتج --</option>
                                @foreach($products as $prod)
                                    <option value="{{ $prod->id }}" {{ request('product_id') == $prod->id ? 'selected' : '' }}>
                                        {{ $prod->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

{{--                        <div class="col-md-3">--}}
{{--                            <label class="form-label">من تاريخ</label>--}}
{{--                            <input type="date" name="from" class="form-control" value="{{ request('from') }}">--}}
{{--                        </div>--}}

{{--                        <div class="col-md-3">--}}
{{--                            <label class="form-label">إلى تاريخ</label>--}}
{{--                            <input type="date" name="to" class="form-control" value="{{ request('to') }}">--}}
{{--                        </div>--}}

                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="20" height="20"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                     fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8" />
                                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                </svg>
                                بحث
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">حركات المنتجات</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter table-striped">
                        <thead>
                        <tr>
                            <th>اسم المورد</th>
                            <th>اسم المنتج</th>
                            <th>الكمية</th>
                            <th>التاريخ</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($supplierStocks as $s)
                            <tr>
                                <td>{{ $s->supplier->name ?? '-' }}</td>
                                <td>{{ $s->product->name ?? '-' }}</td>
                                <td>{{ $s->quantity }}</td>
                                <td>{{ $s->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">لا توجد بيانات</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="m-3">
                    {{ $supplierStocks->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var el;
            window.TomSelect &&
            new TomSelect((el = document.getElementById("productSelect")), {
                copyClassesToDropdown: false,
                dropdownParent: "body",
                controlInput: "<input>",
                render: {
                    item: function (data, escape) {
                        if (data.customProperties) {
                            return '<div><span class="dropdown-item-indicator">' + data.customProperties + "</span>" + escape(data.text) + "</div>";
                        }
                        return "<div>" + escape(data.text) + "</div>";
                    },
                    option: function (data, escape) {
                        if (data.customProperties) {
                            return '<div><span class="dropdown-item-indicator">' + data.customProperties + "</span>" + escape(data.text) + "</div>";
                        }
                        return "<div>" + escape(data.text) + "</div>";
                    },
                },
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var el;
            window.TomSelect &&
            new TomSelect((el = document.getElementById("supplierSelect")), {
                copyClassesToDropdown: false,
                dropdownParent: "body",
                controlInput: "<input>",
                render: {
                    item: function (data, escape) {
                        if (data.customProperties) {
                            return '<div><span class="dropdown-item-indicator">' + data.customProperties + "</span>" + escape(data.text) + "</div>";
                        }
                        return "<div>" + escape(data.text) + "</div>";
                    },
                    option: function (data, escape) {
                        if (data.customProperties) {
                            return '<div><span class="dropdown-item-indicator">' + data.customProperties + "</span>" + escape(data.text) + "</div>";
                        }
                        return "<div>" + escape(data.text) + "</div>";
                    },
                },
            });
        });
    </script>
@endpush
