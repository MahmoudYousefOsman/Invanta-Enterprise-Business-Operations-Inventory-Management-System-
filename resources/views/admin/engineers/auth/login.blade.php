@extends('admin.layouts.auth')

@section('content')
    <div class="card card-md">
        <div class="card-body">
            <h2 class="h2 text-center mb-4">تسجيل دخول المهندسين</h2>
            <form method="POST" action="{{ route('admin.engineer.login.submit') }}" autocomplete="on">
                @csrf

                <!-- البريد الإلكتروني -->
                <div class="mb-3">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input type="text" class="form-control" name="email" placeholder="ادخل بريدك الإلكتروني" value="{{ old('email') }}"   autofocus>
                    <ul class="list-unstyled text-danger mt-2">
                        @foreach ((array) $errors->get('email') as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>

                <!-- كلمة المرور -->
                <div class="mb-3">
                    <label class="form-label">كلمة المرور</label>
                    <input type="password" class="form-control" name="password" placeholder="ادخل كلمة المرور" >
                    <ul class="list-unstyled text-danger mt-2">
                        @foreach ((array) $errors->get('password') as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>

                <!-- تذكرني -->
                <div class="mb-2">
                    <label class="form-check">
                        <input type="checkbox" class="form-check-input" name="remember">
                        <span class="form-check-label">تذكرني</span>
                    </label>
                </div>

                <!-- زر الدخول -->
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">تسجيل الدخول</button>
                </div>
            </form>
        </div>
    </div>
@endsection
