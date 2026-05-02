@extends('admin.layouts.master')

@section('content')


    @php
        $type = request()->segment(3); // iphone or maintenance

        $map = [
            'iphone' => 'phone',
            'maintenance' => 'fix',
        ];

        $dbType = $map[$type] ?? null;

        $pageTitle = "المنتجات الناقصة";
        $pageSubTitle = "عرض جميع المنتجات التي اقتربت من النفاد في المخزون";
        $tableTitle = "قائمة المنتجات";

        if ($dbType === 'phone') {
            $pageTitle = "منتجات البيع الناقصة";
            $pageSubTitle = "عرض جميع منتجات البيع التي اقتربت من النفاد في المخزون";
            $tableTitle = "قائمة منتجات البيع";
        }

        if ($dbType === 'fix') {
            $pageTitle = "منتجات الصيانة الناقصة";
            $pageSubTitle = "عرض جميع منتجات الصيانة التي اقتربت من النفاد في المخزون";
            $tableTitle = "قائمة منتجات الصيانة";
        }
    @endphp

        <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        {{ $pageTitle }}
                    </h2>
                    <div class="page-pretitle">
                        {{ $pageSubTitle }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $tableTitle }}</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-striped">
                        <thead>
                        <tr>
                            <th>المنتج</th>
                            <th>التصنيف</th>
                            <th>الكمية الحالية</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($lowProducts as $product)
                            <tr>

                                <td>{{ $product->name }}</td>
                                <td>
                                    @if($product->category)
                                        <span class="badge bg-blue-lt">{{ $product->category->name }}</span>
                                    @else
                                        <span class="badge bg-gray-lt">غير مصنف</span>
                                    @endif
                                </td>
                                <td>
                                        <span class="badge bg-red-lt">
                                            {{ $product->quantity }}
                                        </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    لا توجد منتجات ناقصة 💚
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="m-3">
                        {{ $lowProducts->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
