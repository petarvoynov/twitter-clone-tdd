<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications->paginate(10);

        return view('notifications.index', compact('notifications'));
    }

    public function update()
    {
        auth()->user()->unreadNotifications()->each(function($notification){
            $notification->markAsRead();
        });

        return back();
    }

    public function unread()
    {
        $unreadNotifications = auth()->user()->unreadNotifications->paginate(10);

        return view('notifications.unread', compact('unreadNotifications'));
    }

    public function read()
    {
        $readNotifications = auth()->user()->readNotifications->paginate(10);

        return view('notifications.read', compact('readNotifications'));
    }
    
    public function destroyAllRead()
    {
        auth()->user()->notifications()->whereNotNull('read_at')->delete();

        return back()->with('success', 'You successfully delete all your read notifications');
    }
}
