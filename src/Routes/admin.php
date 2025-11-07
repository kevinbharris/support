<?php

use Illuminate\Support\Facades\Route;
use KevinBHarris\Support\Http\Controllers\Admin\TicketController;
use KevinBHarris\Support\Http\Controllers\Admin\StatusController;
use KevinBHarris\Support\Http\Controllers\Admin\PriorityController;
use KevinBHarris\Support\Http\Controllers\Admin\CategoryController;
use KevinBHarris\Support\Http\Controllers\Admin\CannedResponseController;
use KevinBHarris\Support\Http\Controllers\Admin\RuleController;

Route::group(['prefix' => 'admin/support', 'middleware' => ['web', 'admin']], function () {
    
    // Tickets
    Route::middleware('support_permission:support.tickets.view')->group(function () {
        Route::get('tickets', [TicketController::class, 'index'])->name('admin.support.tickets.index');
        Route::get('tickets/{id}', [TicketController::class, 'show'])->name('admin.support.tickets.show');
    });
    
    Route::get('tickets/create', [TicketController::class, 'create'])
        ->name('admin.support.tickets.create')
        ->middleware('support_permission:support.tickets.create');
    
    Route::post('tickets', [TicketController::class, 'store'])
        ->name('admin.support.tickets.store')
        ->middleware('support_permission:support.tickets.create');
    
    Route::get('tickets/{id}/edit', [TicketController::class, 'edit'])
        ->name('admin.support.tickets.edit')
        ->middleware('support_permission:support.tickets.update');
    
    Route::put('tickets/{id}', [TicketController::class, 'update'])
        ->name('admin.support.tickets.update')
        ->middleware('support_permission:support.tickets.update');
    
    Route::delete('tickets/{id}', [TicketController::class, 'destroy'])
        ->name('admin.support.tickets.destroy')
        ->middleware('support_permission:support.tickets.delete');
    
    Route::post('tickets/{id}/notes', [TicketController::class, 'addNote'])
        ->name('admin.support.tickets.notes.add')
        ->middleware('support_permission:support.tickets.notes');
    
    Route::post('tickets/{id}/assign', [TicketController::class, 'assign'])
        ->name('admin.support.tickets.assign')
        ->middleware('support_permission:support.tickets.assign');
    
    Route::post('tickets/{id}/watchers', [TicketController::class, 'addWatcher'])
        ->name('admin.support.tickets.watchers.add')
        ->middleware('support_permission:support.tickets.watchers');
    
    Route::delete('tickets/{id}/watchers/{watcherId}', [TicketController::class, 'removeWatcher'])
        ->name('admin.support.tickets.watchers.remove')
        ->middleware('support_permission:support.tickets.watchers');
    
    Route::post('tickets/bulk', [TicketController::class, 'bulk'])
        ->name('admin.support.tickets.bulk')
        ->middleware('support_permission:support.tickets.update');
    
    // Statuses
    Route::middleware('support_permission:support.statuses.view')->group(function () {
        Route::get('statuses', [StatusController::class, 'index'])->name('admin.support.statuses.index');
    });
    
    Route::get('statuses/create', [StatusController::class, 'create'])
        ->name('admin.support.statuses.create')
        ->middleware('support_permission:support.statuses.create');
    
    Route::post('statuses', [StatusController::class, 'store'])
        ->name('admin.support.statuses.store')
        ->middleware('support_permission:support.statuses.create');
    
    Route::get('statuses/{id}/edit', [StatusController::class, 'edit'])
        ->name('admin.support.statuses.edit')
        ->middleware('support_permission:support.statuses.update');
    
    Route::put('statuses/{id}', [StatusController::class, 'update'])
        ->name('admin.support.statuses.update')
        ->middleware('support_permission:support.statuses.update');
    
    Route::delete('statuses/{id}', [StatusController::class, 'destroy'])
        ->name('admin.support.statuses.destroy')
        ->middleware('support_permission:support.statuses.delete');
    
    // Priorities
    Route::middleware('support_permission:support.priorities.view')->group(function () {
        Route::get('priorities', [PriorityController::class, 'index'])->name('admin.support.priorities.index');
    });
    
    Route::get('priorities/create', [PriorityController::class, 'create'])
        ->name('admin.support.priorities.create')
        ->middleware('support_permission:support.priorities.create');
    
    Route::post('priorities', [PriorityController::class, 'store'])
        ->name('admin.support.priorities.store')
        ->middleware('support_permission:support.priorities.create');
    
    Route::get('priorities/{id}/edit', [PriorityController::class, 'edit'])
        ->name('admin.support.priorities.edit')
        ->middleware('support_permission:support.priorities.update');
    
    Route::put('priorities/{id}', [PriorityController::class, 'update'])
        ->name('admin.support.priorities.update')
        ->middleware('support_permission:support.priorities.update');
    
    Route::delete('priorities/{id}', [PriorityController::class, 'destroy'])
        ->name('admin.support.priorities.destroy')
        ->middleware('support_permission:support.priorities.delete');
    
    // Categories
    Route::middleware('support_permission:support.categories.view')->group(function () {
        Route::get('categories', [CategoryController::class, 'index'])->name('admin.support.categories.index');
    });
    
    Route::get('categories/create', [CategoryController::class, 'create'])
        ->name('admin.support.categories.create')
        ->middleware('support_permission:support.categories.create');
    
    Route::post('categories', [CategoryController::class, 'store'])
        ->name('admin.support.categories.store')
        ->middleware('support_permission:support.categories.create');
    
    Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])
        ->name('admin.support.categories.edit')
        ->middleware('support_permission:support.categories.update');
    
    Route::put('categories/{id}', [CategoryController::class, 'update'])
        ->name('admin.support.categories.update')
        ->middleware('support_permission:support.categories.update');
    
    Route::delete('categories/{id}', [CategoryController::class, 'destroy'])
        ->name('admin.support.categories.destroy')
        ->middleware('support_permission:support.categories.delete');
    
    // Canned Responses
    Route::middleware('support_permission:support.canned-responses.view')->group(function () {
        Route::get('canned-responses', [CannedResponseController::class, 'index'])->name('admin.support.canned-responses.index');
    });
    
    Route::get('canned-responses/create', [CannedResponseController::class, 'create'])
        ->name('admin.support.canned-responses.create')
        ->middleware('support_permission:support.canned-responses.create');
    
    Route::post('canned-responses', [CannedResponseController::class, 'store'])
        ->name('admin.support.canned-responses.store')
        ->middleware('support_permission:support.canned-responses.create');
    
    Route::get('canned-responses/{id}/edit', [CannedResponseController::class, 'edit'])
        ->name('admin.support.canned-responses.edit')
        ->middleware('support_permission:support.canned-responses.update');
    
    Route::put('canned-responses/{id}', [CannedResponseController::class, 'update'])
        ->name('admin.support.canned-responses.update')
        ->middleware('support_permission:support.canned-responses.update');
    
    Route::delete('canned-responses/{id}', [CannedResponseController::class, 'destroy'])
        ->name('admin.support.canned-responses.destroy')
        ->middleware('support_permission:support.canned-responses.delete');
    
    // Rules
    Route::middleware('support_permission:support.rules.view')->group(function () {
        Route::get('rules', [RuleController::class, 'index'])->name('admin.support.rules.index');
    });
    
    Route::get('rules/create', [RuleController::class, 'create'])
        ->name('admin.support.rules.create')
        ->middleware('support_permission:support.rules.create');
    
    Route::post('rules', [RuleController::class, 'store'])
        ->name('admin.support.rules.store')
        ->middleware('support_permission:support.rules.create');
    
    Route::get('rules/{id}/edit', [RuleController::class, 'edit'])
        ->name('admin.support.rules.edit')
        ->middleware('support_permission:support.rules.update');
    
    Route::put('rules/{id}', [RuleController::class, 'update'])
        ->name('admin.support.rules.update')
        ->middleware('support_permission:support.rules.update');
    
    Route::delete('rules/{id}', [RuleController::class, 'destroy'])
        ->name('admin.support.rules.destroy')
        ->middleware('support_permission:support.rules.delete');
});
