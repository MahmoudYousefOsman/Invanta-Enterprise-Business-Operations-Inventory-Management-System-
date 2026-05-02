<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\AdminStoreRequest;
use App\Http\Requests\admin\AdminUpdateRequest;
use App\Models\Admin;
use App\Models\Client;
use App\Models\Order;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;


class AdminController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
//        return [
//            new Middleware(PermissionMiddleware::using('admins view'  , 'admin'), only:['index','show']),
//            new Middleware(PermissionMiddleware::using('admins create'  , 'admin'), only:['create','store']),
//            new Middleware(PermissionMiddleware::using('admins edit' , 'admin'), only:['edit','update']),
//            new Middleware(PermissionMiddleware::using('admins delete' , 'admin'), only:['destroy']),
//        ];
    }

    public function index(Request $request): View
    {

        $admins = Admin::paginate(20);
        $permission = Auth::guard("admin")->user();
        $roles = Role::pluck('name')->all();
        return view('admin.admins.index', compact('admins', "permission"));
    }

    public function store(AdminStoreRequest $request): RedirectResponse
    {
        // dd($request->all());
        $data = $request->safe()->only(['name', 'email', 'active', 'profile_pic']);

        $data['active'] = $data['active'] ?? false;

        $data['password'] = Hash::make($request->password);

        if (is_file($request->profile_pic)) {
            $data['profile_pic'] = $request->file('profile_pic')->store('admins', 'public');
        }

        $admin = \App\Models\Admin::create($data);

        $admin->assignRole($request->role);

        notyf()->addSuccess(__('Successfully created.'));

        return redirect()->route('admin.admins.index');
    }

    public function show(String $id)
    {
        $admin = Admin::findOrFail($id);
        $permission = Auth::guard("admin")->user();

        $checkAdmin = ($admin->id !== Auth::guard("admin")->user()->id);

        return view("admin.admins.show", compact("admin", "checkAdmin", "permission"));
    }

    public function edit(\App\Models\Admin $admin)
    {
        $roles = Role::pluck('name')->all();

        $adminRole = $admin->roles->pluck('name')->all();

        return view('admin.admins.edit', compact('admin', 'roles', 'adminRole'));
    }

    public function update(AdminUpdateRequest $request, Admin $admin)
    {
        // dd($request->all());
        $data = $request->safe()->only(['name', 'email', 'active', 'profile_pic']);

        $data['active'] = $data['active'] ?? false;

        if (is_file($request->profile_pic)) {
            if ($admin->profile_pic)
                File::delete(storage_path('app/public/' . $admin->profile_pic));

            $data['profile_pic'] = $request->file("profile_pic")->store('admins', 'public');
        }

        if ($request->has('password') && !empty($request->password))
            $data['password'] = Hash::make($request->password);

        $admin->update($data);

        DB::table('model_has_roles')->where('model_id', $admin->id)->delete();

        $admin->assignRole($request->role);

        notyf()->addSuccess(__('Successfully updated.'));

        if ($request->expectsJson()) {
            return response()->json(['message' => __('Successfully updated.'), 'redirect' => route('admin.admins.index')]);
        }

        return redirect()->route('admin.admins.index');
    }

    public function destroy(Request $request, \App\Models\Admin $admin): RedirectResponse
    {
        if (auth()->guard('admin')->id() == $admin->id) {
            notyf()->addError(__('You can not delete your own account.'));
        } else {
            if ($admin->profile_pic)
                File::delete(storage_path('app/public/' . $admin->profile_pic));

            $admin->delete();

            notyf()->addSuccess(__('Successfully deleted.'));
        }

        return redirect()->route('admin.admins.index');
    }

    public function statistics()
    {
        // 1- كل العملاء
        $allClients = \App\Models\Client::count();

        // 2- كل الأوردرات بناءً على آخر شهر
        $ordersLastMonth = \App\Models\Order::where('created_at', '>=', now()->subMonth())->count();

        // 3- عدد طلبات الصيانة (Tasks) بناءً على آخر شهر
        $tasksLastMonth = \App\Models\Task::where('created_at', '>=', now()->subMonth())->count();

        // 4- عدد العملاء اللي عاملين أوردرات
        $clientsWithOrders = \App\Models\Client::whereHas('orders')->count();

        // 5- عدد العملاء اللي عاملين صيانة (Tasks)
        $clientsWithTasks = \App\Models\Client::whereHas('tasks')->count();

        // 6- تجميع الأوردرات حسب الأيام خلال آخر شهر
        $ordersPerDay = \App\Models\Order::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonth())
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('count', 'date');

        return view('statistics', compact(
            'allClients',
            'ordersLastMonth',
            'tasksLastMonth',
            'clientsWithOrders',
            'clientsWithTasks',
            'ordersPerDay'
        ));
    }

}
