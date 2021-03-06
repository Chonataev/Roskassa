<?php

namespace Rkassa\Payment;

use Illuminate\Support\ServiceProvider;

class RkassaServiceProvider extends ServiceProvider{

    public function boot(){
        $this->publishes([
            __DIR__.'/../config/rkassa.php' => config_path('rkassa.php'),
        ]);
        $this->loadViewsFrom(__DIR__.'/../resource/views', 'rkassa');
     }
    
    public function register(){

        $this->app->singleton(Rkassa::class);
    }
}
