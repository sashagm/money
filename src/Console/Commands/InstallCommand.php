<?php

namespace Sashagm\Money\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Sashagm\Money\Providers\MoneyServiceProvider;


class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'money:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Данная команда создаст необходимые файлы.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->components->info('Установка пакета...');
        $this->install();
        $this->components->info('Установка завершена!');
        
    }

    protected function install(): void
    {
        Artisan::call('vendor:publish', [
            '--provider' => MoneyServiceProvider::class,
            '--force' => true,
        ]);
        $this->components->info('Сервис провайдер опубликован...');

        Artisan::call('migrate');
        $this->components->info('Миграции выполнены...');
 
    }



}