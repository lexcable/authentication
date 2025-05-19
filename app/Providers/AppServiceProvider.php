<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Carbon\CarbonInterval;

// Import your custom Passport models:
use App\Models\Passport\AuthCode;
use App\Models\Passport\Client;
use App\Models\Passport\DeviceCode;
use App\Models\Passport\RefreshToken;
use App\Models\Passport\Token;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Prevent Passport from auto-registering its routes
        Passport::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Load keys from a custom path
        Passport::loadKeysFrom(__DIR__ . '/../secrets/oauth');

        // Customize token lifetimes
        Passport::tokensExpireIn(CarbonInterval::days(15));
        Passport::refreshTokensExpireIn(CarbonInterval::days(30));
        Passport::personalAccessTokensExpireIn(CarbonInterval::months(6));

        // Tell Passport to use your custom Client model:
        Passport::useClientModel(\App\Models\Passport\Client::class);

        // Tell Passport to use your custom models
        Passport::useTokenModel(Token::class);
        Passport::useRefreshTokenModel(RefreshToken::class);
        Passport::useAuthCodeModel(AuthCode::class);
        Passport::useClientModel(Client::class);
        Passport::useDeviceCodeModel(DeviceCode::class);

        // By providing a view name...
        Passport::authorizationView('auth.oauth.authorize');

        // By providing a closure...
        Passport::authorizationView(fn ($parameters) => Inertia::render('Auth/OAuth/Authorize', [
            'request' => $parameters['request'],
            'authToken' => $parameters['authToken'],
            'client' => $parameters['client'],
            'user' => $parameters['user'],
            'scopes' => $parameters['scopes'],
        ]));
    }
}
