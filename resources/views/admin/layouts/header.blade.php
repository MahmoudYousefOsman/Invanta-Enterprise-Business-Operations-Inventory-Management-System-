<header class="navbar navbar-expand-md sticky-top d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
{{--            <a href="{{ route('admin.dashboard') }}">--}}
{{--                <img--}}
{{--                    src="{{ asset('/src/assets/images/logo.png') }}"--}}
{{--                    alt="Dealin"--}}
{{--                    loading="lazy"--}}
{{--                    class="img-logo img-cover"--}}
{{--                    width="30px"--}}
{{--                    height="30px"--}}
{{--                />--}}
{{--            </a>--}}
        </h1>
        <div class="navbar-nav flex-row order-md-last">

            <div class="nav-item dropdown me-3">

            @if(auth('admin')->check())
                @php
                    $admin = auth('admin')->user();
                @endphp

                <li class="nav-item dropdown">
                    <a class="nav-link" data-bs-toggle="dropdown" href="#">
        <span class="position-relative d-inline-block">
            <!-- أيقونة الجرس -->
              <svg xmlns="http://www.w3.org/2000/svg" class="icon bell-icon" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
  <defs>
    <linearGradient id="bellGradient" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#facc15"/>
      <stop offset="50%" stop-color="#f97316"/>
      <stop offset="100%" stop-color="#ef4444"/>
    </linearGradient>
  </defs>
  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
  <path d="M5 17v-3a7 7 0 0 1 5-6.708V6a2 2 0 1 1 4 0v1.292A7 7 0 0 1 19 14v3" stroke="url(#bellGradient)"/>
  <path d="M9 17a3 3 0 0 0 6 0" stroke="url(#bellGradient)"/>
  <circle cx="12" cy="19" r="1.5" fill="url(#bellGradient)"/>
</svg>

            <!-- عدد الإشعارات -->
            @if($admin->unreadNotifications->count() > 0)
                <span class="fw-bold"
                      style="position:absolute; top:-6px; right:-8px; font-size:13px; color:red;">
                    {{ $admin->unreadNotifications->count() }}
                </span>
            @endif
        </span>
                    </a>

                    <!-- قائمة الإشعارات -->
                    <ul class="dropdown-menu dropdown-menu-end" style="min-width:280px; max-height:300px; overflow:auto;">

                        @forelse($admin->unreadNotifications as $notification)
                            <li>
                                <a href="{{ route('admin.notifications.redirect', $notification->id) }}"
                                   class="dropdown-item d-flex justify-content-between align-items-start">
                                    <div>
                                        <div>{{ $notification->data['message'] }}</div>
                                        <small class="text-muted">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <li class="dropdown-item text-muted">لا توجد إشعارات جديدة</li>
                        @endforelse

                    </ul>
                </li>

            @endif
            </div>


            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                   aria-label="Open user menu">
                    <span class="avatar avatar-sm"
                          style="background-image:url({{asset('assets/admin/img/logo.jpeg')}})"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ auth('admin')->user()?->name ?? auth('engineer')->user()?->name }}</div>
                        <div class="mt-1 small text-muted">{{auth('admin')->user()?->email ?? auth('engineer')->user()?->email}}</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
{{--                    <a href="#" class="dropdown-item">اعدادات الحساب</a>--}}
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
