<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\EngineerAuth\LoginController;
use App\Http\Controllers\Admin\EngineerController;
use App\Http\Controllers\Admin\InvoiceReturnController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Middleware\RedirectIfNotAdminMiddleware;
use App\Http\Middleware\RedirectIfNotEngineerMiddleware;
use App\Models\InvoiceReturn;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => [RedirectIfNotAdminMiddleware::class]], function () {
    Route::get('/', [AdminController::class, 'statistics'])->name('dashboard');

    //reports

    Route::get('reports/order/index', [\App\Http\Controllers\Admin\ReportsController::class, 'orderReportIndex'])->name('order.report.index');
    Route::get('reports/order/search', [\App\Http\Controllers\Admin\ReportsController::class, 'orderReport'])->name('order.report.search');
    //return report
    Route::get('reports/return/index', [\App\Http\Controllers\Admin\ReportsController::class, 'returnReportIndex'])->name('return.report.index');
    //purchases report
    Route::get('reports/purchases', [\App\Http\Controllers\Admin\ReportsController::class, 'PurchasesReport'])->name('purchases.report');
    //task report
    Route::get('reports/task', [\App\Http\Controllers\Admin\ReportsController::class, 'TaskReport'])->name('task.report');
    //general report
    Route::get('general/report', [\App\Http\Controllers\Admin\ReportsController::class, 'generalReport'])->name('general.report');

    //////////////
    Route::get('/notifications/{id}/redirect', [NotificationController::class, 'redirect'])->name('notifications.redirect');
    Route::resource('admins', AdminController::class);
    Route::get('setting/index', [SettingController::class, 'index'])->name('setting.index');
    Route::post('setting/update', [SettingController::class, 'update'])->name('setting.update');
    Route::resource('roles', RoleController::class);
    Route::resource('task', TaskController::class);
    Route::resource('engineers', EngineerController::class);
    Route::get('engineer_transactions', [EngineerController::class, 'engineer_transactions'])->name('engineer_transactions');
    Route::resource('clients', ClientController::class);
    Route::get('clients/choose/form', [ClientController::class, 'chooseForm'])->name('clients.choose.form');
    Route::resource('product', ProductController::class);
    Route::get('products/movements', [ProductController::class, 'movements'])->name('products.movements');
    Route::get('products/iphone/create', [ProductController::class, 'create'])->name('products.iphone.create');
    Route::get('products/iphone/index', [ProductController::class, 'index'])->name('products.iphone.index');
    Route::get('products/iphone/lowStock', [ProductController::class, 'lowStock'])->name('products.iphone.lowStock');
    Route::get('products/maintenance/index', [ProductController::class, 'index'])->name('products.maintenance.index');
    Route::get('products/maintenance/lowStock', [ProductController::class, 'lowStock'])->name('products.maintenance.lowStock');
    Route::get('products/maintenance/createProductMaintenance', [ProductController::class, 'createProductMaintenance'])->name('products.maintenance.createProductMaintenance');
    Route::get('print/barcode', [ProductController::class, 'generateBarrCode'])->name('print.barcode');
    Route::get('generate/items/barcode', [ProductController::class, 'generateItemsBarrCode'])->name('generate.items.barcode');
    Route::get('print/items/barcode', [ProductController::class, 'printItemsBarcode'])->name('print.items.barcode');

    Route::get('task/print/{id}', [TaskController::class, 'print'])->name('task.print');

    Route::get('order/print/{id}', function ($id) {
        $order = \App\Models\Order::with(['client', 'products', 'orderDetails'])->findOrFail($id);
        return view('admin.orders.print_page.order_recete', compact('order'));
    })->name('order.print');

    Route::get('products/lowstock', [ProductController::class, 'lowStock'])->name('products.lowStock');
    Route::get('client/movements', [ClientController::class, 'movements'])->name('client.movements');
    Route::resource('orders', OrderController::class);
    Route::resource('purchases', PurchaseController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::get('supplier_transactions', [SupplierController::class, 'supplier_transactions'])->name('supplier_transactions');
    Route::post('/suppliers/settle', [SupplierController::class, 'settle'])->name('suppliers.settle');
    Route::get('categories', [CategoryController::class, 'indexDataTable'])->name('categories.index');
    Route::resource('categories', CategoryController::class)->except(['index']);
    Route::get('get-subcategories/{id}', [CategoryController::class, 'getSubCategories'])->name('categories.getSubcategories');
    Route::resource('invoice_return', InvoiceReturnController::class);
    Route::get('create/supplier/products', [SupplierController::class, 'createProductSupplier'])->name('create.supplier.products');
    Route::post('store/supplier/products', [SupplierController::class, 'storeSupplierProducts'])->name('store.supplier.products');
    Route::get('store/supplier/products', [SupplierController::class, 'supplier_product_index'])->name('index.supplier.products');
    Route::get('search/supplier/stocks', [SupplierController::class, 'searchStock'])->name('search.supplier.products');

});

Route::middleware('guest')->group(function () {
    Route::get('engineer/login', [LoginController::class, 'showLoginForm'])->name('engineer.login');
    Route::post('engineer/login', [LoginController::class, 'login'])->name('engineer.login.submit');
});
Route::group(['middleware' => [RedirectIfNotEngineerMiddleware::class]], function () {
    Route::post('engineer/logout', [LoginController::class, 'logout'])->name('engineer.logout');
    Route::get('engineer/tasks', [EngineerController::class, 'engineerTasks'])->name('engineer.tasks');
    Route::get('engineer/task/details/{task}', [EngineerController::class, 'engineerTaskDetails'])->name('engineer.task.details');
    Route::post('task/item/store/{task}', [TaskController::class, 'taskItemStore'])->name('engineer.task.item.store');
    Route::post('update/status/{task}', [TaskController::class, 'updateStatus'])->name('engineer.task.updateStatus');
    Route::get('engineer/account', [EngineerController::class, 'account'])->name('engineers.account');
});


require __DIR__ . '/admin_auth.php';
