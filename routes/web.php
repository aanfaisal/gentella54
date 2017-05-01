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

/**
 * Routing Otentifikasi
 */
Route::group(['namespace' => 'Auth'], function () {

	Route::get('login', 'LoginController@showLoginForm')->name('login');
	Route::post('login', 'LoginController@login');
	Route::get('logout', 'LoginController@logout')->name('logout');

	// Routing User Register...
	if (config('auth.users.registration')) {
		Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
		Route::post('register', 'RegisterController@register');
	}

	// Routing Password Reset...
	Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
	Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
	Route::post('password/reset', 'ResetPasswordController@reset');

	// Routing Konfirmasi...
	if (config('auth.users.confirm_email')) {
		Route::get('confirm/{user_by_code}', 'ConfirmController@confirm')->name('confirm');
		Route::get('confirm/resend/{user_by_email}', 'ConfirmController@sendEmail')->name('confirm.send');
	}

	// Routing Akun Social...
	Route::get('social/redirect/{provider}', 'SocialLoginController@redirect')->name('social.redirect');
	Route::get('social/login/{provider}', 'SocialLoginController@login')->name('social.login');
});

/**
 * Routing Backend
 */

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {

	// Dashboard
	Route::get('/', 'DashboardController@index')->name('dashboard');

	//Users
	Route::get('users', 'UserController@index')->name('users');
	Route::get('users/{user}', 'UserController@show')->name('users.show');
	Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit');
	Route::put('users/{user}', 'UserController@update')->name('users.update');
	Route::delete('users/{user}', 'UserController@destroy')->name('users.destroy');
});

/**
 *
 *Routing Frontend
 */
Route::get('/', function () {
	return view('welcome');
});

Route::get('/home', 'HomeController@index');
