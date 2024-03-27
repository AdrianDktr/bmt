<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\View\Composers\NewsComposer;
use App\Models\News; // tambahkan ini
use App\Models\NewsBottom; // tambahkan ini

class NewsComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer(['layouts.app'], function ($view) {
            $news = News::all();
            $newsbottom = NewsBottom::all();

            $view->with(compact('news', 'newsbottom'));
        });
    }
}

