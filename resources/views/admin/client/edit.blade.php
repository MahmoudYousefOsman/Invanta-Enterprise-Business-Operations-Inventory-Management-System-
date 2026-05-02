@extends('admin.layouts.master')
@section('title', 'تعديل عميل')

@section('content')
    <div class="page-body">
        <div class="container-xl col-lg-10 mx-auto">
            <div class="card shadow-sm mb-4">
                <form action="{{ route('admin.clients.update', $client->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-header">
                        <h3 class="card-title mb-0"><i class="ti ti-edit me-2"></i>تعديل عميل</h3>
                    </div>

                    <div class="card-body">
                        <div class="row row-cards">
                            <!-- الاسم -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">الاسم الكامل</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name',$client->name) }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- الهاتف -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">رقم الهاتف</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone',$client->phone) }}" required>
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- العنوان -->
                            <div class="mb-3">
                                <label class="form-label">العنوان</label>
                                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                       value="{{ old('address',$client->address) }}">
                                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- النوع -->
                            <div class="mb-3">
                                <label class="form-label required">نوع العميل</label>
                                <select name="type" class="form-control @error('type') is-invalid @enderror">
                                    <option value="repair" {{ old('type',$client->type) == 'repair' ? 'selected' : '' }}>صيانه</option>
                                    <option value="purchase" {{ old('type',$client->type) == 'purchase' ? 'selected' : '' }}>شراء</option>
                                </select>
                                @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- عميل جديد -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="new_client" class="form-check-input"
                                    {{ old('new_client',$client->new_client) ? 'checked' : '' }}>
                                <label class="form-check-label ">عميل جديد</label>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-end bg-light">
                        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
