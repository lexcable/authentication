
<?php

use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\AuthorizeController;
use Laravel\Passport\Http\Controllers\TokenController;
use Laravel\Passport\Http\Controllers\TransientTokenController;
use Laravel\Passport\Http\Controllers\ClientController;
use Laravel\Passport\Http\Controllers\ScopeController;

Route::group([
    'as'        => 'passport.',
    'prefix'    => config('passport.path', 'oauth'),
    'namespace' => 'Laravel\Passport\Http\Controllers',
    'middleware'=> ['web'], // adjust or remove as you see fit
], function () {
    // Issue access tokens and revoke them...
    Route::post('/token', [AccessTokenController::class, 'issueToken'])
         ->name('token');
    Route::delete('/token', [AccessTokenController::class, 'revokeToken'])
         ->name('revoke');

    // Short‐lived “transient” tokens used in mobile flows...
    Route::post('/token/refresh', [TransientTokenController::class, 'refresh'])
         ->name('token.refresh');

    // Authorization screen for third‐party clients...
    Route::get('/authorize', [AuthorizeController::class, 'showAuthorizationForm'])
         ->name('authorize');
    Route::post('/authorize', [AuthorizeController::class, 'approve'])
         ->name('authorize.approve');
    Route::delete('/authorize', [AuthorizeController::class, 'deny'])
         ->name('authorize.deny');

    // Client management UI...
    Route::get('/clients', [ClientController::class, 'forUser'])
         ->name('clients.forUser');
    Route::post('/clients', [ClientController::class, 'store'])
         ->name('clients.store');
    Route::put('/clients/{client}', [ClientController::class, 'update'])
         ->name('clients.update');
    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])
         ->name('clients.destroy');

    // Personal access clients...
    Route::get('/personal-access-clients', [ClientController::class, 'personalAccessClients'])
         ->name('personal_access_clients.index');
    Route::post('/personal-access-clients', [ClientController::class, 'storePersonalAccessClient'])
         ->name('personal_access_clients.store');

    // Scopes listing...
    Route::get('/scopes', [ScopeController::class, 'all'])
         ->name('scopes.index');
});
