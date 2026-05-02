@extends('admin.layouts.auth')
@section('content')
    <div class="card card-md">
        <div class="card-body">
            <h2 class="h2 text-center mb-4">تسجيل الدخول</h2>
            <form method="POST" action="{{ route('admin.login') }}" autocomplete="off" novalidate>
                <div class="mb-3">
                    <label class="form-label">البريد الالكتروني</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="your@email.com" value="{{old('email')}}" required autofocus autocomplete="username">
                    <ul class="list-unstyled text-danger mt-2">
                        @foreach ((array) $errors->get('email') as $message)
                        <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="mb-2">
                    <label class="form-label">
                        كلمه المرور
                        @if (Route::has('admin.password.request'))
                        <span class="form-label-description">
{{--                            <a href="{{ route('admin.password.request') }}">{{__('Forgot Your Password ?')}}</a>--}}
                        </span>
                        @endif
                    </label>
                    <input type="password" class="form-control" id="password" placeholder="كلمه المرور" name="password" required autocomplete="current-password">
                    <ul class="list-unstyled text-danger mt-2">
                        @foreach ((array) $errors->get('password') as $message)
                        <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="mb-2">
                    <label class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                        <span class="form-check-label">تذكرني </span>
                    </label>
                </div>
                <div class="form-footer">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100">تسحيل الدخول</button>

                    <a href="{{url('admin/engineer/login')}}" >
                        <button type="button" class="btn btn-primary w-100 mt-2">تسحيل دخول المهندس</button>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
