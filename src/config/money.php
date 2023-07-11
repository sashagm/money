<?php


return [


    'user_table'        => 'users',     // Пользовательская таблица
    'money_colum'       => 'money',     // Поле монет в пользовательской таблице
    'after_colum'       => 'password',  // После какого поля добавить поле валюты в пользовательской таблице

    'wallet'            => [
        
        'code'          => 'RUB',       // Код валюты
        'name'          => 'руб',       // Имя валютиы
        'icon'          => 'icon',      // иконка валюты ( можно ввести html, svg, icons )

    ],

    'transfer'          => [

        'active_send'       =>  true,  // Разрешить переводы
        'active_abort'      =>  true,  // Разрешить отмену
        'free_transfer'     =>  0.1,   // Коммиссия при переводе
        'min_trade'         =>  0.01,   // Минимальная сумма на перевод
        'abort_limit'       =>  false,  // Разрешить или Отменить ограничение отмены перевода
        'abort_time'        =>  24,     // Время (в часах) после которого нельзя отменить перевод
        'abort_clock'       => 'часов'  //


    ],





];