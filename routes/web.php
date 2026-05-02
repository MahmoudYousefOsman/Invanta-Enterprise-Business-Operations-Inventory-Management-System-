<?php

    use App\Http\Controllers\admin\AdminController;
    use App\Http\Controllers\admin\RoleController;
    use App\Http\Controllers\admin\SettingController;
    use App\Http\Middleware\RedirectIfNotAdminMiddleware;
    use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

