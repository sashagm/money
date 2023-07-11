<?php

namespace Sashagm\Money\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Sashagm\Money\Models\Transfer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Sashagm\Money\Http\Requests\TransferRequest;

class TransferController extends Controller
{

    public function send(TransferRequest $request)
    {
        $user = User::find(Auth::user())->first();
        $toUser = User::find($request->input('to_id'));
        $summa = $request->input('summa');
        $commission = $summa * config('money.transfer.free_transfer');

        $money = config('money.money_colum');

        if($commission <= (int) config('money.transfer.min_trade')) {

            return redirect()->back()->with('error', "Вы не можете отправить меньше чем ". config('money.transfer.min_trade') . "!");

        }
  

        if($user->id == $toUser->id) {

            return redirect()->back()->with('error', "Вы не можете отправить самому себе же!");

        }        

   

        if ((int) $user->$money >= (int) $summa + $commission) {
            
            $user->$money -= (int) $summa + $commission;
            $toUser->$money += (int) $summa;
            $user->save();
            $toUser->save();

            $transfer = new Transfer;
            $transfer->from_id = $user->id;
            $transfer->to_id = $toUser->id;
            $transfer->summa = $summa;
            $transfer->free = $commission;
            $transfer->status = 1;
            $transfer->save();

            return redirect()->back()->with('success', 'Перевод выполнен успешно!');
        } else {
            return redirect()->back()->with('error', 'Недостаточно средств для перевода!');
        }
    }

    public function abort(Request $request)
    {
        $transfer = Transfer::find($request->input('transfer_id'));
        $money = config('money.money_colum');
        

        if ($transfer && $transfer->status == 1) {
            $user = User::find($transfer->from_id);
            $user->$money += (int) $transfer->summa;
            $user->save();

            $user2 = User::find($transfer->to_id);
            $user2->$money -= (int) $transfer->summa;
            $user2->save();

            $transfer->status = 0;
            $transfer->save();

            // Проверяем, прошло ли более 24 часов с момента создания перевода
            $created_at = Carbon::parse($transfer->created_at);
            $now = Carbon::now();
            $diffInHours = $created_at->diffInHours($now);

            if (config('money.transfer.abort_limit')) {

                if ($diffInHours > config('money.transfer.abort_time')) {
                    return redirect()->back()->with('error', "Невозможно отменить перевод, прошло более config('money.transfer.abort_time') часов!");
                }

            } 

            return redirect()->back()->with('success', 'Перевод отменен успешно!');
        } else {
            return redirect()->back()->with('error', 'Невозможно отменить перевод!');
        }
    }
}
