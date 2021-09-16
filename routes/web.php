<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\UserController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CardController;

use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\OrganizationCrudController;
use App\Http\Controllers\Admin\UserCrudController;
use App\Http\Controllers\Admin\OrganizationTablesCrudController;
use App\Http\Controllers\Admin\OrganizationTableListCrudController;
use App\Http\Controllers\Admin\BookingCrudController;
use Illuminate\Support\Facades\Storage;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization,X-localization,X-No-Cache');

Route::get('/',function() {
    return redirect('/home');
});
//Route::get('/', [MainController::class, 'index'])->name('index');

Route::prefix('form')->group(function() {
    Route::get('/',[MainController::class,'form'])->name('form');
});

Route::prefix('profile')->group(function() {
    Route::get('/',[MainController::class, 'profile'])->name('profile');
    Route::get('settings',[MainController::class, 'profileSettings'])->name('profile.settings');
    Route::get('payments',[MainController::class, 'profilePayments'])->name('profile.payments');
    Route::get('history',[MainController::class, 'profileHistory'])->name('profile.history');
});

Route::prefix('search')->group(function() {
    Route::get('/',[MainController::class,'search'])->name('search');
});

Route::prefix('favorite')->group(function() {
    Route::get('/',[MainController::class, 'favorite'])->name('favorite');
});

Route::prefix('home')->group(function() {
    Route::get('',[MainController::class, 'home'])->name('home');
    Route::get('{slug}',[MainController::class, 'category'])->name('home.category');
    Route::get('{slug}/{id}',[MainController::class, 'getOrganizationById'])->name('home.organization');
});

Route::prefix('politics')->group(function() {
    Route::get('/',[MainController::class,'politics'])->name('politics');
});

Route::prefix('contacts')->group(function() {
    Route::get('/',[MainController::class,'contacts'])->name('contacts');
});

Route::prefix('support')->group(function() {
    Route::get('/',[MainController::class,'support'])->name('support');
});

Route::prefix('news')->group(function() {
    Route::get('/',[MainController::class, 'news'])->name('news');
});

Route::prefix('contacts')->group(function() {
    Route::get('contracts',[ContactController::class,'contracts']);
    Route::get('privacy',[ContactController::class,'privacy']);
});

Route::get('users',[UserCrudController::class, 'list']);
Route::get('tables',[OrganizationTableListCrudController::class,'list']);
Route::get('tables/{id}',[OrganizationTableListCrudController::class,'getBySectionId']);
Route::get('organization',[OrganizationCrudController::class, 'list']);
Route::get('organizationTables',[OrganizationTablesCrudController::class, 'list']);
Route::get('organizationTables/{id}',[OrganizationTablesCrudController::class, 'getByOrganizationId']);
Route::get('lk/{id}',[LinkController::class, 'link']);

Route::get('/queue', function() {
    Artisan::call('queue:work');
    dd('queue work');
});

Route::get('exit',[LoginController::class, 'logout'])->name('exit');

Route::prefix('admin')->group(function () {
    //Route::get('login', [LoginController::class, 'showLoginForm'])->name('backpack.auth.register');
    Route::get('dashboard',[MainController::class, 'dashboard'])->name('dashboard');
    Route::get('dashboard/booking/{id}',[MainController::class, 'dashboardBooking'])->name('dashboard.booking');
    Route::get('entity',[MainController::class,'entity'])->name('entity');
    Route::get('room',[MainController::class,'room'])->name('room');
    Route::get('news_main',[MainController::class,'news_main'])->name('news');
    Route::get('photos',[MainController::class,'photos'])->name('photos');
    Route::get('menus',[MainController::class,'menus'])->name('menus');
    Route::get('statistics',[MainController::class,'statistics'])->name('statistics');
    Route::get('dashboard',[MainController::class,'dashboard'])->name('dashboard');
    Route::get('register',[RegisterController::class, 'showRegistrationForm'])->name('backpack.auth.register');
    Route::post('register',[RegisterController::class, 'register'])->name('backpack.auth.register');
    Route::get('phone_verify',[UserController::class, 'phoneVerify'])->name('phone.verify');
    Route::post('phone_verify',[UserController::class, 'checkPhoneCode'])->name('phone.code');
    Route::get('blocked_user',[UserController::class, 'blockedUser'])->name('user.blocked');
    Route::get('blocked_restricted',[UserController::class, 'restrictedUser'])->name('user.restricted');
    Route::get('booking/status_date/{date}',[BookingCrudController::class, 'bookingStatus']);
    Route::get('booking/status/{id}',[BookingCrudController::class, 'cancel']);
    Route::get('booking/status/came/{id}',[BookingCrudController::class, 'came']);
    Route::get('booking/status/completed/{id}',[BookingCrudController::class, 'completed']);
});

Route::get('form/{bookingId}', [PaymentController::class,'form'])->name('payment.form');

Route::prefix('card')->group(function() {
    Route::get('success', [CardController::class,'success'])->name('success');
});
