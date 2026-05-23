<div class="card mb-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-vcenter card-table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>الكود</th>
                    <th>{{ $type=='client'?'العميل':'المورد' }}</th>
                    <th>التاريخ</th>
                    <th>الإجمالي</th>
                    <th class="d-print-none">عرض</th>
                </tr>
                </thead>
                <tbody>
                @forelse($returns as $return)
                    <tr>
                        <td class="text-muted">{{ $loop->iteration }}</td>
                        <td><span class="badge bg-blue-lt">{{ $return->code }}</span></td>
                        <td>
                            {{ $type=='client'
                                ? optional($return->client)->name
                                : optional($return->supplier)->name }}
                        </td>
                        <td>{{ $return->created_at->format('Y-m-d') }}</td>
                        <td class="fw-bold text-success">
                            {{ number_format($return->total_price,2) }}
                        </td>
                        <td class="d-print-none">
                            <a href="{{ route('admin.invoice_return.show',$return->id) }}"
                               class="btn btn-icon btn-outline-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                                     stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" role="img"
                                     aria-label="عرض">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M1.5 12s4-7.5 10.5-7.5S22.5 12 22.5 12s-4 7.5-10.5 7.5S1.5 12 1.5 12z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">
                            لا توجد بيانات
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
