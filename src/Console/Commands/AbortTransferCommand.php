<?php

namespace Sashagm\Money\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Sashagm\Money\Models\Transfer;

use Carbon\Carbon;


class AbortTransferCommand extends Command
{
    protected $signature = 'money:abort {--i= : Transfer ID to abort}';

    protected $description = 'Прервите денежный перевод и верните валюту обратно отправителю';

    public function handle()
    {
        $transferId = $this->option('i');

        if (!$transferId) {
            $this->error('Требуется идентификатор перевода.');
            return;
        }

        $transfer = Transfer::find($transferId);

        if (!$transfer) {
            $this->error('Перевод не найден.');
            return;
        }

        if ($transfer->status != 1) {
            $this->error('Передача не может быть прервана.');
            return;
        }

        // Check if abort limit is enabled and if the transfer is within the time limit
        if (config('money.transfer.abort_limit')) {
            $created_at = Carbon::parse($transfer->created_at);
            $now = Carbon::now();
            $diffInHours = $created_at->diffInHours($now);

            if ($diffInHours > config('money.transfer.abort_time')) {
                $this->error('Передача не может быть прервана, превышен лимит времени.');
                return;
            }
        }

        $fromUser = User::find($transfer->from_id);
        $toUser = User::find($transfer->to_id);
        $money = config('money.money_colum');

        if (config('money.transfer.free_abort')) {
            $commission = $transfer->summa * config('money.transfer.free_abort_transfer');
        } else {
            $commission = 0;
        }

        // Return currency back to sender
        $fromUser->$money += (int) $transfer->summa - $commission;
        $fromUser->save();

        // Deduct currency from receiver
        $toUser->$money -= (int) $transfer->summa;
        $toUser->save();

        // Update transfer status
        $transfer->status = 0;
        $transfer->save();

        $this->info('Передача успешно прервана.');
    }
}