@extends('admin.layouts.master')
@section('title', 'اضافة مهندس')
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <form action="{{ route('admin.engineers.store') }}" method="POST">
                <div class="card shadow-sm mb-4">
                    @csrf
                    <!-- Card Header -->
                    <div class="card-header">
                        <h3 class="card-title mb-0">
                            <i class="ti ti-plus me-2"></i>إضافة مهندس جديد
                        </h3>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="row row-cards">
                            <!-- الاسم -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">
                                        <i class="fas fa-user me-1"></i>الاسم الكامل
                                    </label>
                                    <input type="text" name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}" autocomplete="off" >
                                    @error('name')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- البريد الإلكتروني -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">
                                        <i class="fas fa-envelope me-1"></i>البريد الإلكتروني
                                    </label>
                                    <input type="text" name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" autocomplete="off" >
                                    @error('email')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- الهاتف -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">
                                        <i class="fas fa-phone me-1"></i>رقم الهاتف
                                    </label>
                                    <input type="text" name="phone"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           value="{{ old('phone') }}" autocomplete="off" >
                                    @error('phone')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- كلمة المرور -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">
                                        <i class="fas fa-lock me-1"></i>كلمة المرور
                                    </label>
                                    <input type="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           autocomplete="new-password" >
                                    @error('password')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>


                            <!-- العنوان -->
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-map-marker-alt me-1"></i>العنوان
                                </label>
                                <input type="text" name="address"
                                       class="form-control @error('address') is-invalid @enderror"
                                       autocomplete="off"
                                       value="{{ old('address') }}">
                                @error('address')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- المرتب -->
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-wallet me-1"></i>المرتب
                                </label>
                                <input type="number" name="salary"
                                       class="form-control @error('salary') is-invalid @enderror"
                                       autocomplete="off"
                                       value="{{ old('salary', 0) }}">
                                @error('salary')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-wallet me-1"></i>ملاحظات
                                </label>
                                <input type="text" name="notes"
                                       class="form-control @error('notes') is-invalid @enderror"
                                       autocomplete="off"
                                       value="{{ old('notes') }}">
                                @error('notes')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- الرصيد -->
{{--                            <div class="mb-3">--}}
{{--                                <label class="form-label">--}}
{{--                                    <i class="fas fa-wallet me-1"></i>الرصيد الحالي--}}
{{--                                </label>--}}
{{--                                <input type="number" name="current_balance"--}}
{{--                                       class="form-control @error('current_balance') is-invalid @enderror"--}}
{{--                                       autocomplete="off"--}}
{{--                                       value="{{ old('current_balance', 0) }}">--}}
{{--                                @error('current_balance')--}}
{{--                                <div class="invalid-feedback">--}}
{{--                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}--}}
{{--                                </div>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
                        </div>
                    </div>
                    <!-- Card Footer -->
                    <div class="card-footer text-end bg-light">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-check me-1"></i> حفظ المهندس
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
