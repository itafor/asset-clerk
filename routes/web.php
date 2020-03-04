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
Route::get('upgrade', ['as' => 'profile.upgrade', 'uses' => 'SubscriptionsController@subscribe'])->middleware('sub.account');;
Route::get('buy-plan/{plan}', ['as' => 'buy.plan', 'uses' => 'SubscriptionsController@buy_plan'])->middleware('sub.account');

Route::get('create',['as'=>'companydetail.create', 'uses'=>'ProfileController@createCompanyDetail']);
Route::post('store-company-detail',['as'=>'companydetail.store', 'uses'=>'ProfileController@storeCompanyDetail']);

Route::get('view-company-detail',['as'=>'companydetail.view', 'uses'=>'ProfileController@viewCompanyDetail']);

Route::get('edit-company-detail/{uuid}',['as'=>'companydetail.edit', 'uses'=>'ProfileController@editCompanyDetail']);

Route::post('update-company-detail',['as'=>'companydetail.update', 'uses'=>'ProfileController@updateCompanyDetail']);

Route::post('buy-plan', ['as' => 'do.buy.plan', 'uses' => 'SubscriptionsController@redirectToGateway'])->middleware('sub.account');;

Route::post('buy-plan-bank-transfer', ['as' => 'buy.plan.by.bank.transfer', 'uses' => 'BankTransferSubscriptionsController@buyPlanByDirectBankTransfer'])->middleware('sub.account');;

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
Route::get('pending-subscribers', ['as' => 'plan.pending_subscribers', 'uses' => 'AdminController@pendingSubscribers']);
Route::get('activate-pending-subscribers/{userId}/{subUuid}', ['as' => 'plan.activate.pending_subscribers', 'uses' => 'BankTransferSubscriptionsController@activatePendingSubscribers']);
});
Route::prefix('manual_subscription')->group(function(){
Route::get('create','ManualSubscriptionController@create')->name('manual_subscription.create');
Route::get('/fetch-user-email/{userId}','ManualSubscriptionController@fetchUserEmail')->name('manual_subscription.useremail');
Route::get('/fetch-plan-price-id/{planNane}','ManualSubscriptionController@fetchPlanPrice')->name('manual_subscription.planPrice');
Route::post('/process-user-plan','ManualSubscriptionController@process_user_plan')->name('manual_subscription.process.plan');

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
Route::get('/delete/unit/{id}', 'AssetController@deleteUnit')->name('asset.delete.unit');
Route::get('/delete-service/{id}', 'AssetController@deleteService')->name('asset.delete.service');
Route::get('/tenants-service-charge/{id}', 'AssetController@tenantsServiceCharge')->name('asset.tenants.service');

Route::get('/get-tenants-service-charge/{id}', 'AssetController@getTenantsServiceCharge')->name('get.tenants.service');

Route::post('/new-service-charge', 'AssetController@add_Service_Charge')->name('addserviceCharge');
Route::get('/create-service-charge', 'AssetController@createServiceCharge')->name('asset.service.create');
Route::get('/create/service/charge/rental', 'AssetController@createServiceChargewithRental')->name('asset.service.create.rental');

Route::get('/remove-from-service-charge/{sc_id}/{tenant_id}', 'AssetController@removeTenantFromCS')->name('remove.tenant.from.sc');

Route::get('/edit-service-charge/{id}', 'AssetController@editServiceCharge')->name('asset.service.charge.edit');

Route::get('/view-service-charge/{id}', 'AssetController@AssetServiceCharges')->name('asset.servicecharges');

Route::post('/update-service-charge', 'AssetController@updateServiceCharge')->name('asset.service.charge.update');

Route::get('/get-asset-location/{asset_id}', 'AssetController@getAssetLocation')->name('getAssetLocation');

Route::post('/service-charges', 'AssetController@search_Service_Charge')->name('search.service.charge');

Route::post('/add-unit', 'AssetController@addUnit')->name('asset.unit.add');
Route::get('/service-charges', 'AssetController@serviceCharges')->name('service.charges');
Route::get('/service/charges/add', 'AssetController@addServiceCharges')->name('service.add');
Route::get('/delete/image/{id}', 'AssetController@deleteImage')->name('asset.delete.image');
Route::get('/view/details/{assetUuid}', 'AssetController@viewDetails')->name('asset.view.details');

Route::post('/add/photos', 'AssetController@addPhotos')->name('asset.add.photos');
Route::post('/add/feature', 'AssetController@addAssetFeatures')->name('asset.add.feature');
Route::get('/delete/feature/{id}', 'AssetController@deleteFeature')->name('asset.delete.feature');


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
Route::get('add-tenant-to-asset','TenantController@addTenantToAssetView')->name('tenant.to.asset');
Route::post('assign-tenant-to-asset','TenantController@addTenantToAssetStore')->name('tenant.to.asset.store');
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
Route::get('/search', 'LandlordController@searchLandlord')->name('landlord.search');
Route::get('fetch-landland/{id}', 'LandlordController@fetchLandlord')->name('landlord.fetch');

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
Route::get('/maintenance-status/{uuid}/{status}', 'MaintenanceController@changeStatus')->name('maintenance.status');
Route::get('/view/{uuid}/{complaint_row_number}', 'MaintenanceController@viewMaintenance')->name('maintenance.view');

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

//Multi-step forms
Route::prefix('multi-step')->group(function(){

Route::post('/multi-step-store-landlord', 'MultiStepFormController@multiStepOneStoreLandlord')->name('multi-step.storelandlord');
Route::post('/multi-step-store-asset', 'MultiStepFormController@multiStepTwoStoreAsset')->name('multi-step.storeAsset');
Route::post('/multi-step-store-tenant', 'MultiStepFormController@multiStepThreeStoreTenant')->name('multi-step.storeTenant');

Route::post('/multi-step-store-rental', 'MultiStepFormController@multiStepFourStoreRental')->name('multi-step.storeRental');

Route::post('/multi-step-store-rental-payment', 'MultiStepFormController@multiStepFiveStoreRentalPayment')->name('multi-step.storeRentalPayment');

Route::get('/asset/store', 'MultiStepFormController@nextToAsset')->name('multi-step.get.asset');
Route::get('/landlord/store', 'MultiStepFormController@backToLandlord')->name('multi-step.get.landlord');

Route::get('/next/summary', 'MultiStepFormController@nextToSummary')->name('multi-step.next.to.summary');

Route::get('/done', 'MultiStepFormController@done')->name('multi-step.done');

});


Route::prefix('report')->group(function(){
Route::get('assets-report', 'ReportController@assetReport')->name('report.assetreport');
Route::post('assets-report', 'ReportController@getAssetReport')->name('report.get_asset_report');

Route::get('landlord-report', 'ReportController@landlordReport')->name('report.landlordreport');
Route::post('landlord-report', 'ReportController@getLandlordReport')->name('report.get_landlord_report');

Route::get('rental-report', 'ReportController@rentalReport')->name('report.rentalreport');
Route::post('rental-report', 'ReportController@getRentalReport')->name('report.get_rental_report');

Route::get('servicecharge-report', 'ReportController@serviceChargeReport')->name('report.servicechargereport');
Route::post('servicecharge-report', 'ReportController@getServiceChargeReport')->name('report.get_servicecharge_report');

Route::get('approvals', 'ReportController@approvals')->name('report.approvals');
Route::get('maintenance', 'ReportController@maintenance')->name('report.maintenance');
Route::get('show-portFolio-report', 'ReportController@showPortfolioReport')->name('report.showgeneralportfolio');
Route::post('show-portFolio-report', 'ReportController@generalPortfolioReport')->name('report.search_gen_portfolio');

Route::get('show-my-portFolio-report', 'ReportController@showMyPortfolioReport')->name('report.showmyportfolio');
Route::post('show-my-portFolio-report', 'ReportController@myPortfolioReport')->name('report.search_my_portfolio');
});

Route::get('fetch-states/{country}', 'UtilsController@fetchState');
Route::get('fetch-cities/{state}', 'UtilsController@fetchCity');
Route::get('fetch-assets/{category}', 'UtilsController@fetchAssets');
Route::get('fetch-units/{property}', 'UtilsController@fetchUnits');
Route::get('analyse-property/{property}', 'UtilsController@analyseProperty');
Route::get('fetch-tenants-assigned-to-asset/{tenant_uuid}', 'UtilsController@fetchPropertiesAssignToTenant');
Route::get('fetch-units-assigned-to-tenant/{property}/{selected_tenant_uuid}', 'UtilsController@fetchUnitsAssignToTenant');
Route::get('fetch-tenants-added-to-asset/{asset_uuid}', 'UtilsController@fetchTenantAddedToAsset');
Route::get('fetch-tenants-added-to-rental/{asset_uuid}', 'UtilsController@fetchTenantAddedToRental');
Route::get('check-occupied-assets/{asset_uuid}', 'UtilsController@checkOccupiedAsset');

Route::get('fetch-service-charge/{type}', 'UtilsController@fetchServiceCharge');
Route::get('fetch-service-charge-by-property/{property}', 'UtilsController@fetchServiceChargeByProperty');
Route::get('search-users', 'UtilsController@searchUsers');
Route::get('verification', 'UtilsController@resendVerification')->name('verification');
Route::get('verify/{email}/{token}', 'UtilsController@verify');
Route::get('fetch-rented-units/{property}', 'UtilsController@fetchRentedUnits');
Route::get('fetch-tenant-asset/{tenant}', 'UtilsController@fetchTenantAsset');
Route::get('/validate-selected-date/{selected_date}', 'UtilsController@validateSelectedPaymentDate');
});

//captcha routes
Route::get('refresh-captcha','UtilsController@refreshCaptcha')->name('catpcha.refresh');
//cron job's routes
Route::get('notify-due-rent-at50percent', 'RentalController@notifyDueRentAt50Percent');
Route::get('notify-due-rent-at25percent', 'RentalController@notifyDueRentAt25Percent');
Route::get('notify-due-rent-at13percent', 'RentalController@notifyDueRentAt13Percent');
Route::get('notify-due-rent-at0percent', 'RentalController@notifyDueRentAt0Percent');
Route::get('renew-rental-job-at60percent', 'RentalController@renewRentalsAt60Percent');
Route::get('plan-upgrade-notification', 'RentalController@planUpgradeNotification');
Route::get('rent-due-in-next-ninetydays', 'RentalController@dueRentInNext90DaysNotification');
Route::get('rent-due-in-next-thirdtydays', 'RentalController@dueRentInNext30DaysNotification');
Route::get('past-due-rents', 'RentalController@pastDueRentsNotification');
Route::get('portfolio-summary', 'UtilsController@portfolioSummary');
