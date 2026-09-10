<?php

namespace App\Livewire\Layout;

use Livewire\Component;

class NotificationBell extends Component
{
    public function markAsRead($notificationId, $url)
    {
        $notification = auth()->user()->notifications()->find($notificationId);
        
        if ($notification) {
            $notification->markAsRead();
        }

        return redirect($url);
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
    }

    public function render()
    {
        return view('livewire.layout.notification-bell', [
            'notifications' => auth()->user()->notifications()->take(10)->get(),
            'unreadCount' => auth()->user()->unreadNotifications->count()
        ]);
    }
}
