<?php

namespace Sashagm\Money\Providers;

use Sashagm\Money\Traits\BootTrait;

use Illuminate\Support\ServiceProvider;
use Sashagm\Money\Console\Commands\InstallCommand;
use Sashagm\Money\Console\Commands\PayMoneyCommand;
use Sashagm\Money\Console\Commands\GiveMoneyCommand;
use Sashagm\Money\Console\Commands\SendMoneyCommand;
use Sashagm\Money\Console\Commands\AbortTransferCommand;
use Sashagm\Money\Console\Commands\TransferMoneyCommand;
use Sashagm\Money\Console\Commands\TransferStatusCommand;

class MoneyServiceProvider extends ServiceProvider
{

    use BootTrait;

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

        $this->preLoad();

        $this->registerRouter();

        $this->registerLang();

        $this->registerMigrate();

        $this->publishFiles();

        $this->registerCommands();

        $this->bootSys();
    }



    protected function registerRouter()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/money.php');
    }

    protected function registerMigrate()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    protected function preLoad()
    {

        $this->mergeConfigFrom(
            __DIR__ . '/../config/money.php',
            'money'
        );
    }

    protected function publishFiles()
    {

        $this->publishes([
            __DIR__ . '/../config/money.php' => config_path('money.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/money'),
        ]);
    }

    protected function registerLang()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'money');
    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                GiveMoneyCommand::class,
                PayMoneyCommand::class,
                TransferMoneyCommand::class,
                SendMoneyCommand::class,
                AbortTransferCommand::class,
                TransferStatusCommand::class,
            ]);
        }
    }
}
