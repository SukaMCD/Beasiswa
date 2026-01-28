<?php

use App\Http\Controllers\Auth\ManualAuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Articles;

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
Route::get('/products', function () {
    $products = Product::orderByDesc('created_at')->paginate(12);
    return view('products', compact('products'));
})->name('products');

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
});
