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

// Route::get('testing-time', function () {
//    echo date('m/d/Y H:i:s', 1611243565);
// });
Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@homepage');
Route::group(['middleware' => ['auth:sub_user,web']], function () {
	Route::get('/home', 'HomeController@index')->name('home');
	Route::resource('user', 'UserController', ['except' => ['show']]);
	//subuser Email verification
Route::get('verify-your-email', 'UserController@verifySubuserEmail')->name('subuser.verify.email');
Route::get('email/verification-link', 'UserController@resendEmailVerificationink')->name('resend.email.verification.link');
Route::get('email-verified', 'UserController@emailverified')->name('email.verified');

//primary user email verification
Route::get('email/verify', 'UserController@verifyMainuserEmail')->name('mainuser.verify.email');

	
	// Roles
	Route::get('roles', 'UsersRoleController@index')->name('role.index');
	// Route::get('new/role', 'UsersRoleController@create')->name('role.create');
	// Route::post('new/role', 'UsersRoleController@store')->name('role.store');
	


	// Only a super admin can access this route
	Route::group(['middleware' => ['superAdmin']], function() {
		
		// Sub users
		Route::get('/all/user', 'UserController@indexSubusers')->name('allSubUsers');
		Route::get('create/new/user', 'UserController@createsubuser')->name('newSubUser');
		Route::post('create/new/user', 'UserController@storesubuser')->name('storeuser');
		Route::get('subuser/{id}', 'UserController@editSubUser')->name('editSubUser');
		Route::post('subuser/{id}', 'UserController@updateSubUser')->name('updateSubUser');
		Route::delete('delete/{id}', 'UserController@deleteSubUSer')->name('deleteSubUSer');
		Route::get('check-user-level/{id}', 'AjaxController@checkUserLevel')->name('user.level.check');


		// Department
		Route::get('dept/new', ['as' => 'dept.create', 'uses' => 'DepartmentController@create']);
		Route::post('dept/new', ['as' => 'dept.store', 'uses' => 'DepartmentController@store']);
		Route::get('departments', ['as' => 'dept.index', 'uses' => 'DepartmentController@index']);
		Route::get('dept/{id}/show', ['as' => 'dept.show', 'uses' => 'DepartmentController@show']);
		Route::post('dept/{id}', ['as' => 'dept.update', 'uses' => 'DepartmentController@update']);
		Route::get('dept/{id}', ['as' => 'dept.destroy', 'uses' => 'DepartmentController@destroy']);

	});


	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
	// projects
	Route::get('projects', ['as' => 'project.index', 'uses' => 'ProjectController@index']);
	Route::get('projects/new', ['as' => 'project.create', 'uses' => 'ProjectController@create']);
	Route::post('projects/new', ['as' => 'project.store', 'uses' => 'ProjectController@store']);
	Route::get('project/{id}/show', ['as' => 'project.show', 'uses' => 'ProjectController@show']);
	Route::post('project/{id}', ['as' => 'project.update', 'uses' => 'ProjectController@update']);
	Route::get('project/{id}', ['as' => 'project.destroy', 'uses' => 'ProjectController@destroy']);

//Accounts
	Route::get('accounts', ['as' => 'customer.index', 'uses' => 'CustomerController@index']);

	Route::get('customer/{id}/show', ['as' => 'customer.show', 'uses' => 'CustomerController@show']);
	Route::get('customer/{id}/edit', ['as' => 'customer.edit', 'uses' => 'CustomerController@edit']);
	Route::get('customer/destroy/{id}', ['as' => 'customer.destroy', 'uses' => 'CustomerController@destroy']);
	Route::get('contact/destroy/{id}', ['as' => 'contact.destroy', 'uses' => 'CustomerController@deleteContact']);

	Route::get('account/corporate/new', ['as' => 'customer.corporate.create', 'uses' => 'Customer\CustomerCorporateController@create']);

	Route::post('customer/corporate/update', ['as' => 'customer.corporate.update', 'uses' => 'Customer\CustomerCorporateController@update']);
	
	Route::post('account/individual/update', ['as' => 'customer.individual.update', 'uses' => 'Customer\CustomerIndividualController@update']);

	Route::post('account/corporate/new', ['as' => 'customer.corporate.store', 'uses' => 'Customer\CustomerCorporateController@store']);
	Route::get('account/corporate/{id}/show', ['as' => 'customer.corporate.show', 'uses' => 'Customer\CustomerCorporateController@show']);
	Route::get('account/corporate/{id}/delete', ['as' => 'customer.corporate.destroy', 'uses' => 'Customer\CustomerCorporateController@destroy']);
	Route::post('account/corporate/{id}/saveContact', ['as' => 'customer.corporate.saveContacts', 'uses' => 'ContactController@saveContacts']);

	Route::get('account/individual/new', ['as' => 'customer.individual.create', 'uses' => 'Customer\CustomerIndividualController@create']);
	Route::post('account/individual/new', ['as' => 'customer.individual.store', 'uses' => 'Customer\CustomerIndividualController@store']);
	Route::get('account/individual/{id}/show', ['as' => 'customer.individual.show', 'uses' => 'Customer\CustomerIndividualController@show']);
	
	

	// products
	Route::get('products', ['as' => 'product.index', 'uses' => 'ProductController@index']);
	Route::get('product/new', ['as' => 'product.create', 'uses' => 'ProductController@create'])->middleware('user_admin');
	Route::post('product/new', ['as' => 'product.store', 'uses' => 'ProductController@store'])->middleware('user_admin');
	Route::get('product/{id}/show', ['as' => 'product.show', 'uses' => 'ProductController@show'])->middleware('user_admin');
	Route::post('product-update', ['as' => 'product.update', 'uses' => 'ProductController@update'])->middleware('user_admin');
	Route::get('edit-product/{id}','ProductController@editProduct')->name('product.edit')->middleware('user_admin');
	Route::get('product/{id}/destroy', ['as' => 'product.destroy', 'uses' => 'ProductController@destroy'])->middleware('user_admin');

	// Categories
	Route::get('product/categories', ['as' => 'product.category.index', 'uses' => 'CategoryController@index']);
	Route::get('product/category/new', ['as' => 'product.category.create', 'uses' => 'CategoryController@create'])->middleware('user_admin');
	Route::post('product/category/new', ['as' => 'product.category.store', 'uses' => 'CategoryController@store'])->middleware('user_admin');
	Route::get('product/category/{id}/show', ['as' => 'product.category.show', 'uses' => 'CategoryController@show'])->middleware('user_admin');
	Route::post('product/category/{id}/update', ['as' => 'product.category.update', 'uses' => 'CategoryController@update'])->middleware('user_admin');
	Route::get('product/category/{id}/destroy', ['as' => 'product.category.destroy', 'uses' => 'CategoryController@destroy'])->middleware('user_admin');


	// Sub categoriess
	Route::get('product/subcategories', ['as' => 'product.subcategory.index', 'uses' => 'SubCategoryController@index']);
	Route::get('product/subcategory/new', ['as' => 'product.subcategory.create', 'uses' => 'SubCategoryController@create']);
	Route::post('product/subcategory/new', ['as' => 'product.subcategory.store', 'uses' => 'SubCategoryController@store']);
	Route::get('product/subcategory/{id}/show', ['as' => 'product.subcategory.show', 'uses' => 'SubCategoryController@show']);
	Route::post('product/subcategory/{id}/update', ['as' => 'product.subcategory.update', 'uses' => 'SubCategoryController@update']);
	Route::get('product/subcategory/{id}/destroy', ['as' => 'product.subcategory.destroy', 'uses' => 'SubCategoryController@destroy']);

    Route::get('/get-product-subcategory/{id}', 'SubCategoryController@getProdSubCategory');
    Route::get('/get-product-by-subcategoryid/{id}', 'SubCategoryController@getProdBySubCategoryId');

	
	Route::get('contact/{id}/show', ['as' => 'customer.contact.show', 'uses' => 'ContactController@show']);
	Route::post('contact/{id}', ['as' => 'customer.contact.update', 'uses' => 'ContactController@update']);
	Route::get('contact/{id}', ['as' => 'contact.destroy', 'uses' => 'ContactController@destroy']);

	// Invoice
	Route::get('billing/invoice', ['as' => 'billing.invoice.index', 'uses' => 'InvoiceController@index']);
	Route::get('billing/invoice/new', ['as' => 'billing.invoice.create', 'uses' => 'InvoiceController@create']);
	Route::post('billing/invoice/new', ['as' => 'billing.invoice.store', 'uses' => 'InvoiceController@store']);
	Route::get('billing/invoice/{id}/show', ['as' => 'billing.invoice.show', 'uses' => 'InvoiceController@show']);
	Route::get('billing/invoice/{id}/manage', ['as' => 'billing.invoice.manage', 'uses' => 'InvoiceController@manage']);
	Route::post('billing/invoice/pay', ['as' => 'billing.invoice.pay', 'uses' => 'InvoiceController@pay']);
	Route::post('billing/invoice/update', ['as' => 'billing.invoice.update', 'uses' => 'InvoiceController@update']);
	Route::get('billing/invoice/{id}/edit', ['as' => 'billing.invoice.edit', 'uses' => 'InvoiceController@edit']);
	Route::get('billing/invoice/{id}', ['as' => 'billing.invoice.destroy', 'uses' => 'InvoiceController@destroy']);

	Route::post('billing/invoice/pay', ['as' => 'billing.invoice.pay', 'uses' => 'InvoiceController@pay']);

	// Renewal
	Route::get('billing/renewal', ['as' => 'billing.renewal.index', 'uses' => 'RenewalController@index']);
	Route::get('billing/renewal/new', ['as' => 'billing.renewal.create', 'uses' => 'RenewalController@create']);
	Route::get('billing/renewal/edit/{id}', ['as' => 'billing.renewal.edit', 'uses' => 'RenewalController@edit']);
	Route::post('billing/renewal/new', ['as' => 'billing.renewal.store', 'uses' => 'RenewalController@store']);
	Route::get('billing/renewal/{id}/manage', ['as' => 'billing.renewal.manage', 'uses' => 'RenewalController@manage']);
	Route::post('billing/renewal/pay', ['as' => 'billing.renewal.pay', 'uses' => 'RenewalController@pay']);
	Route::get('billing/renewal/{id}/show', ['as' => 'billing.renewal.show', 'uses' => 'RenewalController@show']);
	Route::post('billing/renewal', ['as' => 'billing.renewal.update', 'uses' => 'RenewalController@update']);
	Route::get('item/{item_model}/{id}', ['as' => 'items.destroy', 'uses' => 'AjaxController@destroyItems']);

	// Billing Agent
	Route::get('billing/agent','BillingAgentController@index')->name('billing.agent.index');
	Route::get('billing/create','BillingAgentController@create')->name('billing.agent.create');
	Route::post('billing/store','BillingAgentController@store')->name('billing.agent.store');
	Route::get('billing/agent/{id}','BillingAgentController@destroy')->name('billing.agent.destroy');



	// Opportunities
	Route::get('opportunities', ['as' => 'opportunity.index', 'uses' => 'OpportunityController@index']);
	Route::get('opportunity/new', ['as' => 'opportunity.create', 'uses' => 'OpportunityController@create']);
	Route::post('opportunity/new', ['as' => 'opportunity.store', 'uses' => 'OpportunityController@store']);
	Route::get('opportunity/{id}/show', ['as' => 'opportunity.show', 'uses' => 'OpportunityController@show']);
	Route::get('edit_opportunity/{id}', 'OpportunityController@edit')->name('opportunity.edit');
	Route::post('opportunity-update', ['as' => 'opportunity.update', 'uses' => 'OpportunityController@update']);
	Route::get('opportunity/{id}', ['as' => 'opportunity.destroy', 'uses' => 'OpportunityController@destroy']);
	Route::get('getopportunities/{id}', ['as' => 'opportunity.view', 'uses' => 'OpportunityController@getOpportunities']);

	Route::get('lower-level-user-opportunities/{user_id}', ['as' => 'lowerLevelUserOpp.view', 'uses' => 'OpportunityController@viewLowerLevelUserOpp']);


Route::get('lower-level-users-opportunities/{id}/{userId}', ['as' => 'lower.level.useropportunity.view', 'uses' => 'OpportunityController@getOpportunitiesOfLowerLevelUsers']);
Route::get('report/opportunity-report', 'OpportunityController@report')->name('opportunity.create.report');
Route::post('report/opportunity-reports', 'OpportunityController@getReport')->name('opportunity.get.report');
	// Target Management
	Route::get('targets', ['as' => 'target.index', 'uses' => 'TargetController@index']);
	Route::get('target/new', ['as' => 'target.create', 'uses' => 'TargetController@create']);
	Route::post('target/new', ['as' => 'target.store', 'uses' => 'TargetController@store']);
	Route::get('target/{id}/show', ['as' => 'target.show', 'uses' => 'TargetController@show']);
	Route::get('target/{id}/manage', ['as' => 'target.manage', 'uses' => 'TargetController@manage']);
	Route::post('target/{id}', ['as' => 'target.update', 'uses' => 'TargetController@update']);
	Route::get('target/{id}', ['as' => 'target.destroy', 'uses' => 'TargetController@destroy']);

	

	// Retail Field Sales Management
	Route::get('location', ['as' => 'sales.location.index', 'uses' => 'RetailFieldSalesController@allLocation']);
	Route::get('location/show/{id}', ['as' => 'sales.location.show', 'uses' => 'RetailFieldSalesController@showLocation']);
	Route::post('location/show/{id}', ['as' => 'sales.location.update', 'uses' => 'RetailFieldSalesController@updateLocation']);
	Route::get('sales', ['as' => 'sales.index', 'uses' => 'RetailFieldSalesController@index']);
	Route::get('sales/new', ['as' => 'sales.create', 'uses' => 'RetailFieldSalesController@create']);
	Route::post('sales/new', ['as' => 'sales.store', 'uses' => 'RetailFieldSalesController@store']);
	Route::get('sales/{id}/show', ['as' => 'sales.show', 'uses' => 'RetailFieldSalesController@show']);
	Route::get('sales/{id}/manage', ['as' => 'sales.manage', 'uses' => 'RetailFieldSalesController@manage']);
	Route::post('sales/{id}', ['as' => 'sales.update', 'uses' => 'RetailFieldSalesController@update']);
	Route::get('sales/{id}', ['as' => 'sales.destroy', 'uses' => 'RetailFieldSalesController@destroy']);
	Route::get('sales/location/new', ['as' => 'sales.location.create', 'uses' => 'RetailFieldSalesController@createLocation']);
	Route::post('sales/location/new', ['as' => 'sales.location.store', 'uses' => 'RetailFieldSalesController@storeLocation']);

	// Ajax
	Route::get('/validate-selected-date/{selected_date}', 'AjaxController@validateSelectedPaymentDate');
	Route::get('/increase-start-date-by-oneyear/{selected_date}', 'AjaxController@increaseStartDatebyOneYear');
	Route::get('fetch-product-price/{id}', 'AjaxController@fetchSelectedProductPrice');
	Route::get('fetch-renewal-details/{id}', 'AjaxController@fetchRenewalDetails');
	Route::get('fetch-invoice-details/{id}', 'AjaxController@fetchInvoiceDetails');
	Route::get('get-contact-emails/{id}', 'AjaxController@getContactEmails');
	Route::get('get-company-email/{id}', 'AjaxController@getCompanyEmail');

	Route::get('getcontact/{id}', 'AjaxController@getContacts');
	Route::get('getdept/{id}', 'AjaxController@getDept');
	Route::get('getproductprice/{id}', 'AjaxController@getProductPrice');
	Route::get('getsales/{id}', 'AjaxController@getSalesDept');
	Route::get('getstates/{id}', 'AjaxController@getState');
	Route::get('getcities/{id}', 'AjaxController@getCity');
	Route::get('mails', 'RenewalController@mail');

});

