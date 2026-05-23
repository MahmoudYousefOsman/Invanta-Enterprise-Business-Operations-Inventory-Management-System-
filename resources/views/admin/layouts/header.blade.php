<header class="navbar navbar-expand-md sticky-top d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3"></h1>

        <div class="navbar-nav flex-row order-md-last align-items-center" style="gap:.6rem;">

            {{-- Light / Dark theme toggle --}}
            <button type="button" class="inv-icon-btn" onclick="invantaToggleTheme()" title="تبديل المظهر"
                    aria-label="تبديل المظهر (فاتح / داكن)">
                {{-- Sun (shown in dark mode) --}}
                <svg class="theme-icon-sun" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                     stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <circle cx="12" cy="12" r="4"/>
                    <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7"/>
                </svg>
                {{-- Moon (shown in light mode) --}}
                <svg class="theme-icon-moon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                     stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z"/>
                </svg>
            </button>

            @if(auth('admin')->check())
                @php $admin = auth('admin')->user(); @endphp

                {{-- Notifications --}}
                <div class="nav-item dropdown">
                    <a class="inv-icon-btn" data-bs-toggle="dropdown" href="#" aria-label="الإشعارات">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                             stroke-width="1.8" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"/>
                            <path d="M9 17v1a3 3 0 0 0 6 0v-1"/>
                        </svg>
                        @if($admin->unreadNotifications->count() > 0)
                            <span class="inv-badge">{{ $admin->unreadNotifications->count() }}</span>
                        @endif
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end" style="min-width:300px; max-height:340px; overflow:auto;">
                        <li class="px-3 py-2 fw-bold border-bottom">الإشعارات</li>
                        @forelse($admin->unreadNotifications as $notification)
                            <li>
                                <a href="{{ route('admin.notifications.redirect', $notification->id) }}"
                                   class="dropdown-item d-flex justify-content-between align-items-start py-2">
                                    <div>
                                        <div>{{ $notification->data['message'] }}</div>
                                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <li class="dropdown-item text-muted text-center py-3">لا توجد إشعارات جديدة</li>
                        @endforelse
                    </ul>
                </div>
            @endif

            {{-- User menu --}}
            <div class="nav-item dropdown">
                <a href="#" class="inv-user-chip text-reset" data-bs-toggle="dropdown" aria-label="Open user menu">
                    <span class="avatar avatar-sm rounded-circle"
                          style="background-image:url({{asset('assets/admin/img/logo.jpeg')}})"></span>
                    <div class="d-none d-xl-block lh-1">
                        <div class="fw-semibold">{{ auth('admin')->user()?->name ?? auth('engineer')->user()?->name }}</div>
                        <div class="mt-1 small text-muted">{{auth('admin')->user()?->email ?? auth('engineer')->user()?->email}}</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    @if(auth('admin')->user())
                        <form method="post" action="{{route('admin.logout')}}">
                            @csrf
                            <button type="submit" class="dropdown-item">تسجيل الخروج</button>
                        </form>
                    @else
                        <form method="post" action="{{route('admin.engineer.logout')}}">
                            @csrf
                            <button type="submit" class="dropdown-item">تسجيل الخروج</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>
