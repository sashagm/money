<?php

namespace Sashagm\Money\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        $money = config('money.money_colum');

        return [
            'to_id' => "required|exists:config('money.user_table'),id",
            'summa' => "required|numeric|min:config('money.transfer.min_trade')|max:" . auth()->user()->$money,
        ];
    }

    public function messages()
    {
        return [
            'to_id.required' => 'Поле "Кому" обязательно для заполнения!',
            'to_id.exists' => 'Пользователь с таким ID не найден!',
            'summa.required' => 'Поле "Сумма" обязательно для заполнения!',
            'summa.numeric' => 'Поле "Сумма" должно быть числом!',
            'summa.min' => "Минимальная сумма перевода: config('money.transfer.min_trade') config('money.wallet.name').",
            'summa.max' => 'Недостаточно средств на счете!',
        ];
    }
}
