<?php

namespace Boravel\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;

class NotificationsController extends Controller
{
    public function unread()
    {
        if (Auth::user()->notification_count > 0 && Auth::user()->message_count == 0) {
            return redirect()->route('notifications.index');
        }
        return redirect()->route('messages.index');
    }

    public function index()
    {
        $notifications = Auth::user()->notifications();
        Auth::user()->notification_count = 0;
        Auth::user()->save();

        return view('notifications.index', compact('notifications'));
    }

    public function count()
    {
        return Auth::user()->notification_count + Auth::user()->message_count;
    }
}