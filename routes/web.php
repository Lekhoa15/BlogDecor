<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Pages\TagController;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Pages\PostController;
use App\Http\Controllers\Pages\ReplyController;
use App\Http\Controllers\Pages\AuthorController;
use App\Http\Controllers\Pages\CommentController;
use App\Http\Controllers\Pages\CheckoutController;
use App\Http\Controllers\Stripe\PaymentController;
use App\Http\Controllers\Pages\MembershipController;
use App\Http\Controllers\Dashboard\BillingController;
use App\Http\Controllers\Pages\SubscriptionController;
use App\Http\Controllers\Page1Controller;

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

require 'admin.php';

Route::get('/', HomeController::class)->name('home');
Route::get('/membership', [MembershipController::class, 'index'])->name('membership');
Route::get('/users', [UserController::class, 'index'])->name('users');

Route::get('/payments', [PaymentController::class, 'index'])->name('payments');
Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
Route::get('/payments/card/{plan}', [App\Http\Controllers\Stripe\PaymentController::class, 'payWithCard'])->name('payments.card');
Route::get('/payments/qr/{plan}', [PaymentController::class, 'showQrCode'])->name('payments.qr');
Route::get('/process-payment/{plan}', [PaymentController::class, 'processPayment'])->name('process.payment');


/* Name: subscriptions
 * Url: /subscriptions/*
 * Route: subscriptions.*
*/
Route::group(['prefix' => 'subscriptions', 'as' => 'subscriptions.'], function () {
    Route::get('/resume/{subscription}', [SubscriptionController::class, 'update'])->name('update');
    Route::get('/cancel/{subscription}', [SubscriptionController::class, 'destroy'])->name('destroy');
});

Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/billing/invoices', [BillingController::class, 'index'])->name('billing');
    Route::get('/billing/invoices/{invoice}', [BillingController::class, 'download'])->name('download');
});

/* Name: Authors
 * Url: /authors/*
 * Route: authors.*
*/
Route::group(['prefix' => 'authors', 'as' => 'authors.'], function () {
    Route::get('/', [AuthorController::class, 'index'])->name('index');
    Route::get('/user/{id}', [AuthorController::class, 'show'])->name('show');
});

/* Name: Posts
 * Url: /posts/*
 * Route: posts.*
*/
Route::group(['prefix' => 'posts', 'as' => 'posts.'], function () {
    Route::get('/{post}', [PostController::class, 'show'])->name('show');
});

/* Name: Tags
 * Url: /tags/*
 * Route: tags.*
*/
Route::group(['prefix' => 'tags', 'as' => 'tags.'], function () {
    Route::get('/', [TagController::class, 'index'])->name('index');
    Route::get('/{tag}', [TagController::class, 'show'])->name('show');
});

/* Name: comments
 * Url: /comments/*
 * Route: comments.*
*/
Route::group(['prefix' => 'comments', 'as' => 'comments.'], function () {
    Route::post('/', [CommentController::class, 'store'])->name('store');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::get('/home1', [Page1Controller::class, 'home1']);
Route::get('/about1', [Page1Controller::class, 'about1']);
Route::get('/authors1', [Page1Controller::class, 'authors1']);
Route::get('/membership1', [Page1Controller::class, 'membership1']);

