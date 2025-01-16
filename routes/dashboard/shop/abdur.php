<?php

use App\Http\Controllers\Dashboard\Shop\DashboardController;
use App\Http\Controllers\Dashboard\Shop\OrdersController;
use App\Http\Controllers\Dashboard\Shop\ProductsController;
use App\Http\Controllers\Dashboard\Shop\ReportController;
use App\Http\Controllers\Shop\PersonalTrainerReportController;
use Illuminate\Support\Facades\Route;


Route::get('report', [DashboardController::class, 'reportIndex'])->name('report.index');

Route::get('pt-report', [ReportController::class, 'ptReport'])->name('pt.report');
// Route::get('pt-report/pdf', [ReportController::class, 'ptReportPdf'])->name('pt.report.pdf');
Route::get('pt-report/pdf', [PersonalTrainerReportController::class, 'index'])->name('pt.report.pdf');
// Route::get('clients', [ReportController::class, 'clients'])->name('clients');
Route::get('orders', [OrdersController::class, 'index'])->name('order.index');
Route::get('/invoice/{order}', [OrdersController::class, 'invoice'])->name('invoice');
Route::get('/invoice/{order}/pdf', [OrdersController::class, 'download'])->name('invoice.download');
    

Route::post('imported-products', [ProductsController::class, 'importProduct'])->name('product.import');
