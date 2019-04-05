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
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
	// projects
	Route::get('projects', ['as' => 'project.index', 'uses' => 'ProjectController@index']);
	Route::get('projects/new', ['as' => 'project.create', 'uses' => 'ProjectController@create']);
	Route::post('projects/new', ['as' => 'project.store', 'uses' => 'ProjectController@store']);

	// customer account
	Route::get('accounts', ['as' => 'customer.index', 'uses' => 'CustomerController@index']);
	Route::get('account/new', ['as' => 'customer.create', 'uses' => 'CustomerController@create']);
	Route::post('account/new', ['as' => 'customer.store', 'uses' => 'CustomerController@store']);

	// products
	Route::get('products', ['as' => 'product.index', 'uses' => 'ProductController@index']);
	Route::get('product/new', ['as' => 'product.create', 'uses' => 'ProductController@create']);
	Route::post('product/new', ['as' => 'product.store', 'uses' => 'ProductController@store']);

	// Invoice
	Route::get('billing/invoice', ['as' => 'billing.invoice.index', 'uses' => 'InvoiceController@index']);
	Route::get('billing/invoice/new', ['as' => 'billing.invoice.create', 'uses' => 'InvoiceController@create']);
	Route::post('billing/invoice/new', ['as' => 'billing.invoice.store', 'uses' => 'InvoiceController@store']);

	// Renewal
	Route::get('billing/renewal', ['as' => 'billing.renewal.index', 'uses' => 'RenewalController@index']);
	Route::get('billing/renewal/new', ['as' => 'billing.renewal.create', 'uses' => 'RenewalController@create']);
	Route::post('billing/renewal/new', ['as' => 'billing.renewal.store', 'uses' => 'RenewalController@store']);



});