Route::group([
    'prefix' => 'settings'
], function () {

    Route::get('/', 'SettingsController@index')->name('settings.index');
    Route::post('upload_logo', 'SettingsController@uploadCompanyLogo')->name('company.upload.logo');
});

Route::group([
    'prefix' => 'location'
], function () {

    Route::get('fetch/cities', 'LocationController@fetchCities')->name('location.fetch.cities');
    Route::get('create/city', 'LocationController@createCity')->name('location.create.city');
    Route::post('add/city', 'LocationController@AddCity')->name('location.add.city');
    Route::get('edit/city', 'LocationController@editCity')->name('location.edit.city');
    Route::post('update/city', 'LocationController@updateCity')->name('location.update.city');
    Route::post('destroy/city', 'LocationController@destroyCity')->name('location.destroy.city');

});

// Only a zeus Admin can access this route
Route::group(['middleware' => ['auth:admin'], 'prefix' => 'admin/', 'as' => 'admin.'], function() {
	Route::get('home', ['uses' => 'Zeus\HomeController@index', 'as' => 'index']);

});

//cron jobs
	Route::get('first_recurring_reminder_mail', 'CronJobController@firstRecurringReminderMail');

	Route::get('annaul_renewal_notification', 'CronJobController@annualRenewalsNotification');
	Route::get('due_unpaid_renewals_monthly_notification', 'CronJobController@dueUnpaidRenewalsMonthlyNotification');
	