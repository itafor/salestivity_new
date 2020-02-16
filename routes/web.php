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
    return view('welcome');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);


	Route::get('email/template', function() {
		return view('emails/sendinvoice');
	});

	// Sub users
	Route::get('/all/user', 'UserController@indexSubusers')->name('allSubUsers');
	Route::get('create/new/user', 'UserController@createsubuser')->name('newSubUser');
	Route::post('create/new/user', 'UserController@storesubuser')->name('storeuser');


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
	Route::get('product/new', ['as' => 'product.create', 'uses' => 'ProductController@create']);
	Route::post('product/new', ['as' => 'product.store', 'uses' => 'ProductController@store']);
	Route::get('product/{id}/show', ['as' => 'product.show', 'uses' => 'ProductController@show']);
	Route::post('product/{id}', ['as' => 'product.update', 'uses' => 'ProductController@update']);
	Route::get('product/{id}', ['as' => 'product.destroy', 'uses' => 'ProductController@destroy']);

	// Categories
	Route::get('product/categories', ['as' => 'product.category.index', 'uses' => 'CategoryController@index']);
	Route::get('product/category/new', ['as' => 'product.category.create', 'uses' => 'CategoryController@create']);
	Route::post('product/category/new', ['as' => 'product.category.store', 'uses' => 'CategoryController@store']);
	Route::get('product/category/{id}/show', ['as' => 'product.category.show', 'uses' => 'CategoryController@show']);
	Route::post('product/category/{id}', ['as' => 'product.category.update', 'uses' => 'CategoryController@update']);
	Route::get('product/category/{id}', ['as' => 'product.category.destroy', 'uses' => 'CategoryController@destroy']);

	
	Route::get('product/subcategory/new', ['as' => 'product.subcategory.create', 'uses' => 'SubCategoryController@create']);
	Route::post('product/subcategory/new', ['as' => 'product.subcategory.store', 'uses' => 'SubCategoryController@store']);
	
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
	Route::post('billing/invoice/{id}', ['as' => 'billing.invoice.update', 'uses' => 'InvoiceController@update']);
	Route::get('billing/invoice/{id}', ['as' => 'billing.invoice.destroy', 'uses' => 'InvoiceController@destroy']);

	// Renewal
	Route::get('billing/renewal', ['as' => 'billing.renewal.index', 'uses' => 'RenewalController@index']);
	Route::get('billing/renewal/new', ['as' => 'billing.renewal.create', 'uses' => 'RenewalController@create']);
	Route::get('billing/renewal/edit/{id}', ['as' => 'billing.renewal.edit', 'uses' => 'RenewalController@edit']);
	Route::post('billing/renewal/new', ['as' => 'billing.renewal.store', 'uses' => 'RenewalController@store']);
	Route::get('billing/renewal/{id}/manage', ['as' => 'billing.renewal.manage', 'uses' => 'RenewalController@manage']);
	Route::post('billing/renewal/pay', ['as' => 'billing.renewal.pay', 'uses' => 'RenewalController@pay']);
	Route::get('billing/renewal/{id}/show', ['as' => 'billing.renewal.show', 'uses' => 'RenewalController@show']);
	Route::post('billing/renewal', ['as' => 'billing.renewal.update', 'uses' => 'RenewalController@update']);
	Route::get('billing/renewal/{id}', ['as' => 'billing.renewal.destroy', 'uses' => 'RenewalController@destroy']);

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
	Route::post('opportunity/{id}', ['as' => 'opportunity.update', 'uses' => 'OpportunityController@update']);
	Route::get('opportunity/{id}', ['as' => 'opportunity.destroy', 'uses' => 'OpportunityController@destroy']);
	Route::get('getopportunities/{id}', ['as' => 'opportunity.view', 'uses' => 'OpportunityController@getOpportunities']);

	// Target Management
	Route::get('targets', ['as' => 'target.index', 'uses' => 'TargetController@index']);
	Route::get('target/new', ['as' => 'target.create', 'uses' => 'TargetController@create']);
	Route::post('target/new', ['as' => 'target.store', 'uses' => 'TargetController@store']);
	Route::get('target/{id}/show', ['as' => 'target.show', 'uses' => 'TargetController@show']);
	Route::get('target/{id}/manage', ['as' => 'target.manage', 'uses' => 'TargetController@manage']);
	Route::post('target/{id}', ['as' => 'target.update', 'uses' => 'TargetController@update']);
	Route::get('target/{id}', ['as' => 'target.destroy', 'uses' => 'TargetController@destroy']);

	// Department
	Route::get('dept/new', ['as' => 'dept.create', 'uses' => 'DepartmentController@create']);
	Route::post('dept/new', ['as' => 'dept.store', 'uses' => 'DepartmentController@store']);
	Route::get('departments', ['as' => 'dept.index', 'uses' => 'DepartmentController@index']);
	Route::get('dept/{id}/show', ['as' => 'dept.show', 'uses' => 'DepartmentController@show']);
	Route::post('dept/{id}', ['as' => 'dept.update', 'uses' => 'DepartmentController@update']);
	Route::get('dept/{id}', ['as' => 'dept.destroy', 'uses' => 'DepartmentController@destroy']);

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
	Route::get('get-contact-emails/{id}', 'AjaxController@getContactEmails');

	Route::get('getcontact/{id}', 'AjaxController@getContacts');
	Route::get('getdept/{id}', 'AjaxController@getDept');
	Route::get('getproductprice/{id}', 'AjaxController@getProductPrice');
	Route::get('getsales/{id}', 'AjaxController@getSalesDept');
	Route::get('getstates/{id}', 'AjaxController@getState');
	Route::get('getcities/{id}', 'AjaxController@getCity');

	//cron jobs
	Route::get('renewals_notificationAt_15_Percent', 'CronJobController@renewalsNotificationAt15Percent');
	Route::get('renewals_notificationAt_5_Percent', 'CronJobController@renewalsNotificationAt5Percent');
	Route::get('renewals_notificationAt_0_Percent', 'CronJobController@renewalsNotificationAt0Percent');

});

