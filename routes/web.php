<?php

use App\Http\Controllers\WebhooksController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/invoices/payment', [\App\Http\Controllers\DemoController::class, 'index']);
Route::get('/invoices/{dni}/all', [\App\Http\Controllers\DemoController::class, 'all']);
Route::get('/invoices/{dni}/all/pay', [\App\Http\Controllers\DemoController::class, 'summary']);

Route::get('/invoices/{dni}/all/pay/thank', [\App\Http\Controllers\DemoController::class, 'redirectThanks'])->name('redirect.approved');

Route::post('webhooks', WebhooksController::class)->name('redirect.webhook');

Route::get('/dasboard/tickets', [\App\Http\Controllers\Ticket\TicketController::class, 'index'])->name('tickets.index');
Route::get('/dasboard/ticket/{id}', [\App\Http\Controllers\Ticket\TicketController::class, 'show'])->name('tickets.show');
Route::get('/dasboard/create/ticket', [\App\Http\Controllers\Ticket\TicketController::class, 'create'])->name('ticket.create');
Route::post('/dasboard/store/ticket', [\App\Http\Controllers\Ticket\TicketController::class, 'storeCase']);
Route::post('/dasboard/ticket/update', [\App\Http\Controllers\Ticket\TicketController::class, 'updateCase']);

Route::get('/dasboard/invoices', [\App\Http\Controllers\Invoice\InvoicesController::class, 'allInvoices']);
Route::get('/dasboard/invoices/all/pay/', [\App\Http\Controllers\Invoice\InvoicesController::class, 'summary']);

Route::get('/dasboard/invoices/all/pay/thank', [\App\Http\Controllers\Invoice\InvoicesController::class, 'redirectThanks'])->name('dashboard.approved');

Route::get('/esatic/install/migrate', [\App\Http\Controllers\MigrateController::class, 'index']);
Route::get('/esatic/install/migrate/refresh', [\App\Http\Controllers\MigrateController::class, 'refresh']);
