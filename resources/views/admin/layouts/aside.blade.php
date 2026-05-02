<style>

    /* Sidebar Background */
    .navbar-vertical {
        background: linear-gradient(180deg, #1e3a8a, #020617) !important;
        border-right: none;
    }

    /* Links */
    .navbar-vertical .nav-link {
        color: #cbd5f5;
        font-weight: 500;
        border-radius: 8px;
        margin: 4px 8px;
        transition: all .25s ease;
    }

    /* Hover */
    .navbar-vertical .nav-link:hover {
        background: rgba(255,255,255,0.1);
        color: #ffffff;
        transform: translateX(3px);
    }

    /* Active */
    .navbar-vertical .nav-link.active {
        background: #2563eb;
        color: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,.2);
    }

    /* Dropdown items */
    .navbar-vertical .dropdown-menu {
        background: #0f172a;
        border: none;
    }

    .navbar-vertical .dropdown-item {
        color: #cbd5f5;
        border-radius: 6px;
        transition: .2s;
    }

    .navbar-vertical .dropdown-item:hover {
        background: #1e40af;
        color: white;
    }

</style>


@php
    if (Auth::guard('admin')->check()) {
        $user = Auth::guard('admin')->user();
    } elseif (Auth::guard('engineer')->check()) {
        $user = Auth::guard('engineer')->user();
    } else {
        $user = null;
    }
