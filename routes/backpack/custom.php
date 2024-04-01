<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin'),
        ['capabilities']
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController');
    Route::crud('checkin', 'CheckinCrudController');
    Route::crud('member', 'MemberCrudController');
    Route::crud('membership', 'MembershipCrudController');
    Route::crud('payment', 'PaymentCrudController');
    Route::get('dashboard', [Controller::class, 'index'])->name('dashboard');
    Route::get('reports', [Controller::class, 'report'])->name('report');
    Route::get('reportsMembers', [Controller::class, 'reportMembers'])->name('reportMembers');
    Route::get('reportsPayments', [Controller::class, 'reportsPayment'])->name('reportsPayments');
    Route::get('cashFlow', [Controller::class, 'cash'])->name('cash');
    
    
}); // this should be the absolute last line of this file