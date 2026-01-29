<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handleXendit(Request $request)
    {
        // 1. Verify Token
        $reqToken = $request->header('x-callback-token');
        $myToken = config('services.xendit.webhook_token'); // Add this to .env later if needed, or simple check

        // For now, we will log payload for debugging
        Log::info('Xendit Webhook Received', $request->all());

        // 2. Parse Data
        // Use 'id' matching 'external_id'
        $externalId = $request->external_id;
        $status = $request->status;

        if ($status === 'PAID') {
            $order = Order::where('external_id', $externalId)->first();

            if ($order) {
                // Calculate total fees
                $fees = 0;
                if (isset($request->fees) && is_array($request->fees)) {
                    foreach ($request->fees as $fee) {
                        $fees += $fee['value'];
                    }
                }

                $order->update([
                    'payment_status' => 'PAID',
                    'admin_fee' => $fees,
                    'payment_channel' => $request->bank_code ?? $request->payment_method ?? 'Xendit',
                    'paid_at' => now()
                ]);

                // Add Points: 10 points per Rp 1,000 (1% of total)
                $user = \App\Models\User::where('id_user', $order->id_user)->first();
                if ($user) {
                    $pointsToAdd = (int) floor(((float) $order->total_amount) / 100);
                    $user->increment('points', $pointsToAdd);

                    // Log points IN transaction
                    \App\Models\PointsTransaction::create([
                        'id_user' => $user->id_user,
                        'type' => 'IN',
                        'points' => $pointsToAdd,
                        'description' => 'Pembelian produk: ' . $order->external_id,
                    ]);

                    Log::info("Added {$pointsToAdd} points to user {$user->id_user}");
                }

                Log::info("Order {$externalId} updated to PAID. Fee: {$fees}");
            } else {
                Log::warning("Order {$externalId} not found.");
            }
        }

        return response()->json(['message' => 'ok']);
    }
}
