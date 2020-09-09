<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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



/**
 * ---------------------------------------------------
 * default routes
 * ---------------------------------------------------
 */
Auth::routes();
Route::redirect('/', '/home');
Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth');


/**
 * ---------------------------------------------------
 * login by social network
 * ---------------------------------------------------
 */
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider')->name('login.social');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('login.callback');


/**
 * ---------------------------------------------------
 * change language
 * ---------------------------------------------------
 */
Route::get('lang/{lang}', 'LanguageController@changeLanguage')->name('language');


/**
 * ---------------------------------------------------
 * activity
 * ---------------------------------------------------
 */
Route::resource('activity', 'ActivityController')->except(['edit', 'show', 'create', 'update', 'store', 'destroy']);
Route::post('activity/process/{type}', 'ActivityController@processRecords')->name('activity.process');
Route::get('activity/details/{activity}', 'ActivityController@showDetails')->name('activity.details');


/**
 * ---------------------------------------------------
 * permission
 * ---------------------------------------------------
 */
Route::get('permission/export/{type}', 'PermissionController@export')->name('permission.export');
Route::resource('permission', 'PermissionController');


/**
 * ---------------------------------------------------
 * Role
 * ---------------------------------------------------
 */
Route::get('role/export/{type}', 'RoleController@export')->name('role.export');
Route::get('role/clone/{id}', 'RoleController@cloneRole')->name('role.clone');
Route::resource('role', 'RoleController');


/**
 * ---------------------------------------------------
 * User
 * ---------------------------------------------------
 */
Route::get('user/export/{type}', 'UserController@export')->name('user.export');
Route::get('user/active/{id}', 'UserController@active')->name('user.active');
Route::get('user/deactive/{id}', 'UserController@deactive')->name('user.deactive');
Route::get('user/profile', 'UserController@profile')->name('user.profile');
Route::put('user/profile/{user}/update', 'UserController@updateProfile')->name('user.profile.update');
Route::get('user/password/{id}', 'UserController@changePassword')->name('user.password.change');
Route::put('user/password/update', 'UserController@storePassword')->name('user.password.store');
Route::resource('user', 'UserController');

/**
 * ---------------------------------------------------
 * Contact
 * ---------------------------------------------------
 */
Route::get('contact', 'ContactController@index')->name('contact.index');
Route::get('contact/{id}', 'ContactController@show')->name('contact.show');

/**
 * ---------------------------------------------------
 * Audit
 * ---------------------------------------------------
 */
Route::resource('audit', 'AuditController')->except(['edit', 'create', 'update', 'store']);

/**
 * ---------------------------------------------------
 * Rotas para a classe Notification
 * ---------------------------------------------------
 */
Route::resource('notification', 'NotificationController')->except(['edit', 'create', 'update', 'store', 'destroy']);
