<?php

namespace App\Providers;

use App\Enterprise\Permissions;
use App\Facades\Iziibuy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use TCG\Voyager\Facades\Voyager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind('iziibuy', function () {  //Keep in mind this "check" must be return from facades accessor
            return new Iziibuy;
        });

        app()->bind('permission', function () {  //Keep in mind this "check" must be return from facades accessor
            return new Permissions;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('vendor', function () {
            return Auth::check() && Auth::user()->role_id == 3;
        });


        Blade::if('AddService', function () {
            // return Feature::can_add_service();
            return true;
        });

        Blade::if('permission', function ($feature, $action) {
            return Permissions::check($feature, $action);
        });

        Paginator::useBootstrap();

        Validator::excludeUnvalidatedArrayKeys();
        // Voyager::addAction(\App\Actions\PricesAction::class);

        if (env('APP_ENV') == 'production') {
            URL::forceScheme('https');
        }

        Blade::if('personalTrainer', function () {
            return Auth::user()->role->name === "manager" && Auth::user()->trainee == '1';
        });

        Blade::if('CanProvideService', function ($shop) {
            return $shop->can_provide_service;
        });
        Blade::if('HasTrainer', function ($shop) {

            return (auth()->check() &&
                !empty(auth()->user()->trainer($shop)->id) && !empty($shop->defaultoption));
            // return true;
        });
        Blade::if('HasSubscription', function ($shop) {
            return $shop->boxes()->count();
        });
        Blade::if('Dev', function () {
            return env('MODE') == 'dev';
        });
        Blade::if('Menu', function ($bool) {
            return $bool;
        });
        Voyager::addAction(\App\Actions\ReplyAction::class);
    }
}
