<?php

use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\CompanyEmailController;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;

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

    Route::get('/something-went-wrong', 'HomeController@displayNonHttpErrors')->name('non.http.errors');
    Route::get('email-verified/{userId}/{user_type}', 'UserController@emailverified')->name('email.verified');

Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@homepage');
Route::group(['middleware' => ['auth:sub_user,web']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('user', 'UserController', ['except' => ['show']]);
    //subuser Email verification
    Route::get('verify-your-email', 'UserController@verifySubuserEmail')->name('subuser.verify.email');
    Route::get('email/verification-link', 'UserController@resendEmailVerificationink')->name('resend.email.verification.link');

    //primary user email verification
    Route::get('email/verify', 'UserController@verifyMainuserEmail')->name('mainuser.verify.email');
    Route::get('update-subuser/{status}/{id}', 'UserController@enableOrDisableSubuser');

    
    // Roles
    Route::get('roles', 'UsersRoleController@index')->name('role.index');
    // Route::get('new/role', 'UsersRoleController@create')->name('role.create');
    // Route::post('new/role', 'UsersRoleController@store')->name('role.store');
    


    // Only a super admin can access this route
    Route::group(['middleware' => ['superAdmin']], function () {
        
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
    Route::post('project-update', ['as' => 'project.update', 'uses' => 'ProjectController@update']);
    Route::post('project_update', ['as' => 'project.newupdate', 'uses' => 'ProjectController@updateProject']);
    Route::get('project/{id}', ['as' => 'project.destroy', 'uses' => 'ProjectController@destroy']);
    Route::get('project/{id}/edit', ['as' => 'project.edit', 'uses' => 'ProjectController@edit']);

    Route::post('import-corporate-customers', ['as' => 'import.corporate.customers', 'uses' => 'CustomerController@importCorporateCustomers']);
    Route::post('import-individual-customers', ['as' => 'import.individual.customers', 'uses' => 'CustomerController@importIndividualCustomers']);
    Route::get('import/corporate/customers', ['as' => 'customer.corporate.import', 'uses' => 'CustomerController@importCorporateCustomersForm']);
    Route::get('import/individual/customers', ['as' => 'customer.individual.import', 'uses' => 'CustomerController@importIndividualCustomersForm']);

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

    Route::get('/search/customers', 'CustomerController@searchCustomersByName')->name('search.customer.name');

    Route::get('account/individual/new', ['as' => 'customer.individual.create', 'uses' => 'Customer\CustomerIndividualController@create']);
    Route::post('account/individual/new', ['as' => 'customer.individual.store', 'uses' => 'Customer\CustomerIndividualController@store']);
    Route::get('account/individual/{id}/show', ['as' => 'customer.individual.show', 'uses' => 'Customer\CustomerIndividualController@show']);
    
    

    // products
    Route::get('products', ['as' => 'product.index', 'uses' => 'ProductController@index']);
    Route::get('product/new', ['as' => 'product.create', 'uses' => 'ProductController@create'])->middleware('user_admin');
    Route::post('product/new', ['as' => 'product.store', 'uses' => 'ProductController@store'])->middleware('user_admin');
    Route::get('product/{id}/show', ['as' => 'product.show', 'uses' => 'ProductController@show'])->middleware('user_admin');
    Route::post('product-update', ['as' => 'product.update', 'uses' => 'ProductController@update'])->middleware('user_admin');
    Route::get('edit-product/{id}', 'ProductController@editProduct')->name('product.edit')->middleware('user_admin');
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
    Route::get('billing/invoice/{id}/{status}/{navStatus}/show', ['as' => 'billing.invoice.show', 'uses' => 'InvoiceController@show']);
    Route::get('billing/invoice/{id}/{status}/{navStatus}', ['as' => 'billing.invoice.navigate', 'uses' => 'InvoiceController@navigateInvoices']);
    Route::get('billing/invoice/{id}/manage', ['as' => 'billing.invoice.manage', 'uses' => 'InvoiceController@manage']);
    Route::post('billing/invoice/pay', ['as' => 'billing.invoice.pay', 'uses' => 'InvoiceController@pay']);
    Route::post('billing/invoice/update', ['as' => 'billing.invoice.update', 'uses' => 'InvoiceController@update']);
    Route::get('billing/invoice/{id}/edit', ['as' => 'billing.invoice.edit', 'uses' => 'InvoiceController@edit']);
    Route::get('billing/invoice/{id}', ['as' => 'billing.invoice.destroy', 'uses' => 'InvoiceController@destroy']);

    Route::post('billing/invoice/pay', ['as' => 'billing.invoice.pay', 'uses' => 'InvoiceController@pay']);
    Route::get('download/invoice/{id}', 'InvoiceController@downloadInvoicePayment')->name('invoice.download');
    Route::get('resend-invoice/{id}', 'InvoiceController@resendInvoicePayment')->name('invoice.payment.resend');

    Route::get('billing/invoice/view/{id}', 'InvoiceController@getBillingInvoices')->name('billing.invoice.view');

    Route::get('confirm/invoice/{id}', 'InvoiceController@changeInvoiceBillStatusToConfirmed')->name('invoice.bill.status.confirm');
    Route::get('send/invoice/{id}', 'InvoiceController@changeInvoiceBillStatusToSent')->name('invoice.bill.status.sent');

    Route::get('resend/invoice-payment/receipt/{id}', 'InvoiceController@resendInvoicePaymentReceipt')->name('resend.invoice.payment.receipt');
    Route::get('download/invoice-payment/receipt/{id}', 'InvoiceController@downloadInvoicePaymentReceipt')->name('download.invoice.payment.receipt');

     Route::post('invoice/filter/by-start-end-date', 'InvoiceController@filterInvoiceBystartEndDate')->name('search.invoice.by.start.end.date');

    // Renewal
    Route::get('billing/renewal', ['as' => 'billing.renewal.index', 'uses' => 'RenewalController@index']);
    Route::get('billing/renewal/new', ['as' => 'billing.renewal.create', 'uses' => 'RenewalController@create']);
    Route::get('billing/renewal/edit/{id}', ['as' => 'billing.renewal.edit', 'uses' => 'RenewalController@edit']);
    Route::post('billing/renewal/new', ['as' => 'billing.renewal.store', 'uses' => 'RenewalController@store']);
    Route::get('billing/renewal/{id}/manage', ['as' => 'billing.renewal.manage', 'uses' => 'RenewalController@manage']);
    Route::post('billing/renewal/pay', ['as' => 'billing.renewal.pay', 'uses' => 'RenewalController@pay']);
    Route::get('billing/renewal/{id}/{status}/{navStatus}/show', ['as' => 'billing.renewal.show', 'uses' => 'RenewalController@show']);
    Route::get('billing/renewal/{id}/{status}/{navStatus}', ['as' => 'billing.renewal.navigate', 'uses' => 'RenewalController@navigateRenewals']);
    Route::post('billing/renewal', ['as' => 'billing.renewal.update', 'uses' => 'RenewalController@update']);
    Route::get('item/{item_model}/{id}', ['as' => 'items.destroy', 'uses' => 'AjaxController@destroyItems']);

    Route::get('resend-renewal-invoice/{id}', 'RenewalController@resendRenewalInvoice')->name('renewal.invoice.resend');

    Route::get('download-renewal-invoice/{id}', 'RenewalController@downloadRenewalInvoice')->name('renewal.invoice.download');

    Route::get('billing/renewal/{id}', 'RenewalController@getBillingRenewals')->name('billing.renewal.invoice.view');

    Route::get('confirm/recurring/invoice/{id}', 'RenewalController@changeBillStatusToConfirmed')->name('recurring.bill.status.confirm');
    Route::get('send/recurring/invoice/{id}', 'RenewalController@changeBillStatusToSent')->name('recurring.bill.status.sent');

    Route::get('resend/payment/receipt/{id}', 'RenewalController@resendRenwalPaymentReceipt')->name('resend.renewal.payment.receipt');
    Route::get('download/payment/receipt/{id}', 'RenewalController@downloadRenewalPaymentReceipt')->name('download.renewal.payment.receipt');

    Route::post('search/recurring/invoice/by-start-end-date', 'RenewalController@filterRecurringInvoiceBystartEndDate')->name('search.renewal.by.start.end.date');



    //renewal updates
    Route::post('renewal_update', 'RenewalUpdateController@storeUpdate')->name('renewal.update.store');
    Route::post('update-renewal-update', 'RenewalUpdateController@editRenewalUpdate')->name('renewalupdateopperator');
    Route::post('add-renewal-update-reply', 'RenewalUpdateController@storeRenewalUpdateReply')->name('renewal.update.reply.store');
    Route::post('update-renewal-update-reply', 'RenewalUpdateController@updateRenewalUpdateReply')->name('renewal.update.reply.edit');
    ;



    // Billing Agent
    Route::get('billing/agent', 'BillingAgentController@index')->name('billing.agent.index');
    Route::get('billing/create', 'BillingAgentController@create')->name('billing.agent.create');
    Route::post('billing/store', 'BillingAgentController@store')->name('billing.agent.store');
    Route::get('billing/agent/{id}', 'BillingAgentController@destroy')->name('billing.agent.destroy');



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

    //opportunity updates
    Route::post('opportunity_update', 'OpportunityUpdateController@storeUpdate')->name('opportunity.update.store');
    Route::post('update-opport-update', 'OpportunityUpdateController@editOpportunityUpdate')->name('opportunity.update.edit');
    ;
    Route::post('add-opport-update-reply', 'OpportunityUpdateController@storeOpportunityUpdateReply')->name('opportunity.update.reply.store');
    Route::post('update-opport-update-reply', 'OpportunityUpdateController@updateOpportunityUpdateReply')->name('opportunity.update.reply.edit');
    ;



    // Target Management
    Route::get('targets/sales-person/{id}/{saleperson}', ['as' => 'target.index', 'uses' => 'TargetController@index']);
    Route::get('target/new', ['as' => 'target.create', 'uses' => 'TargetController@create']);
    Route::post('target/new', ['as' => 'target.store', 'uses' => 'TargetController@store']);
    Route::get('target/{id}/show', ['as' => 'target.show', 'uses' => 'TargetController@show']);
    Route::get('target/{id}/manage', ['as' => 'target.manage', 'uses' => 'TargetController@manage']);
    Route::post('target/{id}', ['as' => 'target.update', 'uses' => 'TargetController@update']);
    Route::get('target/{id}', ['as' => 'target.destroy', 'uses' => 'TargetController@destroy']);
    Route::post('add-product-totarget', 'TargetController@addProductToTarget')->name('target.product.add');

    Route::get('targets/sales-persons', ['as' => 'target.sales.persons', 'uses' => 'TargetController@getTargetsBySalesPerson']);
    

    

    // Retail Field Sales Management
    Route::get('location', ['as' => 'sales.location.index', 'uses' => 'RetailFieldSalesController@allLocation']);
    Route::get('location/show/{id}', ['as' => 'sales.location.show', 'uses' => 'RetailFieldSalesController@showLocation']);
    Route::get('location/edit/{id}', ['as' => 'sales.location.edit', 'uses' => 'RetailFieldSalesController@editLocation']);

    Route::post('location/show', ['as' => 'sales.location.update', 'uses' => 'RetailFieldSalesController@updateLocation']);
    Route::get('sales', ['as' => 'sales.index', 'uses' => 'RetailFieldSalesController@index']);
    Route::get('sales/new', ['as' => 'sales.create', 'uses' => 'RetailFieldSalesController@create']);
    Route::post('sales/new', ['as' => 'sales.store', 'uses' => 'RetailFieldSalesController@store']);
    Route::get('sales/{id}/show', ['as' => 'sales.show', 'uses' => 'RetailFieldSalesController@show']);
    Route::get('sales/{id}/manage', ['as' => 'sales.manage', 'uses' => 'RetailFieldSalesController@manage']);
     Route::get('sales/edit/{id}', ['as' => 'sales.edit', 'uses' => 'RetailFieldSalesController@edit']);
    Route::post('update-sales', ['as' => 'sales.update', 'uses' => 'RetailFieldSalesController@update']);
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
    Route::get('mails', 'RenewalController@mail');
    Route::get('fetch-company-email/{id}', 'AjaxController@fetchCompanyEmail');
    Route::get('fetch-company-bank-detail/{id}', 'AjaxController@fetchCompanyBankDetail');
    // Opportunities update
    Route::get('fetch-opport-update/{id}', 'AjaxController@fetchOpportunityUpdate');
    Route::get('fetch-opport-update-reply/{id}', 'AjaxController@fetchOpportunityUpdateReply');
    // Opportunities update
    Route::get('fetch-renewal-update/{id}', 'AjaxController@fetchRenewalUpdate');
    Route::get('fetch-renewal-update-reply/{id}', 'AjaxController@fetchRenewalUpdateReply');
});

Route::get('getstates/{id}', 'AjaxController@getState');
Route::get('getcities/{id}', 'AjaxController@getCity');

Route::group([
    'prefix' => 'company_details'
], function () {
    Route::get('/', 'SettingsController@index')->name('company_details.index');
    Route::post('/update-name', 'SettingsController@updateCompanyName')->name('company.update.name');
   

    Route::post('upload_logo', 'SettingsController@uploadCompanyLogo')->name('company.upload.logo');
   
  
   
    Route::get('/destroy/{id}', 'SettingsController@destroyCurrencySymbol')->name('destroy.currency.symbol');
});

Route::group([
'prefix' => 'bank-account'], function () {
    Route::get('/', 'BankAccountController@index')->name('bank.account.index');

    Route::post('/add-new', 'BankAccountController@addCompanyBankAccount')->name('company.add.bank_account.detail');
    Route::post('/update', 'BankAccountController@updateCompanyBankDetail')->name('company.update.bank.account');
});

Route::group([
'prefix' => 'company-emails'], function () {
    Route::get('/', 'CompanyEmailController@index')->name('company.email.index');

    Route::post('/add-new', 'CompanyEmailController@addCompanyEmail')->name('company.add.email');
    Route::post('/update', 'CompanyEmailController@updateCompanyEmail')->name('company.update.email');
    Route::post('/add-reply-to-email', 'CompanyEmailController@addReplyToEmails')->name('add.reply.to.email');

    Route::get('/{id}', 'CompanyEmailController@getReplyToEmailById');
    Route::post('/update-replyToEmail', 'CompanyEmailController@updateReplyToEmail')->name('update.replyToEmail');

    Route::get('/default/replyToEmail/{id}', 'CompanyEmailController@setDefaultToEmail')->name('set.default.replyToEmail');


    Route::post('/add-mail-from-name', 'CompanyEmailController@addMailFromName')->name('add.mail.from.name');
    Route::post('/update-mail-from-name', 'CompanyEmailController@updateMailFromName')->name('update.mail.from.name');
    Route::get('/mail_from_name/{id}', 'CompanyEmailController@getMailFromNameById');
    Route::get('/cc-email/{id}', 'CompanyEmailController@getCCEmailById');
    Route::get('/default/email/from-name/{id}', 'CompanyEmailController@setDefaultMailFromName')->name('set.default.mail.from.name');

    Route::post('/add-cc-email', 'CompanyEmailController@addCcEmails')->name('add.cc.email');
    Route::post('/update-cc-email', 'CompanyEmailController@updateCCEmail')->name('update.cc.email');
});

Route::group([
    'prefix' => 'email-marketing'
], function () {
    Route::get('/create', 'EmailMarketingController@createNewEmail')->name('email.marketing.create');
    Route::get('/list', 'EmailMarketingController@listEmails')->name('email.marketing.list');
    Route::post('/send', 'EmailMarketingController@sendNewEmail')->name('email.marketing.send');

    Route::get('/show/{id}', 'EmailMarketingController@showEmail')->name('email.marketing.show');
});

  Route::resource('currency', CurrencyController::class);

  Route::group([
    'prefix' => 'subcription'
], function () {

    Route::get('plans', 'SubscriptionsController@getPlans')->name('subcription.plans');
    Route::get('/fetch-plan-details/{plan_id}', 'SubscriptionsController@fetchPlanDetails');
    Route::post('/update-plan', 'SubscriptionsController@updatePlan')->name('update.plan');

});
 
Route::group([
    'prefix' => 'order'
], function () {

    Route::get('create', 'OrderController@createOrder')->name('order.create');
    Route::get('lists', 'OrderController@listOrders')->name('order.lists');
    Route::post('store', 'OrderController@storeOrder')->name('order.store');
    Route::post('update', 'OrderController@updateOrder')->name('order.update');
    Route::get('edit/{orderId}', 'OrderController@editOrder')->name('order.edit');
    Route::get('destroy/{orderId}', 'OrderController@deleteOrder')->name('order.destroy');
    Route::get('insale', 'OrderController@inSale')->name('order.insale');
    Route::post('customer-insale', 'OrderController@customerInsale')->name('customer.insale');
});

Route::group([
    'prefix' => 'inventory'
], function () {
    Route::get('/fetch/{inventoryId}', 'InventoryController@getInventoryToManage')->name('inventory.fetch');
    Route::post('/update', 'InventoryController@updateInventory')->name('inventory.update');
    Route::get('show/{inventoryId}', 'InventoryController@showInventory')->name('inventory.show');

});

Route::group([
    'prefix' => 'product-review'
], function () {

    // Route::get('create', 'ProductReviewController@createReview')->name('review.create');
    // Route::get('lists', 'ProductReviewController@listReviews')->name('review.lists');
    Route::post('store', 'ProductReviewController@storeReview')->name('review.store');
    Route::post('update', 'ProductReviewController@updateReview')->name('review.update');
    // Route::get('edit/{reviewId}', 'ProductReviewController@editReview')->name('review.edit');
    // Route::get('show/{reviewId}', 'ProductReviewController@showReview')->name('review.show');
    Route::get('destroy/{reviewId}', 'ProductReviewController@deleteReview')->name('review.destroy');
});


// Only a zeus Admin can access this route
Route::group(['middleware' => ['auth:admin'], 'prefix' => 'admin/', 'as' => 'admin.'], function () {
    Route::get('home', ['uses' => 'Zeus\HomeController@index', 'as' => 'index']);
    Route::get('location/create/city', 'LocationController@createCity')->name('location.create.city');
    Route::post('location/add/city', 'LocationController@AddCity')->name('location.add.city');
    Route::get('cities', 'LocationController@fetchCities')->name('location.view.cities');
    Route::get('plans', 'PlanController@index')->name('plans.index');
    Route::get('create', 'PlanController@createPlan')->name('plans.create');
    Route::post('store', 'PlanController@storePlan')->name('plans.store');
    Route::get('plans/{id}', 'PlanController@edit')->name('plans.edit');
    Route::post('update/plan', 'PlanController@updatePlan')->name('plans.update');
    Route::get('all-subscriptions', 'PlanController@allSubscriptions')->name('sub.all');
    Route::get('activate/{userId}/{planId}/{subId}', 'PlanController@activatePendingSubscription');
    Route::get('revoke/sub/{userId}/{planId}/{subId}', 'PlanController@revokeActiveSubscription');

});


Route::group([
'prefix' => 'team'], function () {
    Route::get('/lists', 'TeamController@index')->name('team.index');
    Route::post('/store', 'TeamController@store')->name('team.store');
    Route::post('/update', 'TeamController@update')->name('team.update');
    Route::get('/show/{team}', 'TeamController@show')->name('team.show');
    Route::get('/destroy/{team}', 'TeamController@destroy')->name('team.destroy');
    Route::get('/fetch/{team}', 'TeamController@fetchTeam');
    Route::post('/add-member', 'TeamController@addMember')->name('team.add.member');

});


Route::group([
'prefix' => 'location'], function () {
    Route::get('/lists', 'CustomerLocationController@index')->name('customer.location.index');
    Route::post('/store', 'CustomerLocationController@storeCustomerLocation')->name('customer.location.store');
    Route::post('/update', 'CustomerLocationController@update')->name('customer.location.update');
    Route::get('/show/{location}', 'CustomerLocationController@show')->name('customer.location.show');
    Route::get('/create', 'CustomerLocationController@createLocation')->name('customer.location.create');
    Route::get('/destroy/{location}', 'CustomerLocationController@destroy')->name('customer.location.destroy');

});



//billing receipt confirmation
    Route::get('billing/invoice/{invoicceId}/confirm', 'RenewalController@confirmRecurringInvoiceReceipt')->name('recurring.billing.confirm');

    Route::get('invoice/{invoicceId}/confirm', 'InvoiceController@confirmInvoiceReceipt')->name('invoice.billing.confirm');

    //Export report to csv
    Route::get('export-csv', [ReportController::class, 'exportCSVReport'])->name('export.csv');
    //download report as pdf
    Route::get('download-pdf', [ReportController::class, 'downloadPdf'])->name('downloadreport.pdf');
    Route::get('get-team-members/{team_id}', [ReportController::class, 'displayTeamMembers']);


//cron jobs notifications
    Route::get('annaul_renewal_notification', 'CronJobController@annualRenewalsNotification');
    Route::get('due_unpaid_renewals_monthly_notification', 'CronJobController@dueUnpaidRenewalsMonthlyNotification');
    Route::get('renew_expired_recurring_by_one_year', 'CronJobController@renewExpiredReccuringByOneYear');

    Route::get('empty_jobstbl', 'EmailMarketingController@emptyJobTable');

//Custom email reset
Route::post('reset_password_without_token', 'CustomEmailResetController@validatePasswordRequest')->name('reset.password.without.token');
Route::post('reset_password_with_token', 'CustomEmailResetController@resetPassword')->name('reset.password.with.token');
