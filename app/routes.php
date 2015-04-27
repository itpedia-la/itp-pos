<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/**
 * Dashboard Route
 * ---------------
 */
Route::get('/', 'TransactionParentController@index');

/**
 * User Route
 * ----------
 */

Route::get('user/login', 'LoginController@login');
Route::post('user/login/submit', 'LoginController@submit');
Route::get('user/logout','UserController@logout');
Route::get('user/list', array('before'=>'restrict:3', 'uses' => 'UserController@userList'));

# User Json
Route::get('user/json/list' , array('before'=>'restrict:3', 'uses' => 'UserController@userListJson'));
Route::get('user/json/group' , 'UserController@userGroupJson');
Route::get('user/json/list/group/{user_group_id}' , array('before'=>'restrict:3', 'uses' => 'UserController@userListByGroupIdJson'));

# User form action
Route::get('user/form', array('before'=>'restrict:1', 'uses' => 'UserController@form'));
Route::post('user/form/submit', 'UserController@formSubmit');

# change password route
Route::get('user/changepassword/{user_id}', array('before'=>'restrict:4', 'uses' => 'UserController@changepassword'));
Route::post('user/changepassword/submit', array('before'=>'restrict:4', 'uses' => 'UserController@changepasswordSubmit'));

# change password route
Route::get('user/personal/change/password', 'UserController@personal_changepassword');
Route::post('user/personal/change/password/submit', 'UserController@personal_changepassword_submit');

# user remove route
Route::get('user/remove/{user_id}', array('before'=>'restrict:2', 'uses' => 'UserController@userRemove'));
Route::post('user/remove/submit', array('before'=>'restrict:2', 'uses' => 'UserController@userRemoveSubmit'));

# group permission route
Route::get('user/group/permission/{group_id}', array('before'=>'restrict:10', 'uses' => 'UserController@groupPermission'));
Route::post('user/group/permission/submit', array('before'=>'restrict:10', 'uses' => 'UserController@groupPermissionSubmit'));

# user permission route
Route::get('user/access/denied' , 'UserController@userAccessDenied');

/**
 * Customer Route
 * --------------
 */
Route::get('customer', array('before'=>'restrict:5', 'uses' => 'CustomerController@index'));
Route::get('customer/add', array('before'=>'restrict:6', 'uses' => 'CustomerController@add'));
Route::get('customer/json/list', 'CustomerController@CustomerListJson');
Route::get('customer/json/get/data/{customer_id}', 'CustomerController@CustomerDatJsonById');
Route::post('customer/save', array('before'=>'restrict:6', 'uses' => 'CustomerController@save'));
Route::get('customer/edit/{cust_id}',array('before'=>'restrict:7', 'uses' => 'CustomerController@edit'));
Route::post('customer/update', array('before'=>'restrict:7', 'uses' => 'CustomerController@update'));
Route::get('customer/remove/{cust_id}', array('before'=>'restrict:8', 'uses' => 'CustomerController@remove'));
Route::post('customer/delete', array('before'=>'restrict:8', 'uses' => 'CustomerController@delete'));

/**
 * Exchange Route
 * --------------
 */
Route::get('exchange', 'ExchangeRateController@index');
Route::post('exchange/save', array('before'=>'restrict:11', 'uses' => 'ExchangeRateController@save'));

/**
 * Option Route
 * ------------
 */
Route::get('option/json/currency', 'OptionController@currency');
Route::get('option/json/unit', 'OptionController@unit');

/**
 * Profile Route
 * --------------
 */
Route::get('profile', 'CompanyProfileController@index');
Route::post('profile/update', array('before'=>'restrict:12', 'uses' => 'CompanyProfileController@update'));

/**
 * Product Route
 * --------------
 */
Route::get('product', array('before'=>'restrict:38', 'uses' => 'ProductController@index'));
Route::get('product/add', array('before'=>'restrict:19', 'uses' => 'ProductController@add'));
Route::get('product/edit/{product_id}', array('before'=>'restrict:20', 'uses' => 'ProductController@edit'));
Route::post('product/form/submit', array('before'=>'restrict:20', 'uses' => 'ProductController@formSubmit'));


#Route::post('product/add/submit', 'ProductController@');

#Route::get('product/edit/{product_id}', 'ProductController@edit');

Route::get('product/json/list', 'ProductController@product_list_json');

Route::get('product/remove/{product_id}', 'ProductController@remove');
Route::post('product/delete', 'ProductController@delete');

/**
 * Transaction Route
 * -----------------
 * @author Somwang
 */
Route::get('transaction', array('before'=>'restrict:40', 'uses' => 'TransactionParentController@index'));
Route::get('transaction/add/{status}', array('before'=>'restrict:25', 'uses' => 'TransactionParentController@add'));
Route::post('transaction/add/submit', array('before'=>'restrict:26', 'uses' => 'TransactionParentController@addSubmit'));
Route::get('transaction/json/list/{month}', 'TransactionParentController@transactionParentJson');

Route::get('transaction/change_status/{tran_parent_id}', array('before'=>'restrict:27', 'uses' => 'TransactionParentController@change_status_to_invoice'));
Route::post('transaction/change_status/submit', array('before'=>'restrict:27', 'uses' => 'TransactionParentController@change_status_to_invoice_submit'));

Route::get('transaction/cancel/{tran_parent_id}', array('before'=>'restrict:29', 'uses' => 'TransactionParentController@cancel'));
Route::post('transaction/cancel/submit', array('before'=>'restrict:29', 'uses' => 'TransactionParentController@cancelSubmit'));

Route::get('transaction/print/quotation/{tran_parent_id}', array('before'=>'restrict:30', 'uses' => 'TransactionParentController@print_quotation'));

