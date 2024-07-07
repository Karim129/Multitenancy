<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResgisterTenent;
use Illuminate\Support\Facades\Route;

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {

        Route::get('/', function () {
            return view('welcome');
        });

        Route::get('/dashboard', function () {
            return view('tenants.dashboard');
        })->middleware(['auth', 'verified'])->name('dashboard');

        Route::middleware('auth')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
            Route::resource('tenants', ResgisterTenent::class);

        });
        require __DIR__ . '/centralAuth.php';
// php artisan queue:work --queue=high,notification
// php artisan subscription:SubscriptionExpireNotification
// php artisan queue:work --queue=high,notification
    });
}
