<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function redirect($id)
    {
        $notification = auth('admin')->user()
            ->notifications()
            ->findOrFail($id);

        // علم الإشعار كمقروء
        if ($notification->unread()) {
            $notification->markAsRead();
        }

        // رجّع للرابط اللي جاي من الإشعار
        return redirect($notification->data['url'] ?? route('admin.dashboard'));
    }


}
