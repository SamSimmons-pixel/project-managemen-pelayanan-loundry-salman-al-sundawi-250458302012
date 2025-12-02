<?php


use App\Livewire\User\Game;
use App\Livewire\Auth\Login;
use App\Livewire\User\Promo;
use App\Livewire\User\Pickup;
use App\Livewire\User\Review;
use App\Livewire\User\Invoice;
use App\Livewire\User\Machine;
use App\Livewire\User\Payment;
use App\Livewire\Admin\Reviews;
use App\Livewire\Auth\Register;

use App\Livewire\Admin\Analytics;
use App\Livewire\Admin\Customers;
use App\Livewire\User\PlaceOrder;
use App\Livewire\Admin\Promotions;
use App\Livewire\Admin\UpdateOrder;
use App\Livewire\Admin\BranchAdmins;
use App\Livewire\User\OrderTracking;
use App\Livewire\User\UserDashboard;
use App\Livewire\Admin\MachineRental;


use App\Livewire\User\ServicePackage;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\OrderManagement;
use App\Livewire\Admin\ServicePackages;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MidtransController;
use App\Livewire\Admin\BranchAdminDashboard;
use App\Livewire\Admin\Dashboard as AdminDashboard;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/pickup/{orderId}', Pickup::class)->name('pickup');
// above should be home i guess

Route::prefix('auth')->group(function () {
    Route::get('/login', Login::class)->name('login');

    Route::get('/signup', Register::class)->name('signup');

    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});


// Admin only access
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', AdminDashboard::class)->name('admin.dashboard');

    Route::get('/branch-admins', BranchAdmins::class)->name('admin.branch-admins');
    Route::get('/update-order/{orderId}', UpdateOrder::class)->name('admin.update-order');
    Route::get('/service-packages', ServicePackages::class)->name('admin.service-packages');
    Route::get('/customers', Customers::class)->name('admin.customers');
    Route::get('/analytics', Analytics::class)->name('admin.analytics');
    Route::get('/reviews', \App\Livewire\Admin\AdminReviews::class)->name('admin.reviews');
});

// Branch Admin only access
Route::prefix('branch-admin')->middleware('auth')->group(function () {
    Route::get('/order-management', OrderManagement::class)->name('branch-admin.order-management');
    Route::get('/dashboard', BranchAdminDashboard::class)->name('branch-admin.dashboard');
    Route::get('/machine-rental', MachineRental::class)->name('branch-admin.machine-rental');
    Route::get('/reviews', Reviews::class)->name('branch-admin.reviews');
    Route::get('/promotions', Promotions::class)->name('branch-admin.promotions');
    Route::get('/analytics', \App\Livewire\Admin\BranchAnalytics::class)->name('branch-admin.analytics');
});

// User only access
Route::prefix('user')->middleware('auth')->group(function () {
    Route::get('/', UserDashboard::class)->name('user.menu');
    Route::get('/game', Game::class)->name('user.game');
    Route::get('/invoice', Invoice::class)->name('user.invoice');
    Route::get('/invoice/{order}', [InvoiceController::class, 'show'])->name('user.invoice.show');
    Route::get('/machine', Machine::class)->name('user.machine');
    Route::get('/track-order', OrderTracking::class)->name('user.track-order');
    Route::get('/place-order', PlaceOrder::class)->name('user.place-order');
    Route::get('/promo', Promo::class)->name('user.promo');
    Route::get('/review', Review::class)->name('user.review');
    Route::get('/payment/{orderId}', Payment::class)->name('user.payment');
    Route::post('/midtrans/cancel/{orderId}', [MidtransController::class, 'cancelTransaction'])->name('midtrans.cancel');
});

Route::post('/midtrans/notification', [MidtransController::class, 'notificationHandler']);

Route::post('/midtrans/check-status/{order}', [MidtransController::class, 'checkAndUpdateStatus'])->name('midtrans.check_status');

Route::post('/midtrans/webhook', [MidtransController::class, 'notificationHandler'])->name('midtrans.webhook');

Route::post('/user/track-order', [MidtransController::class, 'notificationHandler'])->name('user.track-order')->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/checkout', [MidtransController::class, 'store']);
});
