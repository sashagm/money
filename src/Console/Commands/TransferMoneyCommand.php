<?php

namespace Sashagm\Money\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Sashagm\Money\Models\Transfer;
use Illuminate\Support\Facades\Artisan;
use Sashagm\Money\Providers\MoneyServiceProvider;


class TransferMoneyCommand extends Command
{
    protected $signature = 'money:transfer {--i= : Transfer ID to display} {--u= : Field name for user search (name, nickname, email)}';

    protected $description = 'Отображение информации о денежном переводе.';

    public function handle()
    {
        $transferId = $this->option('i');
        $fieldName = $this->option('u');

        if (!$transferId) {
            $this->error('Требуется идентификатор перевода.');
            return;
        }

        $transfer = Transfer::find($transferId);

        if (!$transfer) {
            $this->error('Перевод не найден.');
            return;
        }

        $fromUser = $transfer->fromUser;
        $toUser = $transfer->toUser;

        if ($fieldName) {
            $fromUserField = $fromUser->$fieldName ?? '';
            $toUserField = $toUser->$fieldName ?? '';
        } else {
            $fromUserField = $fromUser->id;
            $toUserField = $toUser->id;
        }

        $this->info("ID: {$transfer->id}");
        $this->info("Кто: {$fromUserField}");
        $this->info("Кому: {$toUserField}");
        $this->info("Сумма: {$transfer->summa}");
        $this->info("Коммисия: {$transfer->free}");
        $this->info("Статус: {$transfer->status}");
    }
}