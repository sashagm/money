<?php

namespace Sashagm\Money\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Sashagm\Money\Providers\MoneyServiceProvider;


class GiveMoneyCommand extends Command
{
    protected $signature = 'money:give {--u= : User ID or name} {--m= : Amount of money}';

    protected $description = 'Выдать монет пользователю.';

    public function handle()
    {
        $userIdOrEmail = (int)$this->option('u');
        $amount =(int) $this->option('m');

        if (!$userIdOrEmail || !$amount) {
            $this->error('Требуется идентификатор пользователя или имя и сумма денег.');
            return;
        }
        

        $user = User::where('id', $userIdOrEmail)
                    ->orWhere('name', $userIdOrEmail)
                    ->first();
        
        
        if (!$user) {
            $this->error('Пользователь не найден!');
            return;
        }

        $moneyColumn = config('money.money_colum');
        $icon = " ".config('money.wallet.name');
        $user->$moneyColumn += (int) $amount;
        $user->save();

        $this->info('Деньги успешно зачислены на счет пользователя : '. $user->name  .', сумма: +'. $amount . $icon);
    }
}