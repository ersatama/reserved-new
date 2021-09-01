<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrganizationController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\TelegramController;
use App\Http\Controllers\Api\TelegramChatController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\OrganizationTableListController;
use App\Http\Controllers\Api\OrganizationTableController;
use App\Http\Controllers\Api\OrganizationRequestController;
use App\Http\Controllers\Api\OrganizationImageController;
use App\Http\Controllers\Api\WebTrafficController;

Route::prefix('webTraffic')->group(function() {

    Route::post('create',[WebTrafficController::class,'create'])->name('webTraffic.create');

    Route::get('organization/{organizationId}',[WebTrafficController::class,'getByOrganizationId'])->name('webTraffic.organization');
    Route::get('organization/{organizationId}/{date}',[WebTrafficController::class,'getByOrganizationIdAndDate'])->name('webTraffic.organizationDate');
    Route::get('date/{date}/{organizationId}/{ip}/{website}',[WebTrafficController::class,'getByDateAndOrganizationIdAndIp'])->name('webTraffic.dateOrganizationIp');
    Route::get('dateBetween/{start}/{end}/{organizationId}',[WebTrafficController::class,'getByBetweenDateAndOrganizationId'])->name('webTraffic.organizationBetweenDate');

});

Route::prefix('organizationRequest')->group(function() {

    Route::post('create',[OrganizationRequestController::class,'create'])->name('organizationRequest.create');
    Route::get('phone/{phone}',[OrganizationRequestController::class,'getByPhone'])->name('organizationRequest.phone');

});

Route::prefix('section')->group(function() {

    Route::get('organization/{organizationId}',[OrganizationTableController::class,'getByOrganizationId'])->name('section.organization');
    Route::post('create',[OrganizationTableController::class,'create'])->name('section.name');
    Route::post('update/{id}',[OrganizationTableController::class,'update'])->name('section.update');

});

Route::prefix('table')->group(function() {

    Route::post('array',[OrganizationTableListController::class,'array'])->name('table.array');
    Route::post('create',[OrganizationTableListController::class,'create'])->name('table.create');
    Route::post('update/{id}',[OrganizationTableListController::class,'update'])->name('table.update');

    Route::get('id/{id}',[OrganizationTableListController::class,'getById'])->name('table.id');
    Route::get('table/{tableId}',[OrganizationTableListController::class,'getByTableId'])->name('table.table');
    Route::get('organization/{organizationId}',[OrganizationTableListController::class,'getByOrganizationId'])->name('table.organization');

});

Route::prefix('image')->group(function() {

    Route::post('create',[OrganizationImageController::class,'create'])->name('image.create');
    Route::post('update/{id}',[OrganizationImageController::class,'update'])->name('image.update');

    Route::get('organization/{organizationId}',[OrganizationImageController::class,'getByOrganizationId'])->name('image.organization');

});

Route::prefix('menu')->group(function() {

    Route::post('update/{id}',[MenuController::class,'update'])->name('menu.update');
    Route::post('create',[MenuController::class,'create'])->name('menu.create');

    Route::get('list/{organizationId}',[MenuController::class,'getByOrganizationId'])->name('menu.organization.id');

});

Route::prefix('telegram')->group(function() {

    Route::post('webhook/{id}',[TelegramChatController::class,'create'])->name('telegram_chat.create');
    Route::post('update/{id}',[TelegramController::class,'update'])->name('telegram.update');

    Route::get('user/{userId}',[TelegramController::class,'getByUserId'])->name('telegram.user.id');
    Route::get('id/{id}',[TelegramController::class,'getById'])->name('telegram.id');

});

Route::prefix('telegram_chat')->group(function() {

    Route::post('create/{id}',[TelegramChatController::class,'create'])->name('telegram_chat.create');
    Route::post('update/{id}',[TelegramChatController::class,'update'])->name('telegram_chat.update');

});

Route::prefix('card')->group(function() {

    Route::post('post/booking/{id}',[CardController::class,'booking'])->name('card.booking');
    Route::post('post',[CardController::class,'create'])->name('card.post');
    Route::post('update/{id}',[CardController::class,'update'])->name('card.update');

    Route::get('id/{id}',[CardController::class,'getById'])->name('card.id');
    Route::get('user/{userId}',[CardController::class,'getByUserId'])->name('card.user');

});

