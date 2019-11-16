<?php

use App\Jobs\RentalCreatedEmailJob;
use App\TenantRent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
    Route::get('upgrade', ['as' => 'profile.upgrade', 'uses' => 'SubscriptionsController@subscribe'])->middleware('sub.account');;
    Route::get('buy-plan/{plan}', ['as' => 'buy.plan', 'uses' => 'SubscriptionsController@buy_plan'])->middleware('sub.account');;
    

        Route::post('buy-plan', ['as' => 'do.buy.plan', 'uses' => 'SubscriptionsController@redirectToGateway'])->middleware('sub.account');;

	Route::resource('subs', 'SubAccountController', ['except' => ['show', 'index']])->middleware('sub.account');
	Route::get('subs', 'SubAccountController@index')->name('subs.index');


    Route::prefix('transactions')->group(function(){
    Route::get('payment/callback', 'SubscriptionsController@handleGatewayCallback')->name('payment.callback');

    Route::get('my-subscriptions', ['as' => 'subscription.history', 'uses' => 'SubscriptionsController@history']);
    Route::get('my-transactions', ['as' => 'transactions.history', 'uses' => 'SubscriptionsController@transactions']);

    });
    Route::prefix('subscription_plans')->group(function(){
        Route::get('/', ['as' => 'plan.index', 'uses' => 'AdminController@subscription_plans']);
        Route::get('add_subscription_plan', ['as' => 'plan.add', 'uses' => 'AdminController@create_subscription_plan']);
        Route::post('add_subscription_plan', ['as' => 'plan.save', 'uses' => 'AdminController@save_subscription_plan']);
        Route::get('transactions', ['as' => 'plan.transactions', 'uses' => 'AdminController@transactions']);
        Route::get('subscribers', ['as' => 'plan.subscribers', 'uses' => 'AdminController@subscribers']);
    });
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
			Route::get('/tenants-service-charge/{id}', 'AssetController@tenantsServiceCharge')->name('asset.tenants.service');

			Route::get('/get-tenants-service-charge/{id}', 'AssetController@getTenantsServiceCharge')->name('get.tenants.service');

			Route::post('/new-service-charge', 'AssetController@add_Service_Charge')->name('addserviceCharge');
			Route::get('/create-service-charge', 'AssetController@createServiceCharge')->name('asset.service.create');

			Route::get('/remove-from-service-charge/{sc_id}/{tenant_id}', 'AssetController@removeTenantFromCS')->name('remove.tenant.from.sc');

		  Route::get('/edit-service-charge/{id}', 'AssetController@editServiceCharge')->name('asset.service.charge.edit');

		   Route::get('/view-service-charge/{id}', 'AssetController@AssetServiceCharges')->name('asset.servicecharges');

		 Route::post('/update-service-charge', 'AssetController@updateServiceCharge')->name('asset.service.charge.update');

		 Route::get('/get-asset-location/{asset_id}', 'AssetController@getAssetLocation')->name('getAssetLocation');

		Route::post('/service-charges', 'AssetController@search_Service_Charge')->name('search.service.charge');
			
			Route::post('/add-unit', 'AssetController@addUnit')->name('asset.unit.add');
			Route::get('/service-charges', 'AssetController@serviceCharges')->name('service.charges');
			Route::get('/delete-image/{id}', 'AssetController@deleteImage')->name('asset.delete.image');
		});

			Route::prefix('service-charge')->group(function(){
			Route::get('/debtors', 'AssetServiceChargeController@getDebtors')->name('debtors.get');
			Route::get('/pay-service-chatge', 'AssetServiceChargeController@payServiveCharge')->name('pay.service.charge');
			Route::post('/pay-service-chatge', 'AssetServiceChargeController@storeServiveChargePaymentHistory')->name('store.service.charge.payment.history');
			Route::get('/fetch-tenant-service-charge/{id}', 'AssetServiceChargeController@getTenantServiceCharge')->name('fetch.tenant.service.charge');

			Route::get('/fetch-service-charge-amount/{id}/{tenantId}', 'AssetServiceChargeController@getServiceChargeAmount')->name('fetch.service.charge.amount');

			Route::get('/service-charge-payment-histories', 'AssetServiceChargeController@getServiveChargePaymentHistory')->name('fetch.service.charge.payment.history');
		});

			
			Route::prefix('wallet')->group(function(){
			Route::get('/', 'WalletController@index')->name('wallet.index');
			Route::get('/fetch-tenant-balance/{tenant_id}', 'WalletController@fetchBalance')->name('wallet.balance');
			Route::get('/tenants-wallets', 'WalletController@fetchTenantWallet')->name('tenant.wallet');
			Route::get('/wallet-history', 'WalletController@fetchWalletHistory')->name('wallet.history');
			Route::post('/fund-wallet', 'WalletController@fundWallet')->name('wallet.fund');

			Route::get('/tenant-wallet-balance/{tenant_id}', 'WalletController@getTenantWalletForPayment')->name('tenant.wallet.balance');
		});

		Route::prefix('tenant')->group(function(){
			Route::get('/', 'TenantController@index')->name('tenant.index');
			Route::get('/create', 'TenantController@create')->name('tenant.create');
			Route::post('/store', 'TenantController@store')->name('tenant.store');
			Route::get('/edit/{uuid}', 'TenantController@edit')->name('tenant.edit');
			Route::post('/update', 'TenantController@update')->name('tenant.update');
			Route::get('/delete/{uuid}', 'TenantController@delete')->name('tenant.delete');
			Route::get('/profile-details/{id}', 'TenantController@tenantProfile')->name('tenant.profile');
			Route::get('/search/tenant', 'TenantController@searchTenantGlobally')->name('search.tenant');
			Route::get('update-doc-name/{docId}/{docname}','TenantController@editDocumentName')->name('update.docname');
		Route::get('delete-document/{docId}','TenantController@deleteDocument')->name('delete.doc');
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
			Route::get('/my', 'RentalController@myRentals')->name('rental.my');
			Route::get('/create', 'RentalController@create')->name('rental.create');
			Route::get('/edit-rental/{uuid}', 'RentalController@edit')->name('rental.edit');
			Route::post('/update-rental', 'RentalController@update')->name('rental.update');
			Route::get('/pay-rent/{uuid}', 'RentalController@rentPayment')->name('rental.pay');
			Route::post('/store', 'RentalController@store')->name('rental.store');
			Route::get('/approvals', 'RentalController@approvals')->name('rental.approvals');
			Route::get('/yes-renew-rental/{uuid}', 'RentalController@yesRenewRent')->name('renewable.yes');
			Route::get('/no-renew-rental/{uuid}', 'RentalController@noRenewRent')->name('renewable.no');
			Route::get('/delete/{uuid}', 'RentalController@delete')->name('rental.delete');
			Route::get('/view-detail/{uuid}', 'RentalController@viewDetail')->name('rental.view.detail');
			Route::get('notify-due-rent', 'RentalController@notifyDueRent');
		});

		Route::prefix('rent-payment')->group(function(){
			Route::get('/pay-rent/{uuid}', 'RentPaymentController@create')->name('rentalPayment.create');
			Route::get('/rental-payment-history', 'RentPaymentController@fetchRentalPaymentHistory')->name('rentalPayment.history');
		    Route::get('/rental-debtors', 'RentPaymentController@fetchRentalDebtors')->name('rentalPayment.debtors');
			Route::post('/store-rent-payment', 'RentPaymentController@store')->name('rentalPayment.store');

			Route::get('payment-record/{uuid}', 'RentPaymentController@viewPaymentRecord')->name('rent-payment.payment.record');
			
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
		});
		Route::prefix('payment')->group(function(){
			Route::get('/', 'PaymentController@index')->name('payment.index');
			Route::get('/create', 'PaymentController@create')->name('payment.create');
			Route::post('/store', 'PaymentController@store')->name('payment.store');
			Route::get('/edit/{uuid}', 'PaymentController@edit')->name('payment.edit');
			Route::post('/update', 'PaymentController@update')->name('payment.update');
			Route::get('delete/{uuid}', 'PaymentController@delete')->name('payment.delete');
		});
	//});	

	Route::prefix('tenant')->group(function(){
		Route::get('my-profile', 'TenantController@myProfile')->name('tenant.myProfile');
		Route::get('my-rent', 'TenantController@myRent')->name('tenant.myRent');
		Route::get('my-referals', 'TenantController@referals')->name('tenant.referals');
		Route::get('my-maintenance', 'TenantController@myMaintenance')->name('tenant.maintenance');
		Route::get('create-maintenance', 'TenantController@createMaintenance')->name('tenant.maintenance.create');
		Route::get('fetch-tenants/{id}', 'TenantController@fetchTeanatThatBelongsToAnAsset')->name('fetch.tenants');

		Route::get('/get-tenant-email/{id}','TenantController@getTenantEmail')->name('tenant.email');
		
	});

	Route::prefix('report')->group(function(){
		Route::get('assets', 'ReportController@assets')->name('report.assets');

		Route::get('get-asset-occupancy/{asset_id}/{occupancy}', 'ReportController@occupancy')->name('report.occupancy');
		Route::get('get-payment-status/{unit_uuud}/', 'ReportController@rentalPaymentStatus')->name('report.payment.status');

		Route::get('get-asset-payment/{asset_id}/{paymentstatus}', 'ReportController@asset_payment')->name('report.asset_payment');


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
	Route::get('fetch-service-charge-by-property/{property}', 'UtilsController@fetchServiceChargeByProperty');
	Route::get('search-users', 'UtilsController@searchUsers');
	Route::get('verification', 'UtilsController@resendVerification')->name('verification');
	Route::get('verify/{email}/{token}', 'UtilsController@verify');
	Route::get('fetch-rented-units/{property}', 'UtilsController@fetchRentedUnits');
	Route::get('fetch-tenant-asset/{tenant}', 'UtilsController@fetchTenantAsset');
});

