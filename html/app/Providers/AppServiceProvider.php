<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Helper\Helper;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\UrlGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        Helper::setCountry('pa');
        if( env('APP_ENV') == 'production' || env('APP_DEBUG') == false ){

            $url->forceScheme('https');
        }

        View::composer('*', function($view){
            $identity_card_type = Helper::getIdentityCardType();
            $view->with('identity_card_type', $identity_card_type);
        });
    }
}
