<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingRequest;
use App\Models\Setting;

class SettingController extends Controller
{
//    public static function middleware()
//    {
//        return [
//            new Middleware(PermissionMiddleware::using('setting view'  , 'admin'), only:['index','show']),
//            new Middleware(PermissionMiddleware::using('setting edit' , 'admin'), only:['edit','update']),
//        ];
//    }
    public function index()
    {
        $settings = Setting::all();
        return view('admin.settings.index' , compact('settings'));
    }

    public function update(UpdateSettingRequest $request)
    {
        foreach ($request->validated()['settings'] as $key => $value) {
            Setting::updateOrCreate([
                'key' => $key
            ], [
                'value' => trim($value)
            ]);
        }
        if(isset($request['latitude']) && $request['latitude'] != null){
            Setting::updateOrCreate([
                'key' => 'latitude',
            ],[
                'value' => $request['latitude']
            ]);
        }
        if(isset($request['longitude']) && $request['longitude'] != null){
            Setting::updateOrCreate([
                'key' => 'longitude',
            ],[
                'value' => $request['longitude']
            ]);
        }
        notyf()->addSuccess(__('Successfully updated.'));
        return redirect()->route('admin.setting.index');
    }
}
