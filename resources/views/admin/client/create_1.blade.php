@extends('admin.layouts.master')
@section('title', 'اختيار نوع العميل')

@section('content')
    <div class="page-body pt-lg-6" style="min-height: 100vh;">
        <div class="container pt-lg-6">
            <div class="row justify-content-center g-4 pt-lg-6">

                <!-- كارد عميل صيانة -->
                <div class="col-md-4 pt-lg-6">
                    <form action="{{ route('admin.clients.choose.form') }}" method="get" id="form-repair">
                        <input type="hidden" name="type" value="repair">
                        <div class="card shadow-lg text-center card-hover clickable-card card-yellow" data-form="form-repair">
                            <div class="card-body">
                                <h3 class="card-title">عميل صيانة</h3>
                                <p class="text-black">إضافة عميل لخدمات الصيانة</p>
                                <label class="form-check form-switch mt-3 text-start">
                                    <input class="form-check-input" type="checkbox" name="new_client" value="1">
                                    <span class="form-check-label">عميل جديد</span>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- كارد عميل شراء -->
                <div class="col-md-4 pt-lg-6">
                    <form action="{{ route('admin.clients.choose.form') }}" method="get" id="form-purchase">
                        <input type="hidden" name="type" value="purchase">
                        <div class="card shadow-lg text-center card-hover clickable-card card-blue" data-form="form-purchase">
                            <div class="card-body">
                                <h3 class="card-title">عميل شراء</h3>
                                <p class="text-white">إضافة عميل جديد لشراء المنتجات</p>
                                <label class="form-check form-switch mt-3 text-start">
                                    <input class="form-check-input" type="checkbox" name="new_client" value="1">
                                    <span class="form-check-label">عميل جديد</span>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <style>
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }
        .card-hover:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        /* الأزرق */
        .card-blue {
            background: linear-gradient(135deg, #007bff, #3399ff);
            color: #fff;
        }

        /* الأصفر */
        .card-yellow {
            background: linear-gradient(135deg, #ffc107, #ffdd57);
            color: #333;
        }

        /* تعديل شكل الـ switch عشان يبان */
        .card-blue .form-check-input:checked {
            background-color: #333;
            border-color: #333;
        }
        .card-yellow .form-check-input:checked {
            background-color: #333;
            border-color: #333;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.clickable-card').forEach(card => {
                card.addEventListener('click', function (e) {
                    if (!e.target.classList.contains('form-check-input')) {
                        let formId = this.getAttribute('data-form');
                        document.getElementById(formId).submit();
                    }
                });
            });
        });
    </script>
@endsection
