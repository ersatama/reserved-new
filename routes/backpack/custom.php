<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController');
    Route::crud('city', 'CityCrudController');
    Route::crud('country', 'CountryCrudController');
    Route::crud('category', 'CategoryCrudController');
    Route::crud('organization', 'OrganizationCrudController');
    Route::crud('booking', 'BookingCrudController');
    Route::crud('review', 'ReviewCrudController');
    Route::crud('organizationimage', 'OrganizationImageCrudController');
    Route::crud('organizationtables', 'OrganizationTablesCrudController');
    Route::crud('organizationtablelist', 'OrganizationTableListCrudController');
    Route::crud('contracts', 'ContractsCrudController');
    Route::crud('privacy', 'PrivacyCrudController');
    Route::crud('languages', 'LanguagesCrudController');
    Route::crud('iiko', 'IikoCrudController');
    Route::crud('iikotables', 'IikoTablesCrudController');
    Route::crud('iikotablelist', 'IikoTableListCrudController');
    Route::crud('telegram', 'TelegramCrudController');
    Route::crud('menu', 'MenuCrudController');
    Route::crud('organizationrequest', 'OrganizationRequestCrudController');
}); // this should be the absolute last line of this file