<?php

use Illuminate\Support\Facades\Route;
use KevinBHarris\Support\Http\Controllers\Portal\PortalController;

Route::group(['prefix' => 'support', 'middleware' => ['web']], function () {
    
    // Public portal for customers to view tickets by token
    Route::get('ticket/{token}', [PortalController::class, 'show'])->name('support.portal.show');
    Route::post('ticket/{token}/reply', [PortalController::class, 'reply'])->name('support.portal.reply');
    
    // Contact/ticket submission via CMS page (POST endpoint kept for form submission)
    Route::post('contact', [PortalController::class, 'submitTicket'])->name('support.portal.submit');
});
