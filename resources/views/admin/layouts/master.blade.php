<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="rtl" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#2563eb">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    <link rel="icon" type="image/png" href="{{ asset('assets/admin/img/invanta.png') }}" />

    <title>Invanta Dashboard @yield("title")</title>

    {{-- No-flash theme bootstrap: apply the stored theme before first paint --}}
    <script>
        (function () {
            try {
                var t = localStorage.getItem('invanta-theme') || 'light';
                document.documentElement.setAttribute('data-bs-theme', t);
            } catch (e) {}
        })();
    </script>

    <!-- CSS files -->
    @vite(['resources/css/admin_rtl.css'])
    @stack('styles')
    <!-- Font Awesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>

<body>
@stack('modals')
<div class="page">
    @include('admin.layouts.aside')
    <!-- Navbar -->
    <div class="sticky-top">
        @include('admin.layouts.header')
    </div>
    <div class="page-wrapper">
        @yield('content')
        @include('admin.layouts.footer')
    </div>
</div>
<!-- Tabler Core -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@vite(['resources/js/app.js'])

@stack('scripts')

{{-- Light / Dark theme toggle --}}
<script>
    window.invantaToggleTheme = function () {
        var html = document.documentElement;
        var next = html.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
        html.setAttribute('data-bs-theme', next);
        try { localStorage.setItem('invanta-theme', next); } catch (e) {}
        document.dispatchEvent(new CustomEvent('invanta:theme', { detail: next }));
    };
    window.addEventListener('alert', event => {
        //
    });
</script>
</body>

</html>
