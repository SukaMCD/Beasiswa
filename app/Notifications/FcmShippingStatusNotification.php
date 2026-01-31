<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;

class FcmShippingStatusNotification extends Notification
{
    use Queueable;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Status Pengiriman Berubah',
            'body' => "Pesanan Anda #{$this->order->external_id} sekarang berstatus: {$this->order->shipping_status}",
            'order_id' => $this->order->id_order,
        ];
    }

    /**
     * Custom method to send FCM manually.
     */
    public function sendFcm($notifiable)
    {
        $tokens = $notifiable->fcmTokens()->pluck('fcm_token')->toArray();

        if (empty($tokens)) {
            return;
        }

        $messaging = Firebase::messaging();

        $message = CloudMessage::new()
            ->withData([
                'title' => 'Status Pengiriman Berubah',
                'body' => "Pesanan Anda #{$this->order->external_id} sekarang berstatus: {$this->order->shipping_status}",
                'order_id' => (string) $this->order->id_order,
                'click_action' => '/history/' . $this->order->id_order,
                'icon' => '/images/kedai-cendana-rounded.webp'
            ]);

        $messaging->sendMulticast($message, $tokens);
    }
}
