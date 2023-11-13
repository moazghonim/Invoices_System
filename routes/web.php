<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceArchiveController;
use App\Http\Controllers\InvoiceDetailsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\InoviceReportController;
use App\Http\Controllers\CustomersReportController;
use App\Http\Controllers\DashboardController;


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified', 'checkstatus'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::resource('invoices', InvoicesController::class);

Route::resource('sections', SectionController::class);

Route::resource('products', ProductController::class);

Route::resource('Archive', InvoiceArchiveController::class);

Route::post('InvoiceAttachments', [InvoiceAttachmentsController::class, 'store'])->name('InvoiceAttachments');

Route::get('section/{id}', [InvoicesController::class, 'getproducts']);

Route::get('InvoicesDetails/{id}', [InvoiceDetailsController::class, 'edit']);

Route::get('download/{invoice_number}/{file_name}', [InvoiceDetailsController::class, 'get_file']);

Route::get('View_file/{invoice_number}/{file_name}', [InvoiceDetailsController::class, 'open_file']);

Route::post('delete_file', [InvoiceDetailsController::class, 'destroy'])->name('delete_file');

Route::get('edit_invoice/{id}', [InvoicesController::class, 'edit'])->name('edit_invoice');

Route::get('Status_show/{id}', [InvoicesController::class, 'show'])->name('Status_show');

Route::post('/Status_Update/{id}', [InvoicesController::class, 'Status_Update'])->name('Status_Update');

Route::get('Invoice_Paid', [InvoicesController::class, 'Invoice_Paid']);

Route::get('Invoice_UnPaid', [InvoicesController::class, 'Invoice_UnPaid']);

Route::get('Invoice_Partial', [InvoicesController::class, 'Invoice_Partial']);

Route::get('Print_invoice/{id}', [InvoicesController::class, 'Print_invoice']);

Route::get('export_invoices', [InvoicesController::class, 'export']);

Route::get('invoices_report', [InoviceReportController::class, 'index']);

Route::post('Search_invoices', [InoviceReportController::class, 'Search_invoices']);

Route::get('customers_report', [CustomersReportController::class, 'index']);

Route::post('Search_customers', [CustomersReportController::class, 'Search_customers']);

Route::get('MarkAsRead_all', [InvoicesController::class, 'MarkAsRead_all']);


Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

Route::get('/{page}', [AdminController::class, 'index']);
