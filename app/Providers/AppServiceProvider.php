<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
        Validator::extend('youtube_link', function ($attribute, $value, $parameters, $validator) {
            // Regular expression to validate YouTube URL
            $pattern = '/^(https?\:\/\/)?(www\.youtube\.com|youtu\.?be)\/.+$/';
            return preg_match($pattern, $value);
        });
    }
}
