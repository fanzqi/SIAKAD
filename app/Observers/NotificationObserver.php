<?php

namespace App\Observers;

use App\Models\Notification;
use App\Models\User;

class NotificationObserver
{
    public function created(Notification $notification)
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->notifications()->syncWithoutDetaching([
                $notification->id => ['is_read' => 0]
            ]);
        }
    }
}
