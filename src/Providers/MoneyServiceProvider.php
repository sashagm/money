<?php

namespace Sashagm\Money\Providers;

use Sashagm\Money\Console\Commands\InstallCommand;

use Illuminate\Support\ServiceProvider;

class MoneyServiceProvider extends ServiceProvider
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


        $this->mergeConfigFrom(
            __DIR__.'/../config/money.php', 'money'
        );

        $this->loadRoutesFrom(__DIR__.'/../routes/money.php');

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'money');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');        


        $this->publishes([
            __DIR__.'/../config/money.php' => config_path('money.php'),
        ]);

        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/money'),
        ]);


        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,

            ]);
        }

        $this->app['router']->aliasMiddleware('sendMoney', \Sashagm\Money\Http\Middleware\SendMoney::class);
        $this->app['router']->aliasMiddleware('abortMoney', \Sashagm\Money\Http\Middleware\AbortMoney::class);

    }
}
