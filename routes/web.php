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

Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);

	Route::prefix('agents')->group(function(){

		Route::prefix('asset')->group(function(){
			Route::get('/', 'AssetController@index')->name('asset.index');
			Route::get('/create', 'AssetController@create')->name('asset.create');
			Route::post('/store', 'AssetController@store')->name('asset.store');
		});
		Route::prefix('tenant')->group(function(){
			Route::get('/', 'TenantController@index')->name('tenant.index');
			Route::get('/create', 'TenantController@create')->name('tenant.create');
			Route::post('/store', 'TenantController@store')->name('tenant.store');
		});
		Route::prefix('landlord')->group(function(){
			Route::get('/', 'LandlordController@index')->name('landlord.index');
			Route::get('/create', 'LandlordController@create')->name('landlord.create');
			Route::post('/store', 'LandlordController@store')->name('landlord.store');
		});
		Route::prefix('rental')->group(function(){
			Route::get('/', 'RentalController@index')->name('rental.index');
			Route::get('/create', 'RentalController@create')->name('rental.create');
			Route::post('/store', 'RentalController@store')->name('rental.store');
		});
		Route::prefix('maintenance')->group(function(){
			Route::get('/', 'MaintenanceController@index')->name('maintenance.index');
			Route::get('/create', 'MaintenanceController@create')->name('maintenance.create');
			Route::post('/store', 'MaintenanceController@store')->name('maintenance.store');
		});
		Route::prefix('debt')->group(function(){
			Route::get('/', 'DebtController@debt')->name('debt.debt');
			Route::get('/payment', 'DebtController@payment')->name('debt.payment');
		});

	});	

	Route::get('fetch-states/{country}', 'UtilsController@fetchState');
	Route::get('fetch-cities/{state}', 'UtilsController@fetchCity');
});

