<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\invoiceArchiveController;
use App\Http\Controllers\InvoicesReportController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoicesAttachmentsController;



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


// Auth::routes();
Auth::routes(['register' => false]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

Route::resource('invoices', InvoicesController::class);

Route::resource('invoiceArchive', invoiceArchiveController::class);

Route::resource('sections', SectionsController::class);

Route::resource('products', ProductsController::class);

Route::get('invoices_paid', [InvoicesController::class, 'invoices_paid']);

Route::get('invoices_partial', [InvoicesController::class, 'invoices_partial']);

Route::get('invoices_unpaid', [InvoicesController::class, 'invoices_unpaid']);

Route::get('invoices_archive', [InvoicesController::class, 'invoices_archive']);

Route::get('invoices_report', [InvoicesReportController::class, 'index']);

Route::get('search_invoices', [InvoicesReportController::class, 'search_invoices']);

Route::get('customers_report', [InvoicesReportController::class, 'index_customers']);

Route::get('search_customers', [InvoicesReportController::class, 'search_customers']);


Route::get('archive_restore', [InvoicesController::class, 'archive_restore'])->name('archive_restore');

Route::get('archive_destroy', [InvoicesController::class, 'archive_destroy'])->name('archive_destroy');

Route::get('section/{id}', [InvoicesController::class, 'getproducts']);

Route::get('invoices_details/{id}', [InvoicesDetailsController::class, 'edit']);

Route::get('view_file/{file_name}', [InvoicesDetailsController::class, 'open_file']);

Route::get('download/{file_name}', [InvoicesDetailsController::class, 'get_file']);

Route::get('/{page}', [AdminController::class, 'index']);

Route::resource('InvoiceAttachments', InvoicesAttachmentsController::class);

Route::get('edit_invoice/{id}', [InvoicesController::class, 'edit']);

Route::get('show_status/{id}', [InvoicesController::class, 'show'])->name('show_status');

Route::get('update_status/{id}', [InvoicesController::class, 'update_status'])->name('update_status');

Route::get('print_invoice/{id}', [InvoicesController::class, 'print_invoice']);
