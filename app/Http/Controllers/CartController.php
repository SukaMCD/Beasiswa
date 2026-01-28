<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cart = Cart::firstOrCreate(['id_user' => $user->id_user]);
        $cartItems = $cart->items()->with('product')->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->jumlah * $item->harga_satuan;
        });

        $ppnRate = 0.11; // 11% PPN
        $ppn = $subtotal * $ppnRate;
        $total = $subtotal + $ppn;

        return view('cart', compact('cartItems', 'subtotal', 'ppn', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:products,id_produk',
            'jumlah' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $cart = Cart::firstOrCreate(['id_user' => $user->id_user]);
        $product = Product::findOrFail($request->id_produk);

        $cartItem = $cart->items()->where('id_produk', $product->id_produk)->first();

        if ($cartItem) {
            $cartItem->increment('jumlah', $request->jumlah);
        } else {
            $cart->items()->create([
                'id_produk' => $product->id_produk,
                'jumlah' => $request->jumlah,
                'harga_satuan' => $product->harga,
            ]);
        }

        return response()->json(['message' => 'Produk berhasil ditambahkan ke keranjang!']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_item' => 'required|exists:cart_items,id_item',
            'action' => 'required|in:increase,decrease',
        ]);

        $cartItem = CartItem::findOrFail($request->id_item);

        if ($request->action === 'increase') {
            $cartItem->increment('jumlah');
        } else {
            if ($cartItem->jumlah > 1) {
                $cartItem->decrement('jumlah');
            } else {
                $cartItem->delete();
                return $this->getCartResponse('Item dihapus dari keranjang', true);
            }
        }

        return $this->getCartResponse('Jumlah berhasil diperbarui');
    }

    public function updateNote(Request $request)
    {
        $request->validate([
            'id_item' => 'required|exists:cart_items,id_item',
            'note' => 'nullable|string|max:500',
        ]);

        $cartItem = CartItem::findOrFail($request->id_item);
        $cartItem->update(['note' => $request->note]);

        return response()->json(['message' => 'Catatan berhasil disimpan']);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'id_item' => 'required|exists:cart_items,id_item',
        ]);

        CartItem::destroy($request->id_item);

        return $this->getCartResponse('Item berhasil dihapus');
    }

    private function getCartResponse($message, $removed = false)
    {
        $user = Auth::user();
        $cart = Cart::where('id_user', $user->id_user)->first();
        $cartItems = $cart ? $cart->items : collect();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->jumlah * $item->harga_satuan;
        });

        $ppnRate = 0.11;
        $ppn = $subtotal * $ppnRate;
        $total = $subtotal + $ppn;

        return response()->json([
            'message' => $message,
            'removed' => $removed,
            'subtotal' => number_format($subtotal, 0, ',', '.'),
            'ppn' => number_format($ppn, 0, ',', '.'),
            'total' => number_format($total, 0, ',', '.'),
            'item_subtotal' => $cartItems->mapWithKeys(function ($item) {
                return [$item->id_item => number_format($item->jumlah * $item->harga_satuan, 0, ',', '.')];
            }),
            'cart_count' => $cartItems->count(),
            'is_empty' => $cartItems->isEmpty()
        ]);
    }
}