Route::get('transaction/create/invoice/{customer_id}/{month}/{transaction_parent_str}', 'TransactionParentController@create_invoice');
Route::post('transaction/create/invoice/submit', 'TransactionParentController@create_invoice_submit');

Route::get('transaction/custom/invoice/print/{invoice_id}/{customer_id}/{month}', 'TransactionParentController@custom_invoice');


Route::get('transaction_child/product/add/{transaction_parent_id}' , array('before'=>'restrict:31', 'uses' => 'TransactionChildController@addProduct'));
Route::post('transaction_child/product/add/submit' , 'TransactionChildController@addProductSubmit');
Route::get('transaction_child/service/add/{transaction_parent_id}' , array('before'=>'restrict:31', 'uses' => 'TransactionChildController@addService'));
Route::post('transaction_child/service/add/submit' , 'TransactionChildController@addServiceSubmit');
Route::get('transaction_child/json/list/{transaction_parent_id}/{invoice}', 'TransactionChildController@transactionChildJson');
Route::get('transaction_child/remove/{tran_parent_id}/{tran_child_id}' , array('before'=>'restrict:34', 'uses' => 'TransactionChildController@remove'));
Route::post('transaction_child/remove/submit' , 'TransactionChildController@removeSubmit');
Route::post('transaction_child/ajax/product/submit', 'TransactionChildController@ajaxSubmit');

Route::get('transaction_child/edit/{tran_parent_id}/{tran_child_id}/{penalty}' , 'TransactionChildController@edit');

Route::get('transaction_child/product/edit/{tran_parent_id}/{tran_child_id}' , array('before'=>'restrict:33', 'uses' => 'TransactionChildController@editProduct'));
Route::post('transaction_child/product/edit/submit' , 'TransactionChildController@editProductSubmit');

Route::get('transaction_child/service/edit/{tran_parent_id}/{tran_child_id}' , array('before'=>'restrict:33', 'uses' => 'TransactionChildController@editService'));
Route::post('transaction_child/service/edit/submit' , 'TransactionChildController@editServiceSubmit');

/**
 * Service Route
 * --------------
 */
Route::get('service', array('before'=>'restrict:39', 'uses' => 'ServiceController@index'));
Route::get('service/add', 'ServiceController@add');
Route::get('service/json/list', 'ServiceController@service_list_json');
Route::get('service/edit/{service_id}', array('before'=>'restrict:23', 'uses' => 'ServiceController@edit'));
Route::post('service/update', 'ServiceController@update');
Route::get('service/add', array('before'=>'restrict:22', 'uses' => 'ServiceController@add'));
Route::post('service/save', 'ServiceController@save');
Route::get('service/remove/{service_id}', array('before'=>'restrict:24', 'uses' => 'ServiceController@remove'));
Route::post('service/delete', 'ServiceController@delete');

/**
 * Report
 * ------
 */
Route::get('report/delivery/date/{date_start}/{date_end}',array('before'=>'restrict:13', 'uses' => 'ReportController@delivery'));
Route::get('report/material/customer/date/{date_start}/{date_end}',array('before'=>'restrict:15', 'uses' => 'ReportController@material_customer'));
Route::get('report/transaction/date/{date_start}/{date_end}',array('before'=>'restrict:17', 'uses' => 'ReportController@transaction'));
Route::get('report/transaction/month/{month}',array('before'=>'restrict:17', 'uses' => 'ReportController@transaction'));
Route::get('report/service/date/{date_start}/{date_end}',array('before'=>'restrict:17', 'uses' => 'ReportController@service'));
Route::get('report/payment/date/{date_start}/{date_end}',array('before'=>'restrict:17', 'uses' => 'ReportController@payment'));

/**
 * Payment
 * -------
 */
Route::get('payment/receive/{invoice_id}', 'TransactionPaymentController@receive');
Route::post('payment/receive/submit','TransactionPaymentController@receiveSubmit');

//Route::get('transaction/payment/json/list/{invoice_id}', 'TransactionPaymentController@paymentJson');
//Route::get('transaction/payment/{invoice_id}', 'TransactionPaymentController@index');
//Route::get('transaction/payment/create/{invoice_id}', 'TransactionPaymentController@payment');
//Route::post('transaction/payment/submit', 'TransactionPaymentController@paymentSubmit');
//Route::get('transaction/payment/remove/{payment_id}', 'TransactionPaymentController@payment_remove');
//Route::post('transaction/payment/remove/submit', 'TransactionPaymentController@payment_remove_submit');

/**
 * Invoice
 * -------
 */
Route::get('invoice/{transaction_parent_str}','InvoiceController@index');
Route::get('invoice/get/json/{transaction_parent_str}','InvoiceController@getJsonList');
Route::get('invoice/out/{invoice_id}','InvoiceController@invoiceOut');
Route::post('invoice/out/submit','InvoiceController@invoiceOutSubmit');
Route::get('invoice/edit/{invoice_id}','InvoiceController@invoiceEdit');
Route::post('invoice/edit/submit','InvoiceController@invoiceEditSubmit');
Route::get('invoice/print/{invoice_id}/{customer_id}','InvoiceController@invoice_print');

/**
 * Penalty
 * ------
 */
Route::get('transaction_invoice_penalty/remove/{id}' , 'TransactionInvoicePenaltyController@remove');
Route::post('transaction_invoice_penalty/remove/submit' , 'TransactionInvoicePenaltyController@remove_submit');

/**
 * Cron Job
 * --------
 */
Route::get('cron/overpaid_penalty', 'CronController@overpaidPenaltyCharge');
Route::get('cron/overdue_invoice', 'CronController@overdueInvoiceCharge');
Route::get('cron/db_fix', 'CronController@db_fix');