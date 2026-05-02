@php
    $badgeClass = match($status) {
        'new' => 'bg-success-lt',
        'pending' => 'bg-info-lt',
        'cancelled' => 'bg-danger-lt',
        default => 'bg-secondary-lt',
    };
@endphp

<span class="badge {{ $badgeClass }}">{{ $status }}</span>
