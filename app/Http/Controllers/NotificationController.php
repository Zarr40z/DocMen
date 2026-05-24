<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where(
            'user_id',
            auth()->id()
        )->latest()->get();

        return view(
            'notifications.index',
            compact('notifications')
        );
    }

    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);

        $notification->delete();

        return redirect()->back();
    }

    public function deleteAll()
    {
        Notification::where(
            'user_id',
            auth()->id()
        )->delete();

        return redirect()->back();
    }
}
