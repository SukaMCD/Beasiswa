<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class HistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('id_user', $user->id_user)
            ->with('items')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('history', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items')->where('id_user', Auth::user()->id_user)->findOrFail($id);
        return view('invoice', compact('order'));
    }

    public function download($id)
    {
        $order = Order::with('items')->where('id_user', Auth::user()->id_user)->findOrFail($id);

        $pdf = Pdf::loadView('invoice', compact('order'));
        return $pdf->download('invoice-' . $order->external_id . '.pdf');
    }
}
