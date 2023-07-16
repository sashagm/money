<?php

namespace Sashagm\Money\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Sashagm\Money\Models\Transfer;
use Illuminate\Support\Facades\Artisan;
use Sashagm\Money\Providers\MoneyServiceProvider;


class SendMoneyCommand extends Command
{
    protected $signature = 'money:send {--u= : User ID to send money from} {--t= : User ID to send money to} {--m= : Amount of money to send}';

    protected $description = 'Отправляйте деньги от одного пользователя другому';

    public function handle()
    {
        $userId = $this->option('u');
        $toUserId = $this->option('t');
        $amount = $this->option('m');

        if (!$userId || !$toUserId || !$amount) {
            $this->error('Требуется идентификатор пользователя, к идентификатору пользователя и сумма.');
            return;
        }

        $user = User::find($userId);

        if (!$user) {
            $this->error('Пользователь не найден.');
            return;
        }

        $toUser = User::find($toUserId);

        if (!$toUser) {
            $this->error('Пользователь кому не найден.');
            return;
        }

        $money = config('money.money_colum');
        $commission = $amount * config('money.transfer.free_transfer');

        if ($commission <= (int) config('money.transfer.min_trade')) {
            $this->error("Вы не можете отправить меньше, чем " . config('money.transfer.min_trade') . "!");
            return;
        }

        if ($user->id == $toUser->id) {
            $this->error("Вы не можете отправить деньги самому себе!");
            return;
        }

        if ((int) $user->$money >= (int) $amount + $commission) {
            // Deduct money from sender
            $user->$money -= (int) $amount + $commission;
            $user->save();

            // Add money to receiver
            $toUser->$money += (int) $amount;
            $toUser->save();

            // Create transfer record
            $transfer = new Transfer;
            $transfer->from_id = $user->id;
            $transfer->to_id = $toUser->id;
            $transfer->summa = $amount;
            $transfer->free = $commission;
            $transfer->status = 1;
            $transfer->save();

            $this->info('Деньги отправлены успешно.');
        } else {
            $this->error('Недостаточно средств для отправки денег.');
        }
    }
}