Route::prefix('booking')->group(function() {

    Route::post('guest',[BookingController::class,'guest'])->name('booking.guest');
    Route::post('create',[BookingController::class,'create'])->name('booking.create');
    Route::post('update/{id}',[BookingController::class,'update'])->name('booking.update');
    Route::post('card',[BookingController::class,'card'])->name('booking.card');
    Route::post('ids/{date}',[BookingController::class,'ids'])->name('booking.ids');

    Route::get('id/{id}',[BookingController::class,'getById'])->name('booking.id');
    Route::get('user/{userId}',[BookingController::class,'getByUserId'])->name('booking.user');
    Route::get('organization/{organizationId}',[BookingController::class,'getByOrganizationId'])->name('booking.organization');
    Route::get('table/{tableId}',[BookingController::class,'getByTableId'])->name('booking.table');
    Route::get('date/{date}',[BookingController::class,'getByDate'])->name('booking.date');
    Route::get('completed/{userId}',[BookingController::class,'getCompletedByUserId'])->name('booking.status.user');
    Route::get('dateBetween/{start}/{end}/{organizationId}',[BookingController::class,'getByBetweenDateAndOrganizationId'])->name('booking.organizationBetweenDate');

});

Route::prefix('payment')->group(function() {

    Route::post('card/result',[PaymentController::class,'cardResult'])->name('payment.card.result');
    Route::post('result',[PaymentController::class,'result']);

    Route::get('card/result',[PaymentController::class,'cardResult'])->name('payment.card.result');
    Route::get('card/{id}',[PaymentController::class,'card'])->name('payment.card.user');

});

Route::prefix('contacts')->group(function() {
    Route::get('contracts',[ContactController::class,'contracts'])->name('contacts.contracts');
    Route::get('privacy',[ContactController::class,'privacy'])->name('contacts.privacy');
});

Route::prefix('review')->group(function () {

    Route::post('create',[ReviewController::class,'create'])->name('review.create');
    Route::post('update/{id}',[ReviewController::class,'update']);

    Route::get('delete/{id}',[ReviewController::class,'delete']);
    Route::get('count/organization/{organizationId}',[ReviewController::class,'getCountByOrganizationId']);
    Route::get('list/organization/{id}/{paginate}',[ReviewController::class,'getByOrganizationId']);
    Route::get('list/user/{id}',[ReviewController::class,'getByUserId']);
    Route::get('group/{organizationId}',[ReviewController::class,'getGroupByOrganizationId'])->name('group.organizationId');

});

Route::prefix('organization')->group(function() {

    Route::post('update/{id}',[OrganizationController::class,'update'])->name('organization.update');
    Route::get('status/{id}/{date}',[OrganizationController::class,'status'])->name('organization.status');
    Route::post('ids',[OrganizationController::class,'getByIds'])->name('organization.ids');
    Route::get('section/{id}',[OrganizationController::class,'getSectionsById']);
    Route::get('{id}',[OrganizationController::class,'getById']);
    Route::get('user/{userId}',[OrganizationController::class,'getByUserId'])->name('organization.getByUserId');

});

Route::prefix('user')->group(function() {

    Route::post('update/{id}',[UserController::class,'update'])->name('user.update');
    Route::post('reset/{id}',[UserController::class,'resetPassword'])->name('user.reset.password');
    Route::post('password/{id}',[UserController::class,'updatePassword'])->name('user.update.password');
    Route::post('booking',[UserController::class,'booking'])->name('user.booking');
    Route::post('new',[UserController::class,'guest'])->name('user.guest');
    Route::post('token/{token}',[UserController::class,'authToken'])->name('user.authToken');

    Route::get('phone/{phone}',[UserController::class,'getByPhone'])->name('user.phone');
    Route::get('{id}',[UserController::class,'getById'])->name('user.id');

});

Route::prefix('category')->group(function() {
    Route::get('list',[CategoryController::class,'list'])->name('category.list');
    Route::get('slug/{slug}',[CategoryController::class,'getBySlug'])->name('category.slug');
});

Route::get('/categories',[CategoryController::class,'list']);
Route::get('countries',[CountryController::class,'list']);

Route::get('/organizations',[OrganizationController::class,'list']);
Route::get('/organizations/{search}',[OrganizationController::class,'search']);


Route::prefix('category')->group(function() {
    Route::get('organizations/{id}',[OrganizationController::class,'getByCategoryId']);
    Route::get('organizations/{id}/{cityId}',[OrganizationController::class,'getByCategoryIdAndCityId']);
});

Route::prefix('languages')->group(function() {
    Route::get('list',[LanguageController::class ,'list'])->name('languages.list');
});

Route::prefix('sms')->group(function() {
    Route::get('reset/{phone}',[UserController::class,'smsResend']);
    Route::get('{phone}/{code}',[UserController::class,'smsVerify']);

});

Route::get('/sms_resend/{phone}',[UserController::class,'smsResend']);
Route::get('/login/{phone}/{password}',[UserController::class,'login']);
Route::get('/register',[UserController::class,'register']);
Route::post('/register',[UserController::class,'register']);

Route::get('/token/{token}', [UserController::class,'token']);
Route::post('/token/{token}', [UserController::class,'token']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
