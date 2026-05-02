@if ($photo)
    <a href="{{ asset('storage/' . $photo) }}" target="_blank" title="{{ $name }}">
        <img src="{{ asset('storage/' . $photo) }}"
             alt="{{ $name }}"
             width="60" height="60"
             class="img-thumbnail rounded">
    </a>
@else
    <span class="text-muted">لا يوجد صورة</span>
@endif
