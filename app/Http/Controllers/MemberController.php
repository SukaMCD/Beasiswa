<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PointsTransaction;

class MemberController extends Controller
{
    public function qr()
    {
        $user = Auth::user();

        // QR Content: JSON with UserID and Expiry (4 mins)
        $data = json_encode([
            'id' => $user->id_user,
            'valid_until' => now()->addMinutes(4)->timestamp
        ]);

        // Using public API for QR generation since local library failed
        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($data);

        return view('member.qr', compact('user', 'qrUrl'));
    }

    public function reward()
    {
        $products = Product::orderByDesc('created_at')->get();
        return view('reward', compact('products'));
    }

    public function claimReward(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id_produk',
            'qty' => 'nullable|integer|min:1',
        ]);
        $product = Product::findOrFail($request->id);
        $qty = max(1, (int) ($request->qty ?? 1));
        $pointsPerItem = 1000;
        $pointsRequired = $pointsPerItem * $qty;
        $user = Auth::user();
        $userPoints = $user->points ?? 0;
        return view('claimreward', compact('product', 'qty', 'pointsPerItem', 'pointsRequired', 'userPoints'));
    }

    public function checkoutReward(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:products,id_produk',
            'qty' => 'required|integer|min:1',
        ]);
        $user = Auth::user();
        $product = Product::findOrFail($request->id_produk);
        $qty = (int) $request->qty;
        // Use configurable point price per product (default handled at DB)
        $pointsPerItem = (int) ($product->point_price ?? 1000);
        // Validate stock availability
        if (($product->stok ?? 0) < $qty) {
            return back()->withErrors(['points' => 'Stok produk tidak mencukupi'])->withInput();
        }
        $totalPoints = $pointsPerItem * $qty;
        $currentPoints = $user->points ?? 0;
        if ($currentPoints < $totalPoints) {
            return back()->withErrors(['points' => 'Poin tidak mencukupi untuk klaim reward ini'])->withInput();
        }
        // Deduct points
        $user->points = $currentPoints - $totalPoints;
        $user->save();

        // Decrement product stock
        $product->stok = max(0, ($product->stok ?? 0) - $qty);
        $product->save();

        // Create order record (marked as PAID, total_amount 0 for reward claims)
        $order = Order::create([
            'id_user' => $user->id_user,
            'external_id' => 'RW-' . strtoupper(uniqid()),
            'total_amount' => 0,
            'payment_status' => 'PAID',
            'payment_url' => null,
        ]);

        // Create item
        OrderItem::create([
            'id_order' => $order->id_order,
            'id_produk' => $product->id_produk,
            'nama_produk' => $product->nama_produk . ' (Reward)',
            'harga_satuan' => 0,
            'jumlah' => $qty,
            'subtotal' => 0,
        ]);

        // Log points OUT transaction
        PointsTransaction::create([
            'id_user' => $user->id_user,
            'type' => 'OUT',
            'points' => $totalPoints,
            'description' => 'Klaim reward: ' . $product->nama_produk . ' x ' . $qty,
        ]);

        return redirect()->route('history.index')->with('status', 'Reward berhasil diklaim dan masuk Riwayat.');
    }
}
