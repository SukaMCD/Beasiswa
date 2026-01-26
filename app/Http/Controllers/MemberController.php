<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
