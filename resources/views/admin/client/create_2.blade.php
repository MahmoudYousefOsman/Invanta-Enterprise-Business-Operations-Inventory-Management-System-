@extends('admin.layouts.master')
@section('title', 'إضافة عميل')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <form action="{{ route('admin.clients.store') }}" method="POST">
                @csrf
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h3 class="card-title mb-0">
                            <i class="ti ti-plus me-2"></i>إضافة عميل جديد
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="row row-cards">
                            <!-- الاسم -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">الاسم الكامل</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- الهاتف -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label required" >رقم الهاتف</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone') }}" required>
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- العنوان -->
                            <div class="mb-3">
                                <label class="form-label">العنوان</label>
                                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                       value="{{ old('address') }}">
                                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <input type="hidden" name="new_client" value="{{$new_client}}">
                            <input type="hidden" name="type" value="{{$type}}">

                        </div>
                    </div>

                    <div class="card-footer text-end bg-light">
                        <button type="submit" class="btn btn-primary">حفظ العميل</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
