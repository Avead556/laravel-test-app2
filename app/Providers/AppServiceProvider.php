<?php

namespace App\Providers;

use App\Repository\CurrencyRepository;
use GuzzleHttp\Client;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        $this->app->when(CurrencyRepository::class)->needs(Client::class)->give(function ($app){
            return new Client([
                'base_uri' => config('api.currencyUrl'),
            ]);
        });
    }
}
