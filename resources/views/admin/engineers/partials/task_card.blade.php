<div class="col-md-4 mb-4">
    <div class="card cardi h-100 hover-shadow-sm">
        <a href="{{ route('admin.engineer.task.details', $task) }}" class="stretched-link"></a>

        <div class="card-body p-3 d-flex flex-column bg-gray-100">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <h3 class="card-title mb-0 text-truncate" style="max-width: 80%;">

                </h3>
                <span class="badge bg-{{$color}}-lt">{{ ucfirst($task->status) }}</span>
            </div>

            <p class="mb-2"><strong>العميل:</strong> {{ $task->client?->name }}</p>
            <p class="mb-2"><strong>الجهاز:</strong> {{ $task->device_type }}</p>
            <p class="mb-2"><strong>الرقم التسلسلي:</strong> {{ $task->serial_number }}</p>
            <p class="text-muted mb-3 flex-grow-1">{{ Str::limit($task->description, 80) }}</p>

            <div class="mt-auto">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        بواسطة: {{ $task->admin?->name ?? 'المدير' }}
                    </small>
                    <small class="text-muted ms-auto">
                        {{ $task->created_at->diffForHumans() }}
                    </small>
                </div>
            </div>
        </div>

        <div class="card-footer bg-transparent border-top-0 pt-1 text-start">
            <strong>العمولة :</strong>
            @if($task->cost)
                <span class="text-muted">
                    = {{$task->commission_pound }}
                </span>
            @else
                <span class="text-muted">—</span>
            @endif
        </div>
    </div>
</div>
