<?php

use App\Http\Controllers\ExportController;
use App\Http\Livewire\AsignarController;
use App\Http\Livewire\AyudaController;
use App\Http\Livewire\CashoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\CategoriesController;
use App\Http\Livewire\CoinsController;
use App\Http\Livewire\DashboardController;
use App\Http\Livewire\FacturaController;
use App\Http\Livewire\PermisosController;
use App\Http\Livewire\PosController;
use App\Http\Livewire\ProductsController;
use App\Http\Livewire\PurchaseController;
use App\Http\Livewire\ReportsController;
use App\Http\Livewire\ReportsPurchasesController;
use App\Http\Livewire\RolesController;
use App\Http\Livewire\SuppliersController;
use App\Http\Livewire\TicketController;
use App\Http\Livewire\UsersController;
use Illuminate\Support\Facades\Auth;

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

Route::redirect('/', '/login');

Auth::routes();
Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/categorias', CategoriesController::class)->middleware('permission:ver categorias');
    Route::get('/proveedores', SuppliersController::class)->middleware('permission:ver proveedores');
    Route::get('/compras', PurchaseController::class)->middleware('permission:ver compras');
    Route::get('/productos', ProductsController::class)->middleware('permission:ver productos');
    Route::get('/monedas', CoinsController::class)->middleware('permission:ver denominaciones');
    Route::get('/ventas', PosController::class)->middleware('permission:ver ventas');
    Route::get('/ventas/{saleID}', [TicketController::class, 'ticket'])->middleware('permission:ver ventas');
    Route::get('/roles', RolesController::class)->middleware('permission:ver roles');
    Route::get('/permisos', PermisosController::class)->middleware('permission:ver permisos');
    Route::get('/asignar', AsignarController::class)->middleware('permission:ver asignar');
    Route::get('/usuarios', UsersController::class)->middleware('permission:ver usuarios');
    Route::get('/caja', CashoutController::class)->middleware('permission:ver caja');
    Route::get('/reportes', ReportsController::class)->middleware('permission:ver reportes');

    Route::get('/reportes/pdf/{user}/{type}/{f1}/{f2}', [ExportController::class, 'reportPDF'])->middleware('permission:ver reportes');
    Route::get('/reportes/pdf/{user}/{type}', [ExportController::class, 'reportPDF'])->middleware('permission:ver reportes');

    Route::get('/reportes/excel/{user}/{type}/{f1}/{f2}', [ExportController::class, 'reportExcel'])->middleware('permission:ver reportes');
    Route::get('/reportes/excel/{user}/{type}', [ExportController::class, 'reportExcel'])->middleware('permission:ver reportes');

    Route::get('/reportes/compras/pdf/{user}/{type}/{f1}/{f2}', [ExportController::class, 'reportPurchasePDF'])->middleware('permission:ver reportes');
    Route::get('/reportes/compras/pdf/{user}/{type}', [ExportController::class, 'reportPurchasePDF'])->middleware('permission:ver reportes');

    Route::get('/reportes/compras/excel/{user}/{type}/{f1}/{f2}', [ExportController::class, 'reportPurchaseExcel'])->middleware('permission:ver reportes');
    Route::get('/reportes/compras/excel/{user}/{type}', [ExportController::class, 'reportPurchaseExcel'])->middleware('permission:ver reportes');

    Route::get('/ayuda', AyudaController::class);
});

Route::get('/factura/{saleID}', [ExportController::class, 'FacturaPDF']);
Route::get('/credito/{saleID}', [ExportController::class, 'creditoPDF']);