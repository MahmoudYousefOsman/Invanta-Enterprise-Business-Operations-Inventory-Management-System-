@extends('admin.layouts.master')
@section('title', 'إضافة مورد')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <form action="{{ route('admin.suppliers.store') }}" method="POST">
                @csrf
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h3 class="card-title mb-0">
                            <i class="ti ti-plus me-2"></i>إضافة مورد جديد
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="row row-cards">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">اسم المورد</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" placeholder="أدخل اسم المورد">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label required">رقم الهاتف</label>
                                <input type="text" name="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone') }}" placeholder="أدخل رقم الهاتف">
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>


                            {{--                                                        <!-- تاريخ الإضافة -->--}}
                            {{--                                                        <div class="col-md-6 mb-3">--}}
                            {{--                                                            <label class="form-label">تاريخ الإضافة</label>--}}
                            {{--                                                            <input type="date" name="created_at"--}}
                            {{--                                                                   class="form-control @error('created_at') is-invalid @enderror"--}}
                            {{--                                                                   value="{{ old('created_at', now()->format('Y-m-d')) }}">--}}
                            {{--                                                            @error('created_at')<div class="invalid-feedback">{{ $message }}</div>@enderror--}}
                            {{--                                                        </div>--}}


                                                                                    <!-- الرصيد الحالي -->
                                                                                    <div class="col-md-6 mb-3">
                                                                                        <label class="form-label">الرصيد الافتتاحي</label>
                                                                                        <input type="number" name="current_balance" step="0.01"
                                                                                               class="form-control @error('current_balance') is-invalid @enderror"
                                                                                               value="{{ old('current_balance', 0) }}" placeholder="0.00">
                                                                                        @error('current_balance')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                                                    </div>
                            <!-- العنوان -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">العنوان</label>
                                <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                                          rows="3" placeholder="أدخل عنوان المورد">{{ old('address') }}</textarea>
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{--                                                        <div class="col-md-6 mb-3">--}}
                            {{--                                                            <label class="form-label">ملاحظات</label>--}}
                            {{--                                                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror"--}}
                            {{--                                                                      rows="3" placeholder="ملاحظات إضافية">{{ old('notes') }}</textarea>--}}
                            {{--                                                            @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror--}}
                            {{--                                                        </div>--}}
                            {{--                                                    </div>--}}
                        </div>

                        <div class="card-footer text-end bg-light">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-check me-2"></i>حفظ المورد
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
