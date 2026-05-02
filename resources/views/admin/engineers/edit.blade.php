@extends('admin.layouts.master')

@section('title', 'تعديل مهندس')

@section('content')
    <div class="page-body">
        <div class="container-xl col-lg-10 mx-auto">
            <div class="row justify-content-center">
                <div class="card shadow-sm mb-4">
                    <form action="{{ route('admin.engineers.update', $engineer->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Card Header -->
                        <div class="card-header">
                            <h3 class="card-title mb-0">
                                <i class="ti ti-edit me-2"></i> تعديل مهندس
                            </h3>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="row row-cards">

                                <!-- الاسم الكامل -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">
                                            <i class="fas fa-user me-1"></i> الاسم الكامل
                                        </label>
                                        <input type="text" name="name"
                                               class="form-control @error('name') is-invalid @enderror"
                                               value="{{ old('name',$engineer->name) }}">
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
                                            <i class="fas fa-envelope me-1"></i> البريد الإلكتروني
                                        </label>
                                        <input type="text" name="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               value="{{ old('email',$engineer->email) }}" >
                                        @error('email')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- رقم الهاتف -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">
                                            <i class="fas fa-phone me-1"></i> رقم الهاتف
                                        </label>
                                        <input type="text" name="phone"
                                               class="form-control @error('phone') is-invalid @enderror"
                                               value="{{ old('phone', $engineer->phone) }}" >
                                        @error('phone')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- كلمة المرور الحالية -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">
                                            <i class="fas fa-lock me-1"></i>ادخل كلمة المرور الحالية
                                        </label>
                                        <input type="password" name="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               autocomplete="current-password" >
                                        @error('password')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                        @enderror

                                    </div>
                                </div>

                                <!-- كلمة المرور الجديدة -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            <i class="fas fa-lock me-1"></i> كلمة المرور الجديدة
                                        </label>
                                        <input type="password" name="new_password"
                                               class="form-control @error('new_password') is-invalid @enderror"
                                               autocomplete="new-password">
                                        @error('new_password')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                        @enderror
                                        <small class="text-muted">اتركها فارغة إذا لم ترغب في تغيير كلمة المرور</small>
                                    </div>
                                </div>

                                <!-- العنوان -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            <i class="fas fa-map-marker-alt me-1"></i> العنوان
                                        </label>
                                        <input type="text"  name="address"
                                               class="form-control @error('address') is-invalid @enderror"
                                               value="{{ old('address' , $engineer->address) }}">
                                        @error('address')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- المرتب -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            <i class="fas fa-wallet me-1"></i> المرتب
                                        </label>
                                        <input type="number" name="salary"
                                               class="form-control @error('salary') is-invalid @enderror"
                                               value="{{ old('salary',$engineer->salary) }}">
                                        @error('salary')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- الرصيد الحالي -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            <i class="fas fa-wallet me-1"></i> الرصيد الحالي
                                        </label>
                                        <input type="number"  name="current_balance"
                                               class="form-control @error('current_balance') is-invalid @enderror"
                                               value="{{ old('current_balance', $engineer->current_balance) }}">
                                        @error('current_balance')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="card-footer text-end bg-light">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-check me-1"></i> حفظ التعديلات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
