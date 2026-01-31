<?php

use App\Http\Controllers\Auth\ManualAuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Articles;

// Sitemap
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index']);

// Homepage
Route::get('/', function () {
    $products = Product::orderByDesc('created_at')->take(4)->get();
    return view('homepage', compact('products'));
})->name('homepage');

// Artikel
Route::get('/articles', function () {
    $articles = Articles::where('status', 'published')
        ->orderByDesc('created_at')
        ->take(9)
        ->get();
    return view('articles', compact('articles'));
})->name('articles');

// Products page
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products');

// Reviews
Route::get('/reviews', function () {
    return view('reviews');
})->name('reviews');

// Rute untuk otentikasi
Route::prefix('auth')->group(function () {

    // Rute Login Manual
    Route::get('login', [ManualAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [ManualAuthController::class, 'login']);

    // Rute Registrasi Manual
    Route::get('register', [ManualAuthController::class, 'showRegister'])->name('register');
    Route::post('register', [ManualAuthController::class, 'register']);

    // Rute Login Google
    Route::get('redirect', [SocialiteController::class, 'redirect'])->name('socialite.redirect');
    Route::get('google/callback', [SocialiteController::class, 'callback'])->name('socialite.callback');
});

Route::prefix('password')->group(function () {
    // Tampilkan form permintaan reset password
    Route::get('request', [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'create'])->name('password.request');

    // Proses pengiriman email reset password
    Route::post('email', [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])->name('password.email');

    // Tampilkan form untuk mereset password baru
    Route::get('reset/{token}', [App\Http\Controllers\Auth\NewPasswordController::class, 'create'])->name('password.reset');

    // Proses reset password baru
    Route::post('reset', [App\Http\Controllers\Auth\NewPasswordController::class, 'store'])->name('password.store');
});

// Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Cart Routes
Route::middleware('auth')->group(function () {
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/update-note', [App\Http\Controllers\CartController::class, 'updateNote'])->name('cart.updateNote');
    Route::post('/cart/remove', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/payment/checkout', [App\Http\Controllers\PaymentController::class, 'checkout'])->name('payment.checkout');

    // History & Invoice
    Route::get('/history', [App\Http\Controllers\HistoryController::class, 'index'])->name('history.index');
    Route::get('/history/{id}', [App\Http\Controllers\HistoryController::class, 'show'])->name('history.show');
    Route::get('/history/{id}/download', [App\Http\Controllers\HistoryController::class, 'download'])->name('history.download');

    // Reward
    Route::get('/reward', [App\Http\Controllers\MemberController::class, 'reward'])->name('reward.index');
    Route::get('/reward/claim', [App\Http\Controllers\MemberController::class, 'claimReward'])->name('reward.claim');
    Route::post('/reward/checkout', [App\Http\Controllers\MemberController::class, 'checkoutReward'])->name('reward.checkout');

    // Profile
    Route::post('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    // FCM Subscriptions
    Route::get('/firebase-config.js', function () {
        $config = [
            'apiKey' => env('FIREBASE_API_KEY'),
            'authDomain' => env('FIREBASE_AUTH_DOMAIN'),
            'projectId' => env('FIREBASE_PROJECT_ID'),
            'storageBucket' => env('FIREBASE_STORAGE_BUCKET'),
            'messagingSenderId' => env('FIREBASE_MESSAGING_SENDER_ID'),
            'appId' => env('FIREBASE_APP_ID'),
            'vapidKey' => env('FIREBASE_VAPID_KEY'),
        ];

        $js = "self.firebaseConfig = " . json_encode($config) . ";";
        return response($js, 200)->header('Content-Type', 'application/javascript');
    })->name('firebase.config');

    Route::post('/notifications/subscribe', function (Request $request) {
        $request->validate([
            'fcm_token' => 'required|string',
            'device_type' => 'nullable|string|in:web,android,ios',
        ]);

        $user = $request->user();
        $user->fcmTokens()->updateOrCreate(
            ['fcm_token' => $request->fcm_token],
            [
                'device_type' => $request->device_type ?? 'web',
                'last_used_at' => now(),
            ]
        );

        return response()->json(['success' => true]);
    })->name('notifications.subscribe');
});
