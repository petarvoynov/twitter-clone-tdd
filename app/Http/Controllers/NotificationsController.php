<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications;

        return view('notifications.index', compact('notifications'));
    }

    public function unread()
    {
        $unreadNotifications = auth()->user()->unreadNotifications;

        return view('notifications.unread', compact('unreadNotifications'));
    }

    public function read()
    {
        $readNotifications = auth()->user()->readNotifications;

        return view('notifications.read', compact('readNotifications'));
    }
}
