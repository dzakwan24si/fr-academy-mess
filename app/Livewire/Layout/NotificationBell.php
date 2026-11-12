<?php

namespace App\Livewire\Layout;

use Livewire\Component;

class NotificationBell extends Component
{
    public function markAsRead($notificationId, $url)
    {
        $user = auth()->user();
        if ($user) {
            $notification = $user->notifications()->find($notificationId);
            
            if ($notification) {
                $notification->markAsRead();
            }
        }

        return redirect($url);
    }

    public function markAllAsRead()
    {
        $user = auth()->user();
        if ($user) {
            $user->unreadNotifications()->update(['read_at' => now()]);
        }
    }

    public function render()
    {
        $user = auth()->user();

        return view('livewire.layout.notification-bell', [
            'notifications' => $user ? $user->notifications()->take(10)->get() : collect(),
            'unreadCount' => $user ? $user->unreadNotifications()->count() : 0
        ]);
    }
}
