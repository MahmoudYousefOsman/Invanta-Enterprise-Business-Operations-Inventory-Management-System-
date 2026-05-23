<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="rtl" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="theme-color" content="#2563eb">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    <link rel="icon" type="image/png" href="{{ asset('assets/admin/img/invanta.png') }}" />

    <title>@yield("title")Invanta Dashboard</title>

    <script>
        (function () {
            try {
                var t = localStorage.getItem('invanta-theme') || 'light';
                document.documentElement.setAttribute('data-bs-theme', t);
            } catch (e) {}
        })();
    </script>

    <!-- CSS files -->
    @vite(['resources/css/admin.css'])
</head>

<body class="inv-auth-body d-flex flex-column">
    {{-- Theme toggle (corner) --}}
    <button type="button" class="inv-icon-btn" onclick="invantaToggleTheme()"
            style="position:fixed; top:1.25rem; inset-inline-end:1.25rem; z-index:10;" title="تبديل المظهر">
        <svg class="theme-icon-sun" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
             stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <circle cx="12" cy="12" r="4"/>
            <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7"/>
        </svg>
        <svg class="theme-icon-moon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
             stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z"/>
        </svg>
    </button>

    <div class="page page-center">
        <div class="container py-4" style="max-width: 600px;">
            <div class="text-center mb-4">
                <a href="" class="navbar-brand">
                    <img src="{{ asset('assets/admin/img/invanta.jpeg')}}" class="mx-auto d-block"
                         alt="@yield('page_title', config('app.name'))"
                         style="width:104px; height:104px; object-fit:cover; border-radius:50%; box-shadow: var(--inv-shadow-lg);">
                </a>
            </div>
            @yield('content')
        </div>
    </div>

    <!-- Libs JS -->
    @vite(['resources/js/app.js'])
    <script>
        window.invantaToggleTheme = function () {
            var html = document.documentElement;
            var next = html.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-bs-theme', next);
            try { localStorage.setItem('invanta-theme', next); } catch (e) {}
        };
    </script>
</body>

</html>