Route::get('run-cron-job',function(){
$newRentals = DB::table('tenant_rents')
         ->select('tenant_rents.*', DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),tenant_rents.due_date) AS remaingdays'))
         ->where('renewable', 'yes')
        ->whereRaw('ABS(TIMESTAMPDIFF(DAY, CURDATE(),tenant_rents.due_date )) = ABS(TIMESTAMPDIFF(DAY, tenant_rents.startDate,tenant_rents.due_date ) * (25/100) )') 
        ->get();
        //dd($newRentals);
     foreach($newRentals as $rental) {

    $newRentDetails['tenant']    = $rental->tenant_uuid;
    $newRentDetails['property']  = $rental->asset_uuid;
    $newRentDetails['unit']      = $rental->unit_uuid;
    $newRentDetails['price']     = $rental->price;
    $newRentDetails['amount']    = $rental->amount;
    $newRentDetails['startDate'] = Carbon::now()->format('d/m/Y');
    $newRentDetails['due_date'] = Carbon::now()->addYear()->format('d/m/Y');
    $newRentDetails['user_id']    = $rental->user_id;
    $newRentDetails['new_rental_status'] = 'New';

            if(!empty($newRentDetails)){

                DB::beginTransaction();
        try {
            $rental = TenantRent::createNew($newRentDetails);

            RentalCreatedEmailJob::dispatch($rental)
            ->delay(now()->addSeconds(5));
                         
            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
            return false;
            }

        }
    }
    });
