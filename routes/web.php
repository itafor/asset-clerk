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

Route::get('/', 'HomeController@index');
Auth::routes();
Route::get('login/{provider}', 'SocialController@redirect');
Route::get('login/{provider}/callback','SocialController@Callback');

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	//Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);

	Route::resource('subs', 'SubAccountController', ['except' => ['show']]);

	//Route::prefix('agents')->middleware('role:agent')->group(function(){
		Route::prefix('asset')->group(function(){
			Route::get('/', 'AssetController@index')->name('asset.index');
			Route::get('/my', 'AssetController@myAssets')->name('asset.my');
			Route::get('/create', 'AssetController@create')->name('asset.create');
			Route::post('/store', 'AssetController@store')->name('asset.store');
			Route::get('/edit/{uuid}', 'AssetController@edit')->name('asset.edit');
			Route::post('/update', 'AssetController@update')->name('asset.update');
			Route::post('/assign', 'AssetController@assign')->name('asset.assign');
			Route::get('/delete/{uuid}', 'AssetController@delete')->name('asset.delete');
			Route::get('/delete-unit/{id}', 'AssetController@deleteUnit')->name('asset.delete.unit');
			Route::get('/delete-service/{id}', 'AssetController@deleteService')->name('asset.delete.service');
			Route::post('/add-service-charge', 'AssetController@addServiceCharge')->name('asset.service.add');
			Route::post('/add-unit', 'AssetController@addUnit')->name('asset.unit.add');
			Route::get('/service-charges', 'AssetController@serviceCharges')->name('service.charges');
			Route::get('/delete-image/{id}', 'AssetController@deleteImage')->name('asset.delete.image');
		});
		Route::prefix('tenant')->group(function(){
			Route::get('/', 'TenantController@index')->name('tenant.index');
			Route::get('/create', 'TenantController@create')->name('tenant.create');
			Route::post('/store', 'TenantController@store')->name('tenant.store');
			Route::get('/edit/{uuid}', 'TenantController@edit')->name('tenant.edit');
			Route::post('/update', 'TenantController@update')->name('tenant.update');
			Route::get('/delete/{uuid}', 'TenantController@delete')->name('tenant.delete');
		});
		Route::prefix('customer')->group(function(){
			Route::get('/', 'CustomerController@index')->name('customer.index');
			Route::get('/create', 'CustomerController@create')->name('customer.create');
			Route::post('/store', 'CustomerController@store')->name('customer.store');
		});
		Route::prefix('landlord')->group(function(){
			Route::get('/', 'LandlordController@index')->name('landlord.index');
			Route::get('/create', 'LandlordController@create')->name('landlord.create');
			Route::post('/store', 'LandlordController@store')->name('landlord.store');
			Route::get('/edit/{uuid}', 'LandlordController@edit')->name('landlord.edit');
			Route::post('/update', 'LandlordController@update')->name('landlord.update');
			Route::get('/delete/{uuid}', 'LandlordController@delete')->name('landlord.delete');
		});
		Route::prefix('rental')->group(function(){
			Route::get('/', 'RentalController@index')->name('rental.index');
			Route::get('/create', 'RentalController@create')->name('rental.create');
			Route::post('/store', 'RentalController@store')->name('rental.store');
			Route::get('/approvals', 'RentalController@approvals')->name('rental.approvals');
			Route::get('/delete/{uuid}', 'RentalController@delete')->name('rental.delete');
		});
		Route::prefix('maintenance')->group(function(){
			Route::get('/', 'MaintenanceController@index')->name('maintenance.index');
			Route::get('/create', 'MaintenanceController@create')->name('maintenance.create');
			Route::post('/store', 'MaintenanceController@store')->name('maintenance.store');
			Route::get('/edit/{uuid}', 'MaintenanceController@edit')->name('maintenance.edit');
			Route::post('/update', 'MaintenanceController@update')->name('maintenance.update');
			Route::get('/delete/{uuid}', 'MaintenanceController@delete')->name('maintenance.delete');
		});
		Route::prefix('debt')->group(function(){
			Route::get('/', 'DebtController@debt')->name('debt.debt');
			Route::get('/payment', 'DebtController@payment')->name('debt.payment');
		});
	//});	

	Route::prefix('tenant')->group(function(){
		Route::get('my-profile', 'TenantController@myProfile')->name('tenant.myProfile');
		Route::get('my-rent', 'TenantController@myRent')->name('tenant.myRent');
		Route::get('my-referals', 'TenantController@referals')->name('tenant.referals');
		Route::get('my-maintenance', 'TenantController@myMaintenance')->name('tenant.maintenance');
		Route::get('create-maintenance', 'TenantController@createMaintenance')->name('tenant.maintenance.create');
	});

	Route::prefix('report')->group(function(){
		Route::get('assets', 'ReportController@assets')->name('report.assets');
		Route::get('payments', 'ReportController@payments')->name('report.payments');
		Route::get('approvals', 'ReportController@approvals')->name('report.approvals');
		Route::get('maintenance', 'ReportController@maintenance')->name('report.maintenance');
		Route::get('legal', 'ReportController@legal')->name('report.legal');
	});

	

	Route::get('fetch-states/{country}', 'UtilsController@fetchState');
	Route::get('fetch-cities/{state}', 'UtilsController@fetchCity');
	Route::get('fetch-assets/{category}', 'UtilsController@fetchAssets');
	Route::get('fetch-units/{property}', 'UtilsController@fetchUnits');
	Route::get('fetch-service-charge/{type}', 'UtilsController@fetchServiceCharge');
	Route::get('search-users', 'UtilsController@searchUsers');
	Route::get('verification', 'UtilsController@resendVerification')->name('verification');
	Route::get('verify/{email}/{token}', 'UtilsController@verify');
});

