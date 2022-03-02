<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/flutterwave', [PaymentController::class, 'index'])->name(
    'flutterwave'
);
Route::post('/flutterwave/payment', [PaymentController::class, 'store'])->name(
    'flutterwave.payment'
);
Route::get('/flutterwave/callback', [
    PaymentController::class,
    'callback',
])->name('flutterwave-callback');

Route::get('/home', [
    App\Http\Controllers\HomeController::class,
    'index',
])->name('home');

Route::get('/admin/home', [AdminController::class, 'adminHome'])
    ->name('admin.home')
    ->middleware('utype');

Route::get('/verify', function () {
    return view('auth.verify');
})->name('verify');
Route::post('/verify', [
    App\Http\Controllers\Auth\RegisterController::class,
    'verify',
])->name('verify');

Route::post('/something', [
    App\Http\Controllers\Auth\RegisterController::class,
    'something',
])->name('something');

Route::get('/sendsms', [
    App\Http\Controllers\SMSController::class,
    'index',
])->name('sendsms');

Route::get('/pays', function () {
    return view('pay');
});

// The route that the button calls to initialize payment
Route::post('/pay', [App\Http\Controllers\FlutterwaveController::class, 'initialize'])->name('pay');
// The callback url after a payment
Route::get('/rave/callback', [App\Http\Controllers\FlutterwaveController::class, 'callback'])->name('callback');

Route::get('/wallet/{id}/balance', [App\Http\Controllers\FlutterwaveController::class, 'balance'])->name('balance');