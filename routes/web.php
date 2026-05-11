<?php

    use App\Http\Controllers\Admin\AdminController;
    use App\Http\Controllers\Admin\RoleController;
    use App\Http\Controllers\Admin\SettingController;
    use App\Http\Middleware\RedirectIfNotAdminMiddleware;
    use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

