<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CommandeService::class, function ($app) {
            return new CommandeService();
        });
    
        $this->app->singleton(ArticleService::class, function ($app) {
            return new ArticleService();
        });
    
        $this->app->singleton(CAService::class, function ($app) {
            return new CAService();
        });
    
        $this->app->singleton(RecentCommandesService::class, function ($app) {
            return new RecentCommandesService();
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
