<?php

namespace Danshin\Sitemap\Providers;

use Danshin\Sitemap\Console\Commands\Generate as GenerateCommand;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class PackegeServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateCommand::class
            ]);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [GenerateCommand::class];
    }
}
