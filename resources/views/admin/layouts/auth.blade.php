<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    <link rel="icon" type="image/png" href="{{ asset('storage/img/invanta.png') }}" />

    <title>@yield("title")Invanta Dashboard</title>
    <!-- CSS files -->
    @vite(['resources/css/admin.css'])
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body class=" d-flex flex-column">
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <a href="" class="navbar-brand navbar-brand">
                    <img src="{{ asset('storage/img/invanta.jpeg')}}" class="w-50 mx-auto d-block" alt="@yield('page_title', config('app.name'))" style="border-radius: 50%;">
                </a>
            </div>
            @yield('content')
        </div>

    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    @vite(['resources/js/app.js'])
</body>

</html>