@endphp
<aside class="navbar navbar-vertical navbar-left navbar-expand-lg" data-bs-theme="dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
                aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand">
            @if(Auth::guard('engineer')->check())
                <a href="{{ route('admin.engineer.tasks') }}">
                    <img src="{{ asset('assets/admin/img/invanta.png') }}" width="200" height="200" alt="Invanta"
                         class="navbar-brand-image" style="width: 200px; height: 200px; ">
                </a>
            @else
                <a href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('assets/admin/img/invanta.png') }}" width="200" height="200" alt="Invanta"
                         class="navbar-brand-image" style="width: 200px; height: 200px; ">
            @endif
        </h1>
        <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                @if(Auth::guard('engineer')->check())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/engineer/tasks') ? 'active' : '' }}"
                           href="{{ route('admin.engineer.tasks') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dashboard"
                                 width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M4 4h6v8h-6z"/>
                                <path d="M14 4h6v4h-6z"/>
                                <path d="M14 12h6v8h-6z"/>
                                <path d="M4 16h6v4h-6z"/>
                            </svg>
                        </span>
                            <span class="nav-link-title">تاسكات الصيانه</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/engineers/account') ? 'active' : '' }}"
                           href="{{ route('admin.engineers.account') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dashboard"
                                 width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M4 4h6v8h-6z"/>
                                <path d="M14 4h6v4h-6z"/>
                                <path d="M14 12h6v8h-6z"/>
                                <path d="M4 16h6v4h-6z"/>
                            </svg>
                        </span>
                            <span class="nav-link-title">كشف حسابي</span>
                        </a>
                    </li>
                @endif

                @if(Auth::guard('admin')->check())
                    {{-- لوحة الإحصائيات --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                           href="{{ route('admin.dashboard') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dashboard"
                                 width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M4 4h6v8h-6z"/>
                                <path d="M14 4h6v4h-6z"/>
                                <path d="M14 12h6v8h-6z"/>
                                <path d="M4 16h6v4h-6z"/>
                            </svg>
                        </span>
                            <span class="nav-link-title">لوحة الإحصائيات</span>
                        </a>
                    </li>

                    @if($user->can('view_engineer'))
                        {{-- قسم المهندسين --}}
                        <li class="nav-item dropdown {{ request()->is('admin/engineers*') || request()->routeIs(['admin.engineers.index', 'admin.engineers.create']) ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle {{ request()->is('admin/engineers*') || request()->routeIs(['admin.engineers.index', 'admin.engineers.create']) ? 'show' : '' }}"
                               href="#navbar-engineers" data-bs-toggle="dropdown"
                               data-bs-auto-close="outside" role="button"
                               aria-expanded="{{ request()->is('admin/engineers*') ? 'true' : 'false' }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users"
                                 width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/>
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"/>
                            </svg>
                        </span>
                                <span class="nav-link-title">المهندسين</span>
                            </a>
                            <div class="dropdown-menu {{ request()->is('admin/engineers*') || request()->routeIs(['admin.engineers.index', 'admin.engineers.create']) ? 'show' : '' }}">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <a class="dropdown-item {{ request()->routeIs('admin.engineers.index') ? 'active' : '' }}"
                                           href="{{ route('admin.engineers.index') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-list"
                                                 width="20" height="20"
                                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M9 6l11 0"/>
                                                <path d="M9 12l11 0"/>
                                                <path d="M9 18l11 0"/>
                                                <path d="M5 6l0 .01"/>
                                                <path d="M5 12l0 .01"/>
                                                <path d="M5 18l0 .01"/>
                                            </svg>
                                            كل المهندسين
                                        </a>
                                        @if($user->can('create_engineer'))
                                            <a class="dropdown-item {{ request()->routeIs('admin.engineers.create') ? 'active' : '' }}"
                                               href="{{ route('admin.engineers.create') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="icon icon-tabler icon-tabler-user-plus" width="20"
                                                     height="20"
                                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                     fill="none"
                                                     stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/>
                                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4"/>
                                                    <path d="M16 11h6m-3 -3v6"/>
                                                </svg>
                                                إضافة مهندس
                                            </a>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
                    @if($user->can('view_clients'))
                        {{-- قسم العملاء --}}
                        <li class="nav-item dropdown {{ request()->is('admin/clients*') || request()->routeIs(['admin.clients.index', 'admin.clients.create', 'admin.clients.movements', 'admin.client.movements']) ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle {{ request()->is('admin/clients*') || request()->routeIs(['admin.clients.index', 'admin.clients.create', 'admin.clients.movements', 'admin.client.movements']) ? 'show' : '' }}"
                               href="#navbar-clients" data-bs-toggle="dropdown"
                               data-bs-auto-close="outside" role="button"
                               aria-expanded="{{ request()->is('admin/clients*') ? 'true' : 'false' }}">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-address-book" width="24"
                                                 height="24"
                                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path
                                                    d="M4 4m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z"/>
                                                <path d="M16 4l0 16"/>
                                                <path d="M8 9m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/>
                                                <path d="M8 13a3 3 0 0 0 6 0"/>
                                            </svg>
                                        </span>
                                <span class="nav-link-title">العملاء</span>
                            </a>
                            <div class="dropdown-menu {{ request()->is('admin/clients*') || request()->routeIs(['admin.clients.index', 'admin.clients.create', 'admin.clients.movements', 'admin.client.movements']) ? 'show' : '' }}">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <a class="dropdown-item {{ request()->routeIs('admin.clients.index') ? 'active' : '' }}"
                                           href="{{ route('admin.clients.index') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-list" width="20"
                                                 height="20"
                                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                 fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M9 6l11 0"/>
                                                <path d="M9 12l11 0"/>
                                                <path d="M9 18l11 0"/>
                                                <path d="M5 6l0 .01"/>
                                                <path d="M5 12l0 .01"/>
                                                <path d="M5 18l0 .01"/>
                                            </svg>
                                            كل العملاء
                                        </a>
                                        @if($user->can('create_clients'))

                                            <a class="dropdown-item {{ request()->routeIs('admin.clients.create') ? 'active' : '' }}"
                                               href="{{ route('admin.clients.create') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="icon icon-tabler icon-tabler-user-plus" width="20"
                                                     height="20"
                                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                     fill="none"
                                                     stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/>
                                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4"/>
                                                    <path d="M16 11h6m-3 -3v6"/>
                                                </svg>
                                                إضافة عميل
                                            </a>
                                        @endif
                                        @if($user->can('clients_transactions'))

                                            <a class="dropdown-item {{ request()->routeIs('admin.clients.movements') ? 'active' : '' }}"
                                               href="{{ route('admin.client.movements') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="icon icon-tabler icon-tabler-history" width="20"
                                                     height="20"
                                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                     fill="none"
                                                     stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M12 8v4l3 3"/>
                                                    <path d="M4.05 13a8 8 0 1 0 .5 -4m-.5 4h3v-3"/>
                                                </svg>
                                                حركة العميل
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>

                    @endif
                    @if($user->can('view_suppliers'))
                        {{-- قسم الموردين --}}
                        <li class="nav-item dropdown {{ request()->is('admin/suppliers*') || request()->routeIs(['admin.suppliers.index', 'admin.suppliers.create', 'admin.supplier_transactions']) ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle {{ request()->is('admin/suppliers*') || request()->routeIs(['admin.suppliers.index', 'admin.suppliers.create', 'admin.supplier_transactions']) ? 'show' : '' }}"
                               href="#navbar-suppliers" data-bs-toggle="dropdown"
                               data-bs-auto-close="outside" role="button"
                               aria-expanded="{{ request()->is('admin/suppliers*') ? 'true' : 'false' }}">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="icon icon-tabler icon-tabler-truck-supplier" width="24" height="24"
                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                 stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M3 17a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                <path d="M11 17a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                <path d="M15 17h6"/>
                <path d="M5 17v-6h8"/>
                <path d="M3 9h10v6"/>
                <path d="M13 5h5l3 5v6h-5"/>
            </svg>
        </span>
                                <span class="nav-link-title">الموردين</span>
                            </a>
                            <div class="dropdown-menu {{ request()->is('admin/suppliers*') || request()->routeIs(['admin.suppliers.index', 'admin.suppliers.create', 'admin.supplier_transactions']) ? 'show' : '' }}">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <a class="dropdown-item {{ request()->routeIs('admin.suppliers.index') ? 'active' : '' }}"
                                           href="{{ route('admin.suppliers.index') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-list" width="20"
                                                 height="20"
                                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                 fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M9 6l11 0"/>
                                                <path d="M9 12l11 0"/>
                                                <path d="M9 18l11 0"/>
                                                <path d="M5 6l0 .01"/>
                                                <path d="M5 12l0 .01"/>
                                                <path d="M5 18l0 .01"/>
                                            </svg>
                                            كل الموردين
                                        </a>
                                        <a class="dropdown-item {{ request()->routeIs('admin.suppliers.create') ? 'active' : '' }}"
                                           href="{{ route('admin.suppliers.create') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-user-plus" width="20"
                                                 height="20"
                                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                 fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/>
                                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4"/>
                                                <path d="M16 11h6m-3 -3v6"/>
                                            </svg>
                                            إضافة مورد
                                        </a>
                                        <a class="dropdown-item {{ request()->routeIs('admin.supplier_transactions') ? 'active' : '' }}"
                                           href="{{ route('admin.supplier_transactions') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-report"
                                                 width="20" height="20" viewBox="0 0 24 24"
                                                 stroke-width="2" stroke="currentColor" fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M17 3l4 4l-11 11h-4v-4z"/>
                                                <path d="M12 7l-9 9v4h4l9 -9"/>
                                            </svg>
                                            كشف حساب المورين
                                        </a>
                                       
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
                    {{--                    @if ($user->can("view_category"))--}}
                    {{-- التصنيفات --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.categories.index')}}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-category"
                                     width="24" height="24"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M4 4h6v6h-6z"/>
                                    <path d="M14 4h6v6h-6z"/>
                                    <path d="M4 14h6v6h-6z"/>
                                    <circle cx="17" cy="17" r="3"/>
                                </svg>
                            </span>
                            <span class="nav-link-title">التصنيفات</span>
                        </a>
                    </li>
                    {{--                    @endif--}}
                    @if($user->can('view_products'))
                        {{-- منتجات الصيانة --}}
                        <li class="nav-item dropdown {{ request()->is('admin/products/maintenance*') ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle {{ request()->is('admin/products/maintenance*') ? 'show' : '' }}"
                               href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-tools" width="24" height="24"
                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                 stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M3 7l8 8"/>
                <path d="M7 3l8 8"/>
                <path d="M5 5l4 -4l12 12l-4 4z"/>
            </svg>
        </span>
                                <span class="nav-link-title">منتجات الصيانة</span>
                            </a>
                            <div
                                class="dropdown-menu {{ request()->is('admin/products/maintenance*') ? 'show' : '' }}">
                                <a class="dropdown-item" href="{{ route('admin.products.maintenance.index') }}">كل
                                    منتجات الصيانة</a>
                                <a class="dropdown-item"
                                   href="{{ route('admin.products.maintenance.createProductMaintenance') }}">إضافة
                                    منتج صيانة</a>
                                <a class="dropdown-item" href="{{ route('admin.products.maintenance.lowStock') }}">نواقص
                                    منتجات
                                    الصيانة</a>
                            </div>
                        </li>

                        {{-- منتجات الآيفون --}}
                        <li class="nav-item dropdown {{ request()->is('admin/products/iphone/*') || request()->routeIs(['admin.products.iphone.index', 'admin.products.iphone.create', 'admin.products.iphone.lowStock']) ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle {{ request()->is('admin/products/iphone*') || request()->routeIs(['admin.products.iphone.index', 'admin.products.iphone.create', 'admin.products.iphone.lowStock']) ? 'show' : '' }}"
                               href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-iphone" width="24"
                 height="24"
                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                 stroke-linecap="round" stroke-linejoin="round">
                 <rect x="5" y="2" width="14" height="20" rx="2"/>
                 <line x1="9" y1="18" x2="9" y2="18.01"/>
            </svg>
        </span>
                                <span class="nav-link-title">منتجات البيع</span>
                            </a>
                            <div class="dropdown-menu {{ request()->is('admin/products/iphone*') || request()->routeIs(['admin.products.iphone.index', 'admin.products.iphone.create', 'admin.products.iphone.lowStock']) ? 'show' : '' }}">
                                <a class="dropdown-item" href="{{ route('admin.products.iphone.index') }}">كل منتجات
                                    البيع</a>
                                <a class="dropdown-item" href="{{ route('admin.products.iphone.create') }}">إضافة
                                    منتج
                                    بيع</a>
                                <a class="dropdown-item" href="{{ route('admin.products.iphone.lowStock') }}">نواقص
                                    البيع</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                               href="{{ route('admin.generate.items.barcode') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dashboard"
                                 width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M4 4h6v8h-6z"/>
                                <path d="M14 4h6v4h-6z"/>
                                <path d="M14 12h6v8h-6z"/>
                                <path d="M4 16h6v4h-6z"/>
                            </svg>
                        </span>
                                <span class="nav-link-title">طباعه الباركود للمنتجات</span>
                            </a>
                        </li>
                    @endif

                    @if($user->can('view_purchase'))

                        {{-- قسم المشتريات --}}
                        <li class="nav-item dropdown {{ request()->is('admin/purchases*') || request()->routeIs(['admin.purchases.index', 'admin.purchases.create']) ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle {{ request()->is('admin/purchases*') || request()->routeIs(['admin.purchases.index', 'admin.purchases.create']) ? 'show' : '' }}"
                               href="#navbar-purchases" data-bs-toggle="dropdown"
                               data-bs-auto-close="outside" role="button"
                               aria-expanded="{{ request()->is('admin/purchases*') ? 'true' : 'false' }}">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-credit-card" width="24"
                 height="24"
                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                 stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <rect x="3" y="5" width="18" height="14" rx="3"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
        </span>
                                <span class="nav-link-title">المشتريات</span>
                            </a>
                            <div
                                class="dropdown-menu {{ request()->is('admin/purchases*') || request()->routeIs(['admin.purchases.index', 'admin.purchases.create']) ? 'show' : '' }}">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <a class="dropdown-item {{ request()->routeIs('admin.purchases.index') ? 'active' : '' }}"
                                           href="{{ route('admin.purchases.index') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-list"
                                                 width="20" height="20"
                                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                 fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M9 6h11"/>
                                                <path d="M9 12h11"/>
                                                <path d="M9 18h11"/>
                                                <path d="M5 6l0 .01"/>
                                                <path d="M5 12l0 .01"/>
                                                <path d="M5 18l0 .01"/>
                                            </svg>
                                            كل المشتريات
                                        </a>
                                        <a class="dropdown-item {{ request()->routeIs('admin.purchases.create') ? 'active' : '' }}"
                                           href="{{ route('admin.purchases.create') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-plus"
                                                 width="20" height="20"
                                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                 fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M12 5v14"/>
                                                <path d="M5 12h14"/>
                                            </svg>
                                            إضافة مشتريات
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
                    @if($user->can('view_orders'))
                        {{-- قسم الأوردرات --}}
                        <li class="nav-item dropdown {{ request()->is('admin/invoice_return*') || request()->is('admin/orders*') ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle {{ request()->is('admin/orders*') || request()->routeIs(['admin.orders.index', 'admin.orders.create']) ? 'show' : '' }}"
                               href="#navbar-orders" data-bs-toggle="dropdown"
                               data-bs-auto-close="outside" role="button"
                               aria-expanded="{{ request()->is('admin/orders*') ? 'true' : 'false' }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="icon icon-tabler icon-tabler-shopping-cart" width="24"
                                     height="24"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                     stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <circle cx="9" cy="19" r="2"/>
                                    <circle cx="17" cy="19" r="2"/>
                                    <path d="M17 17h-11v-14h-2"/>
                                    <path d="M6 5l14 1l-1 7h-13"/>
                                </svg>
                            </span>
                                <span class="nav-link-title">أوردرات</span>
                            </a>
                            <div class="dropdown-menu {{ request()->is('admin/orders*') || request()->routeIs(['admin.orders.index', 'admin.orders.create']) ? 'show' : '' }}">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <a class="dropdown-item {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}"
                                           href="{{ route('admin.orders.index') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-list"
                                                 width="20" height="20"
                                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                 fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M9 6l11 0"/>
                                                <path d="M9 12l11 0"/>
                                                <path d="M9 18l11 0"/>
                                                <path d="M5 6l0 .01"/>
                                                <path d="M5 12l0 .01"/>
                                                <path d="M5 18l0 .01"/>
                                            </svg>
                                            كل الأوردرات
                                        </a>
                                        <a class="dropdown-item {{ request()->routeIs('admin.orders.create') ? 'active' : '' }}"
                                           href="{{ route('admin.orders.create') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-plus"
                                                 width="20" height="20"
                                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                 fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M12 5v14"/>
                                                <path d="M5 12h14"/>
                                            </svg>
                                            إضافة أوردر
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        {{-- قسم المرتجعات --}}
                        <li class="nav-item dropdown {{ request()->is('admin/invoice_return*') ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle {{ request()->is('admin/invoice_return*') || request()->routeIs(['admin.invoice_return.index', 'admin.invoice_return.create']) ? 'show' : '' }}"
                               href="#navbar-orders" data-bs-toggle="dropdown"
                               data-bs-auto-close="outside" role="button"
                               aria-expanded="{{ request()->is('admin/orders*') ? 'true' : 'false' }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="icon icon-tabler icon-tabler-shopping-cart" width="24"
                                     height="24"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                     stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <circle cx="9" cy="19" r="2"/>
                                    <circle cx="17" cy="19" r="2"/>
                                    <path d="M17 17h-11v-14h-2"/>
                                    <path d="M6 5l14 1l-1 7h-13"/>
                                </svg>
                            </span>
                                <span class="nav-link-title">المرتجعات</span>
                            </a>
                            <div class="dropdown-menu {{ request()->is('admin/invoice_return*') || request()->routeIs(['admin.invoice_return.index', 'admin.invoice_return.create']) ? 'show' : '' }}">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <a class="dropdown-item {{ request()->routeIs('admin.invoice_return.index') ? 'active' : '' }}"
                                           href="{{ route('admin.invoice_return.index') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-list"
                                                 width="20" height="20"
                                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                 fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M9 6l11 0"/>
                                                <path d="M9 12l11 0"/>
                                                <path d="M9 18l11 0"/>
                                                <path d="M5 6l0 .01"/>
                                                <path d="M5 12l0 .01"/>
                                                <path d="M5 18l0 .01"/>
                                            </svg>
                                            كل المرتجعات
                                        </a>
                                        <a class="dropdown-item {{ request()->routeIs('admin.invoice_return.create') ? 'active' : '' }}"
                                           href="{{ route('admin.invoice_return.create') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-plus"
                                                 width="20" height="20"
                                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                 fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M12 5v14"/>
                                                <path d="M5 12h14"/>
                                            </svg>
                                            إضافة مرتجعات
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif

                    @if($user->can('view_tasks'))
                        {{-- طلبات الصيانة --}}
                        <li class="nav-item dropdown {{ request()->is('admin/task*') || request()->routeIs(['admin.task.index', 'admin.task.create']) ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle {{ request()->is('admin/task*') || request()->routeIs(['admin.task.index', 'admin.task.create']) ? 'show' : '' }}"
                               href="#navbar-tasks" data-bs-toggle="dropdown"
                               data-bs-auto-close="outside" role="button"
                               aria-expanded="{{ request()->is('admin/task*') ? 'true' : 'false' }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-tools"
                                 width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M3 21v-4a3 3 0 0 1 3 -3h4"/>
                                <path d="M21 3v4a3 3 0 0 1 -3 3h-4"/>
                                <path d="M18 21l-3 -3a3 3 0 0 1 0 -4l1 -1"/>
                                <path d="M21 18l-3 -3a3 3 0 0 0 -4 0l-1 1"/>
                                <path d="M3 3l18 18"/>
                            </svg>
                        </span>
                                <span class="nav-link-title">طلبات الصيانة</span>
                            </a>
                            <div class="dropdown-menu {{ request()->is('admin/task*') || request()->routeIs(['admin.task.index', 'admin.task.create']) ? 'show' : '' }}">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        @if($user->can('view_tasks'))
                                            <a class="dropdown-item {{ request()->routeIs('admin.task.index') ? 'active' : '' }}"
                                               href="{{ route('admin.task.index') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="icon icon-tabler icon-tabler-list-check" width="20"
                                                     height="20"
                                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                     fill="none"
                                                     stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M9 6h11"/>
                                                    <path d="M9 12h11"/>
                                                    <path d="M9 18h11"/>
                                                    <path d="M5 6l0 .01"/>
                                                    <path d="M5 12l0 .01"/>
                                                    <path d="M5 18l0 .01"/>
                                                </svg>
                                                كل طلبات الصيانة
                                            </a>
                                        @endif
                                        @if($user->can('create_tasks'))
                                            <a class="dropdown-item {{ request()->routeIs('admin.task.create') ? 'active' : '' }}"
                                               href="{{ route('admin.task.create') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="icon icon-tabler icon-tabler-plus"
                                                     width="20" height="20"
                                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                     fill="none"
                                                     stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M12 5v14"/>
                                                    <path d="M5 12h14"/>
                                                </svg>
                                                إضافة طلب صيانة
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
                    @if($user->can('view_settings'))
                       
                    @endif
                    @if($user->can('reports'))
                        {{-- reports --}}
                        <li class="nav-item dropdown {{ request()->is('admin/reports*') || request()->routeIs(['admin.general.report', 'admin.order.report.index', 'admin.purchases.report', 'admin.task.report', 'admin.return.report.index', 'admin.products.movements']) ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle {{ request()->is('admin/reports*') || request()->routeIs(['admin.general.report', 'admin.order.report.index', 'admin.purchases.report', 'admin.task.report', 'admin.return.report.index', 'admin.products.movements']) ? 'show' : '' }}"
                               href="#navbar-suppliers" data-bs-toggle="dropdown"
                               data-bs-auto-close="outside" role="button"
                               aria-expanded="{{ request()->is('admin/reports*') ? 'true' : 'false' }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="icon icon-tabler icon-tabler-truck-supplier" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M3 17a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                <path d="M11 17a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                <path d="M15 17h6"/>
                                <path d="M5 17v-6h8"/>
                                <path d="M3 9h10v6"/>
                                <path d="M13 5h5l3 5v6h-5"/>
                            </svg>
                        </span>
                                <span class="nav-link-title">التقارير</span>
                            </a>
                            <div class="dropdown-menu {{ request()->is('admin/reports*') || request()->routeIs(['admin.general.report', 'admin.order.report.index', 'admin.purchases.report', 'admin.task.report', 'admin.return.report.index', 'admin.products.movements']) ? 'show' : '' }}">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                         <a class="dropdown-item {{ request()->routeIs('admin.general.report') ? 'active' : '' }}"
                                           href="{{ route('admin.general.report') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-list" width="20"
                                                 height="20"
                                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                 fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M9 6l11 0"/>
                                                <path d="M9 12l11 0"/>
                                                <path d="M9 18l11 0"/>
                                                <path d="M5 6l0 .01"/>
                                                <path d="M5 12l0 .01"/>
                                                <path d="M5 18l0 .01"/>
                                            </svg>
                                            تقارير الارباح العامه
                                        </a>
                                        <a class="dropdown-item {{ request()->routeIs('admin.order.report.index') ? 'active' : '' }}"
                                           href="{{ route('admin.order.report.index') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-list" width="20"
                                                 height="20"
                                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                 fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M9 6l11 0"/>
                                                <path d="M9 12l11 0"/>
                                                <path d="M9 18l11 0"/>
                                                <path d="M5 6l0 .01"/>
                                                <path d="M5 12l0 .01"/>
                                                <path d="M5 18l0 .01"/>
                                            </svg>
                                            تقارير الاوردرات
                                        </a>
                                        <a class="dropdown-item {{ request()->routeIs('admin.purchases.report') ? 'active' : '' }}"
                                           href="{{ route('admin.purchases.report') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-list" width="20"
                                                 height="20"
                                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                 fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M9 6l11 0"/>
                                                <path d="M9 12l11 0"/>
                                                <path d="M9 18l11 0"/>
                                                <path d="M5 6l0 .01"/>
                                                <path d="M5 12l0 .01"/>
                                                <path d="M5 18l0 .01"/>
                                            </svg>
                                            تقارير المشتريات
                                        </a>
                                        <a class="dropdown-item {{ request()->routeIs('admin.task.report') ? 'active' : '' }}"
                                           href="{{ route('admin.task.report') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-list" width="20"
                                                 height="20"
                                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                 fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M9 6l11 0"/>
                                                <path d="M9 12l11 0"/>
                                                <path d="M9 18l11 0"/>
                                                <path d="M5 6l0 .01"/>
                                                <path d="M5 12l0 .01"/>
                                                <path d="M5 18l0 .01"/>
                                            </svg>
                                            تقارير تاسكات الصيانه
                                        </a>

                                        <a class="dropdown-item {{ request()->routeIs('admin.return.report.index') ? 'active' : '' }}"
                                           href="{{ route('admin.return.report.index') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-list" width="20"
                                                 height="20"
                                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                 fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M9 6l11 0"/>
                                                <path d="M9 12l11 0"/>
                                                <path d="M9 18l11 0"/>
                                                <path d="M5 6l0 .01"/>
                                                <path d="M5 12l0 .01"/>
                                                <path d="M5 18l0 .01"/>
                                            </svg>
                                            تقارير المرتجعات
                                        </a>
                                        {{-- حركة المنتجات  --}}
                                        @if($user->can('product_transaction'))
                                            <a class="dropdown-item"
                                               {{ request()->routeIs('admin.products.movements') ? 'active' : '' }}
                                               href="{{ route('admin.products.movements')}}">
                                              <span class="nav-link-icon d-md-none d-lg-inline-block">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="icon icon-tabler icon-tabler-arrows-left-right"
                 width="24" height="24"
                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                 fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 17h-18l3 3m-3 -3l3 -3"/>
                <path d="M3 7h18l-3 -3m3 3l-3 3"/>
            </svg>
        </span>
                                                تقاير حركة المنتجات
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
                @endif
            </ul>
        </div>
    </div>
</aside>
