<?php

use App\Exports\LanguageExport;
use App\Http\Controllers\ProductVariationController;
use App\Http\Controllers\PageController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\Shop\PagesController;
use App\Http\Controllers\Voyager\ImportsController;
use App\Http\Controllers\Voyager\RetailerAdminController;
use App\Http\Controllers\Voyager\ShopController;
use App\Http\Controllers\Voyager\VoyagerShopController;
use App\Imports\ProductsImport;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Dashboard\Shop\ProductsController;
use App\Http\Controllers\TwoPaymentController;
use App\Http\Controllers\Voyager\OrderController;
use Maatwebsite\Excel\Facades\Excel;

Voyager::routes();

Route::group(['middleware' => 'admin.user', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::post('store-attribute', [ProductsController::class, 'store_attribue'])->name('store.attribute');
    Route::post('update-attribute', [ProductsController::class, 'update_attribue'])->name('update.attribute');
    Route::get('new-variation/{product}', [ProductsController::class, 'create_variation'])->name('new.variation');
    Route::post('update-variation/{product}', [ProductsController::class, 'update_variation'])->name('update.variation');
    Route::get('delete-meta/{product}', [ProductsController::class, 'delete_variation'])->name('delete.product.meta');
    Route::get('delete-attribute/{attribute}', [ProductsController::class, 'delete_attribue'])->name('delete.product.attribute');
    Route::get('copy-product/{product}', [ProductsController::class, 'CopyProduct'])->name('copy.product');
    Route::get('changelog', [PagesController::class, 'changelog'])->name('changelog');
    Route::get('shop-product-export-by-admin/{shop}', [ExportController::class, 'shop_product_export_by_admin'])->name('shop_product_export_by_admin');
    Route::get('export-group-product/{group}', [ExportController::class, 'export_group_product'])->name('export_group_product');
    Route::get('/charges/{charge}/invoice/pdf', [App\Http\Controllers\Dashboard\External\DashboardController::class, 'downloadInvoice'])->name('external.download.invoice');
});

Route::group(
    [
        'as' => 'admin.retailer.',
        'middleware' => 'admin.user',
        'prefix' => 'retailer',
        'controller' => RetailerAdminController::class
    ],
    function () {
        Route::get('/add-new-retailer', 'create')->name('create-retailer');
        Route::get('/withdrawals/{user?}', 'withdrawals')->name('retailer-withdrawals');
        Route::post('/withdrawals/balance/{user}', 'withdrawalsBalance')->name('retailer-withdrawals-balance');
        Route::post('/store-retailer', 'store')->name('store-retailer');
        Route::post('/delete-retailer/{retailer}', 'retailerDelete')->name('delete-retailer');
        Route::post('/transfer-clients/{retailerMeta}', 'transferClients')->name('transferClients');

        Route::get('/report/{user}', 'report')->name('report');
        Route::get('/withdraw/approve/{data}', 'retailerWithdraw')->name('withdraw.approve');
        Route::get('/withdraw/cancel/{data}', 'retailerCancel')->name('withdraw.cancel');
    }
);

Route::group([ 'middleware' => 'admin.user'], function () {
    Route::get('advance-shop-edit/{shop}', [ShopController::class, 'advance_shop_edit'])->name('advance.shop.edit');
    Route::get('send-shop-password/{shop}', [ShopController::class, 'send_shop_password'])->name('send.shop.password');
    Route::get('/orders/{order}/refund', [OrderController::class, 'refundView'])->name('admin.orders.refund');
    Route::post('/orders/{order}/refund-store', [OrderController::class, 'refund'])->name('admin.orders.refund.store');
    Route::get('/orders/{order}/cancel', [TwoPaymentController::class, 'orderCancel'])->name('admin.orders.cancel');
    Route::get('/orders/{order}/fulfilled', [TwoPaymentController::class, 'orderFulfilled'])->name('admin.orders.fulfiled');
    Route::post('import-product', [ImportsController::class, 'import_product'])->name('admin.product.import');
    Route::post('/import-languages', [ImportsController::class, 'import_languages'])->name('admin.languages.import');
    Route::post('import-shop', [ImportsController::class, 'import_shops'])->name('admin.shops.import');
    Route::get('/export/languages', function () {
        return Excel::download(new LanguageExport, 'languages.xlsx');
    })->name('admin.languages.download');
});
