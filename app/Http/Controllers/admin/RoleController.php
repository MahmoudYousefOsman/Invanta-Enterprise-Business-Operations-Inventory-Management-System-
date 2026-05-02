<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\admin\RoleRequest;
use Illuminate\Http\Request;
use App\DataTables\RoleDataTable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Middleware\PermissionMiddleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
//        return [
//            new Middleware(PermissionMiddleware::using('role view'  , 'admin'), only:['index','show']),
//            new Middleware(PermissionMiddleware::using('role create'  , 'admin'), only:['create','store']),
//            new Middleware(PermissionMiddleware::using('role edit' , 'admin'), only:['edit','update']),
//            new Middleware(PermissionMiddleware::using('role delete' , 'admin'), only:['destroy']),
//        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(RoleDataTable $dataTable)
    {
        $permissions = Permission::all();
        $permissionUser = Auth::guard("admin")->user();

        return $dataTable->render('admin.role.index', compact('permissions', 'permissionUser'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $data = $request->validated();
        $role = Role::create(['name' => $data['name'] , 'guard_name' => 'admin']);
        $permissionNames = Permission::whereIn('id', $data['permissions'])
            ->pluck('name')
            ->toArray();

        $role->syncPermissions($permissionNames);
        notyf()->addSuccess('Created Successfully');
        return redirect()->route('admin.roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::get();
        return view('admin.role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {
        $data = $request->validated();

        $role->name = $data['name'];
        $role->save();

        $permissionNames = Permission::whereIn('id', $data['permissions'])
            ->pluck('name')
            ->toArray();
        $role->syncPermissions($permissionNames);
        notyf()->addSuccess('Updated Successfully');

        return redirect()->route('admin.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id', $id)->delete();
        notyf()->addSuccess('Deleted Successfully');
        return redirect()->route('admin.roles.index');
    }
}
