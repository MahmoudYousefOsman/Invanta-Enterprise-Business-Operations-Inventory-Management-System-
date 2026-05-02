<div class="col-md-3 mb-4">
    <div class="position-relative">
        <a class="btn btn-icon btn-outline-primary mx-1 position-absolute"
           style="top: -10px; right: -10px; z-index: 10;"
           href="{{ url( "admin/task/print/$task->id")}}"
           target="_blank">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 9V2h12v7"/>
                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                <path d="M6 14h12v8H6z"/>
            </svg>
        </a>
        <div class="card cardi h-100 hover-shadow-sm">

            <a href="{{ route('admin.task.show', $task) }}" class="stretched-link"></a>

            <div class="card-body  bg-gray-100">
                {{-- الحالة --}}
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h3 class="card-title mb-0 text-truncate" style="max-width: 70%;"></h3>
                    <span class="badge bg-{{$color}}-lt">{{ ucfirst($task->status) }}</span>
                </div>

                <div class="d-flex justify-content-between">

                    <div class=" flex-grow-1">
                        <p class="mb-2 text-primary"><strong
                                class="text-black">العميل:</strong> {{ $task->client?->name }}</p>
                        <p class="mb-2 text-primary"><strong
                                class="text-black">المهندس:</strong> {{ $task->engineer?->name }}</p>
                        <p class="mb-2 text-warning"><strong class="text-black">تاريخ الاستلام
                                :</strong> {{ $task->receipt_date }}</p>
                        <p class="mb-2 text-success"><strong class="text-black">تاريخ
                                التسليم:</strong> {{ $task->due_date }}</p>
                    </div>

                    <div class="" style="min-width: 130px;">
                        <div class="mb-2">
                            <strong>التكلفة:</strong><br>
                            @if($task->cost)
                                <span class="text-primary">{{ number_format($task->cost) }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </div>

                        <div class="mb-2">
                            <strong>المدفوع:</strong><br>
                            @if($task->cost)
                                <span class="text-primary">{{ number_format($task->payed) }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </div>

                        <div>
                            <strong>المتبقي:</strong><br>
                            <span class="text-success">{{ number_format($task->cost - $task->payed) }}</span>
                        </div>
                    </div>
                </div>

                {{-- آخر الصف --}}
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <small class="text-muted">بواسطة: {{ $task->admin?->name ?? 'المدير' }}</small>
                    <small class="text-muted">{{ $task->created_at->diffForHumans() }}</small>
                </div>
            </div>
        </div>
    </div> {{-- نهاية position-relative --}}

</div>
