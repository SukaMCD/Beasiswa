<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\User;
use App\Notifications\FcmOrderNotification;
use App\Notifications\FcmShippingStatusNotification;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        // Notify Admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $notification = new FcmOrderNotification($order);
            $admin->notify($notification);
            $notification->sendFcm($admin);
        }
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        // Notify User if shipping_status changed
        if ($order->isDirty('shipping_status')) {
            $user = $order->user;
            if ($user) {
                $notification = new FcmShippingStatusNotification($order);
                $user->notify($notification);
                $notification->sendFcm($user);
            }
        }
    }
}
