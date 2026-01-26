<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Services\XenditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\Cart;

class PaymentController extends Controller
{
    protected $xenditService;

    public function __construct(XenditService $xenditService)
    {
        $this->xenditService = $xenditService;
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $cart = Cart::where('id_user', $user->id_user)->first();

        if (!$cart) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        $cartItems = $cart->items()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->jumlah * $item->harga_satuan;
        }

        // PPN 11%
        $ppn = $subtotal * 0.11;
        $total = $subtotal + $ppn;

        // Create External ID
        $externalId = 'INV-' . time() . '-' . Str::random(5);
        $description = 'Payment for Order ' . $externalId;
        $payerEmail = $user->email ?? 'customer@example.com';

        \Illuminate\Support\Facades\Log::info('Initiating Xendit Payment', [
            'user_id' => $user->id_user,
            'amount' => $total,
            'key_exists' => !empty(config('services.xendit.key'))
        ]);

        try {
            // Updated: Redirect to History/Invoice page on success (simulated by Xendit return)
            // But strict Xendit flow sends callback. For simplicity in this demo,
            // we will create the Order record IMMEDIATELY before redirecting.

            // 1. Create Order
            $order = \App\Models\Order::create([
                'id_user' => $user->id_user,
                'external_id' => $externalId,
                'total_amount' => $total,
                'payment_status' => 'PENDING', // In real app, update this via Webhook
                'payment_url' => null // filled below
            ]);

            // 2. Move Cart Items to Order Items
            foreach ($cartItems as $item) {
                \App\Models\OrderItem::create([
                    'id_order' => $order->id_order,
                    'id_produk' => $item->id_produk,
                    'nama_produk' => $item->product->nama_produk,
                    'harga_satuan' => $item->harga_satuan,
                    'jumlah' => $item->jumlah,
                    'subtotal' => $item->jumlah * $item->harga_satuan
                ]);
            }

            // 3. Request Payment URL
            $invoice = $this->xenditService->createInvoice(
                $externalId,
                $total,
                $payerEmail,
                $description,
                route('history.index') . '?status=success' // Redirect to History
            );

            // Update Payment URL
            $order->update(['payment_url' => $invoice['invoice_url']]);

            // 4. Clear Cart
            \App\Models\CartItem::where('id_keranjang', $cart->id_keranjang)->delete();

            return response()->json([
                'invoice_url' => $invoice['invoice_url'],
                'external_id' => $externalId
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Xendit Payment Failed: ' . $e->getMessage());
            return response()->json(['message' => 'Payment creation failed: ' . $e->getMessage()], 500);
        }
    }
}
