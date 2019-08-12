<?php

namespace App\Providers;

use App\Contracts\ValidationTokenInterface;
use App\Support\Validator\TokenValidator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() : void
    {
        $this->app->bind(ValidationTokenInterface::class, static function() {
            return new TokenValidator();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
