<?php

namespace Sashagm\Money\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Sashagm\Money\Providers\MoneyServiceProvider;


class PayMoneyCommand extends Command
{
    protected $signature = 'money:pay {--u= : User ID or email to deduct from} {--t= : User ID or email to transfer to} {--m= : Amount of money}';

    protected $description = 'Переводить деньги от одного пользователя к другому.';

    public function handle()
    {
        $userIdOrEmailFrom = $this->option('u');
        $userIdOrEmailTo = $this->option('t');
        $amount = $this->option('m');

        if (!$userIdOrEmailFrom || !$userIdOrEmailTo || !$amount) {
            $this->error('Требуются идентификаторы пользователей или электронные письма и сумма денег.');
            return;
        }

        $userFrom = User::where('id', $userIdOrEmailFrom)
                    ->orWhere('email', $userIdOrEmailFrom)
                    ->first();

        if (!$userFrom) {
            $this->error('Пользователю для списания денег с не найденного.');
            return;
        }

        $userTo = User::where('id', $userIdOrEmailTo)
                    ->orWhere('email', $userIdOrEmailTo)
                    ->first();

        if (!$userTo) {
            $this->error('Пользователь для перевода денег не найден.');
            return;
        }

        $moneyColumn = config('money.money_colum');

        if ($userFrom->$moneyColumn < $amount) {
            $this->error('У пользователя недостаточно денег для осуществления перевода.');
            return;
        }

        $userFrom->$moneyColumn -= (int) $amount;
        $userTo->$moneyColumn += (int) $amount;

        $userFrom->save();
        $userTo->save();

        $this->info('Деньги успешно переведены от пользователя к пользователю.');
    }
}