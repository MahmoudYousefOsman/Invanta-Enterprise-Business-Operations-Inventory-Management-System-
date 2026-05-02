<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    <link rel="icon" type="image/png" href="{{ asset('storage/img/invanta.png') }}" />

    <title>Invanta Dashboard @yield("title")</title>
    <!-- CSS files -->
    @vite(['resources/css/admin_rtl.css'])
    @stack('styles')
        <style>
            .ts-dropdown, .ts-dropdown.form-control, .ts-dropdown.form-select {
                background-color: #ffffff !important;
                opacity: 1 !important;
                border: 1px solid #ced4da;
                z-index: 1050;
            }
        </style>
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

<script type="text/javascript">
    window.addEventListener('alert', event => {
        //
    });
</script>
</body>

</html>
