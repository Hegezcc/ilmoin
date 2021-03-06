<?php

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

// Developer/testing helper routes

if (config('app.debug')) {
    Route::prefix('debug')->group(function () {
        Route::get('login/{user}', function (App\Users\User $user) {
            Auth::login($user);
            return redirect('/');
        });
    });
}

Route::view('/', 'welcome')->name('home');

Route::get('auth/mattermost', 'Auth\MattermostAuthController@login')->name('login');
Route::get('auth/mattermost/callback', 'Auth\MattermostAuthController@callback');
Route::post('logout', 'Auth\MattermostAuthController@logout')->name('logout');

Route::get('organizations', 'Organizations\OrganizationController@index')->name('organizations.index');
Route::get('organizations/{organization}', 'Organizations\OrganizationController@show')->name('organizations.show');
Route::get('events/{event}', 'Organizations\Event\EventController@show')->name('events.show');

Route::middleware('auth')->group(function () {
    Route::get('events/{event}/register', 'Organizations\Event\EventController@showRegistrationForm')->name('events.register');
    Route::post('events/{event}/register', 'Organizations\Event\EventController@processRegistration');

    Route::get('events/{event}/confirm', 'Organizations\Event\EventController@showConfirmForm')->name('events.confirm');
    Route::post('events/{event}/confirm', 'Organizations\Event\EventController@processConfirm');

    Route::get('events/{event}/cancel', 'Organizations\Event\EventController@showCancelForm')->name('events.cancel');
    Route::post('events/{event}/cancel', 'Organizations\Event\EventController@processCancel');
});

Route::get('groups/{group}', 'Organizations\OrganizationGroupController@show')->name('groups.show');

Route::middleware('auth')->group(function () {
    Route::get('groups/{group}/join', 'Organizations\OrganizationGroupInviteController@join')->name('groups.join');
});

Route::middleware('auth')->group(function () {
    Route::get('user/{user}', 'User\UserController@show')->name('user.view');

    Route::get('self/settings/email', 'User\SettingsController@showEmailSettings')->name('settings.email');
});

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('organizations/create', 'Organizations\OrganizationAdminController@create')->name('admin.organizations.create');
    Route::post('organizations/create', 'Organizations\OrganizationAdminController@store')->name('admin.organizations.store');

    Route::get('organizations/edit/{organization}', 'Organizations\OrganizationAdminController@edit')->name('admin.organizations.edit');
    Route::post('organizations/edit/{organization}', 'Organizations\OrganizationAdminController@update')->name('admin.organizations.update');

    Route::get('groups/create', 'Organizations\OrganizationGroupAdminController@create')->name('admin.groups.create');
    Route::post('groups/create', 'Organizations\OrganizationGroupAdminController@store')->name('admin.groups.store');

    Route::get('groups/edit/{group}', 'Organizations\OrganizationGroupAdminController@edit')->name('admin.groups.edit');
    Route::post('groups/edit/{group}', 'Organizations\OrganizationGroupAdminController@update')->name('admin.groups.update');

    Route::get('groups/invite', 'Organizations\OrganizationGroupInviteController@createInvites')->name('admin.group.invites.create');
    Route::post('groups/invite', 'Organizations\OrganizationGroupInviteController@storeInvites')->name('admin.group.invites.store');

    Route::get('events/create', 'Organizations\Event\EventAdminController@create')->name('admin.events.create');
    Route::post('events/create', 'Organizations\Event\EventAdminController@store')->name('admin.events.store');

    Route::get('events/edit/{event}', 'Organizations\Event\EventAdminController@edit')->name('admin.events.edit');
    Route::post('events/edit/{event}', 'Organizations\Event\EventAdminController@update')->name('admin.events.update');

    Route::get('events/regopts/create/{event}', 'Organizations\Event\EventAdminController@createRegistrationOption')->name('admin.events.regopts.create');
    Route::post('events/regopts/create/{event}', 'Organizations\Event\EventAdminController@storeRegistrationOption')->name('admin.events.regopts.store');

    Route::get('events/regopts/edit/{option}', 'Organizations\Event\EventAdminController@editRegistrationOption')->name('admin.events.regopts.edit');
    Route::post('events/regopts/edit/{option}', 'Organizations\Event\EventAdminController@updateRegistrationOption')->name('admin.events.regopts.update');
});
