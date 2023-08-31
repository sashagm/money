<?php

namespace Sashagm\Money\Http\Controllers;

use Carbon\Carbon;

use App\Models\User;
use Illuminate\Http\Request;
use Sashagm\Money\Models\Bonus;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BonusController extends Controller
{


    public function getBonus(Request $request)
    {
        if(!config('money.bonus.active')) {
            return redirect()
            ->back()
            ->with('error', "Получение бонуса временно отключено!");
        }


        $user = User::find(Auth::user())->first();

        $lastBonus = Bonus::where('user_id', $user->id)
            ->where('status', 1)
            ->latest()
            ->first();

        if ($lastBonus && Carbon::now()->diffInHours($lastBonus->created_at) < 24) {


            return redirect()
            ->back()
            ->with('error', 'Вы можете получить бонус только один раз в день!');

        }

        $randomAmount = rand(config('money.bonus.min'), config('money.bonus.max')) / 100;

        if (rand(1, 100) <= config('money.bonus.chance')) {
            // Бонус выпал
        } else {
            $randomAmount = 0;
        }

  
        $bonus = new Bonus();
        $bonus->user_id = $user->id;
        $bonus->summa = $randomAmount;
        $bonus->save();

        $user->money += $randomAmount;
        $user->save();

        return redirect()
        ->back()
        ->with('success', 'Бонус успешно получен, сумма:  '. $randomAmount  );


    }

 
    public function customBonus($id, Request $request)
    {

        $customBonuses = config('money.custom');

        if (isset($customBonuses[$id])) {

        echo "Process...";
        
        } else {
            return redirect()->back()->with('error', 'Такой бонус не найден!');
        }


    }


    
}
