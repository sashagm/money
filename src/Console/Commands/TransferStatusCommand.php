<?php

namespace Sashagm\Money\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Sashagm\Money\Models\Transfer;
use Illuminate\Support\Facades\Artisan;
use Sashagm\Money\Providers\MoneyServiceProvider;


class TransferStatusCommand extends Command
{
    protected $signature = 'money:status {--i= : Transfer ID} {--s= : Status (0 or 1)}';

    protected $description = 'Изменить статус перевода';

    public function handle()
    {
        $transferId = $this->option('i');
        $status = (int)$this->option('s');
       

        if (!$transferId) {
            $this->error('Требуются идентификатор и статус перевода.');
            return;
        }

        $transfer = Transfer::find($transferId);

        if (!$transfer) {
            $this->error('Перевод не найден.');
            return;
        }

        if (!in_array($status, [0, 1])) {
            $this->error('Недопустимое значение статуса. Статус должен быть равен 0 или 1.');
            return;
        }

        $transfer->status = $status;
        $transfer->save();

        $this->info('Статус перевода успешно изменен.');
    }
}