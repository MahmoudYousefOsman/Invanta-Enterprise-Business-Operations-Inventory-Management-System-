@extends('admin.layouts.master')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        {{ __('Edit Settings') }}
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <form action="{{route('admin.setting.update')}}" method="post">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">الاسم</label>
                                    <input type="text" name="settings[name]" class="form-control"
                                           value="{{optional($settings->firstwhere('key' , 'name'))->value}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">رقم الهاتف</label>
                                    <input type="text" name="settings[phone]" class="form-control"
                                           value="{{optional($settings->firstwhere('key' , 'phone'))->value}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">البريد الالكتروني</label>
                                    <input type="email" name="settings[email]" class="form-control"
                                           value="{{optional($settings->firstwhere('key' , 'email'))->value}}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">المدينه</label>
                                    <input type="text" name="settings[city]" class="form-control"
                                           value="{{optional($settings->firstwhere('key' , 'city'))->value}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">العنوان</label>
                                    <input type="text" name="settings[address]" class="form-control"
                                           value="{{optional($settings->firstwhere('key' , 'address'))->value}}">
                                </div>
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label">{{__('facebook')}}</label>
                                <input type="text" name="settings[facebook]" class="form-control"
                                       value="{{optional($settings->firstwhere('key' , 'facebook'))->value}}">
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">YouTube</label>
                                    <input type="text" name="settings[youtube]" class="form-control"
                                           value="{{optional($settings->firstwhere('key' , 'youtube'))->value}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">LinkedIn</label>
                                    <input type="text" name="settings[linkedin]" class="form-control"
                                           value="{{optional($settings->firstwhere('key' , 'linkedin'))->value}}">
                                </div>
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label">Twitter</label>
                                <input type="text" name="settings[twitter]" class="form-control"
                                       value="{{optional($settings->firstwhere('key' , 'twitter'))->value}}">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">حفظ الاعدادات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

