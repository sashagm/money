<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">

<a href="https://packagist.org/packages/sashagm/money"><img src="https://img.shields.io/packagist/dt/sashagm/money" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/sashagm/money"><img src="https://img.shields.io/packagist/v/sashagm/money" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/sashagm/money"><img src="https://img.shields.io/packagist/l/sashagm/money" alt="License"></a>
<a href="https://packagist.org/packages/sashagm/money"><img src="https://img.shields.io/github/languages/code-size/sashagm/money" alt="Code size"></a>
<a href="https://packagist.org/packages/sashagm/money"><img src="https://img.shields.io/packagist/stars/sashagm/money" alt="Code size"></a>

[![PHP Version](https://img.shields.io/badge/PHP-%2B8-blue)](https://www.php.net/)
[![Laravel Version](https://img.shields.io/badge/Laravel-%2B10-red)](https://laravel.com/)

</p>

## Laravel Transfer Package

Наш пакет предоставляет много функциональный компонент для вашего Laravel приложения. Который может быть полезным для приложений где необходимо добавить возможность использования валютного баланса пользователя.

Основной функционал:
- `Баланс пользователя`
- `Переводы между пользователями`
- `Ежедневный бонус`
- `Кастомные бонусы`


### Оглавление:

- [Требования](#требования)
- [Установка](#установка)
- [Использование](#использование)
  - [Конфигурация](#конфигурация)
  - [Ролевая зависимость](#ролевая-зависимость)
  - [Получение бонуса](#получение-бонуса)
  - [Кастомные бонусы](#кастомные-бонусы)
- [Дополнительные возможности](#дополнительные-возможности)
- [Тестирование](#тестирование)
- [Лицензия](#лицензия)

#### Требования

Основные требования для установки и корректной работы:

- `PHP` >= 8.0
- `Laravel` >= 10.x
- `Composer` >= 2.4.x

#### Установка

Для установки пакета необходимо выполнить команды:

- composer require sashagm/money
- php artisan money:install
#### Использование





#### Конфигурация

Вы можете изменить таблицы и модели, используемые для хранения пользователей и переводов, в конфигурационном файле `config/money.php`. 
Здесь показаны все настройки и описание параметров.

```php

    'admin_prefix'              => '',          // Префикс маршрутов
    'user_table'                => 'users',     // Пользовательская таблица
    'money_colum'               => 'money',     // Поле монет в пользовательской таблице
    'after_colum'               => 'password',  // После какого поля добавить поле валюты в пользовательской таблице

    'wallet'                    => [
        'code'                  => 'RUB',       // Код валюты
        'name'                  => 'руб',       // Имя валютиы
        'icon'                  => 'icon',      // Иконка валюты ( можно ввести html, svg, icons )
    ],

    'transfer'                  => [
        'active_send'           =>  true,  // Разрешить переводы
        'active_abort'          =>  true,  // Разрешить отмену
        'free_transfer'         =>  0.1,   // Коммиссия при переводе
        'min_trade'             =>  0.01,   // Минимальная сумма на перевод
        'abort_limit'           =>  false,  // Разрешить или Отменить ограничение отмены перевода
        'abort_time'            =>  24,     // Время (в часах) после которого нельзя отменить перевод
        'abort_clock'           => 'часов',  //
        'free_abort'            =>  true,   // Разрешить или Отменить комииссию для отмены
        'free_abort_transfer'   =>  0.1,    // Коммиссия при отмене переводе
    ],

    'check'                     => [
        'active'                => true, // Включить или отключить проверку прав
        'guard'                 => 'web',  // Под каким гардам будем работать
        'save_colum'            => 'id',   // По какому полю будем искать для группы/роли
        'save_value'            => [
            2, 3
        ],                              // Укажите массив с данными
        'abort_value'           => [
            3
        ],                              // Укажите массив с данными
        'bonus_value'           => [
            3
        ],                              // Укажите массив с данными 
    ],

    'bonus'                     => [

        'active'                => true,   // Разрешить или Отменить получение бонуса
        'min'                   => 100,    // Минимальная сумма (100 = 1.00)
        'max'                   => 10099,  // Максимальная сумма (10099 = 100.99)
        'nullable'              => true,   // Разрешать начисление бонуса в нулевое значение с шансом 50% (0.00)
        'chance'                => 50,   
    ],

    'custom'                    => [

        1                       => 'offline', 

    ],


```


#### Ролевая зависимость

В конфигурационном файле `config/money.php` отвечает раздел `check`. Здесь вы можете настроить права доступа.

```php

    'check'                     => [
        'active'                => true, // Включить или отключить проверку прав
        'guard'                 => 'web',  // Под каким гардам будем работать
        'save_colum'            => 'roles',   // По какому полю будем искать для группы/роли
        'save_value'            => [
            2, 3
        ],                              // Укажите массив с данными для перевода
        'abort_value'           => [
            3
        ],                              // Укажите массив с данными для отмены перевода
        'bonus_value'           => [
            2, 3
        ],                              // Укажите массив с данными для получения бонуса

    ],

```

В данном примере настроено так что `активна` проверка прав доступа. Искать пользователя будем через гард `web`.

Пользовательское поле по которому будем проверять `roles`.

Для переводов могут только пользователи с ролями `2,3` ( условно `ВИП, Премиум` )

Для отмены переводов могут только пользователи с ролями `3 `( условно `Премиум` )

Для получения бонуса могут только пользователи с ролями `2,3` ( условно `ВИП, Премиум `)



Виды прав доступа:

- `Переводы и возвраты` Для переводов есть ролевая зависимость, вы можете назначить группу/роль для доступа к данному модулю. 
- `Получение бонуса` Для получения бонусов есть ролевая зависимость, вы можете назначить группу/роль для доступа к данному модулю. 



#### Получение бонуса

Мы добавили возможность выдавать нашим пользователям ежедневный бонус в ввиде рандомного баланса. 

В конфигурационном файле `config/money.php` отвечает раздел `bonus`. Здесь вы можете настроить получение бонуса.

```php

    'bonus'                     => [

        'active'                => true,   // Разрешить или Отменить получение бонуса
        'min'                   => 100,    // Минимальная сумма (100 = 1.00)
        'max'                   => 10099,  // Максимальная сумма (10099 = 100.99)
        'nullable'              => true,   // Разрешать начисление бонуса в нулевое значение с шансом 50% (0.00)
        'chance'                => 50,   
    ],

```
#### Кастомные бонусы


#### Дополнительные возможности

Наш пакет предоставляет ряд дополнительных возможностей, которые могут быть полезны при работе с темами:

- `php artisan money:install` - Данная команда установит все необходимые компоненты пакета.
- `php artisan money:give {--u= : User ID or name} {--m= : Amount of money}` - Данная команда выполнит пополнение счёта пользователя.
- `php artisan money:pay  {--u= : User ID or email to deduct from} {--t= : User ID or email to transfer to} {--m= : Amount of money}` - Данная команда выполнит простой перевод счёта пользователя на другой аккаунт пользователя.
- `php artisan money:transfer {--i= : Transfer ID to display} {--u= : Field name for user search (name, nickname, email)}` - Данная команда выведет информацию о переводе.
- `php artisan money:send {--u= : User ID to send money from} {--t= : User ID to send money to} {--m= : Amount of money to send}` - Данная команда отправит деньги от одного пользователя другому с учётом коммиссиями.
- `php artisan money:abort {--i= : Transfer ID to abort}` - Данная команда отменит перевод и верните валюту обратно отправителю.
- `php artisan money:status {--i= : Transfer ID} {--s= : Status (0 or 1)}` - Данная команда изменит статус перевода.


#### Тестирование

Для проверки работоспособности можно выполнить специальную команду:

- ./vendor/bin/phpunit --configuration phpunit.xml

#### Лицензия

Laravel Transfer Package - это программное обеспечение с открытым исходным кодом, лицензированное по [MIT license](LICENSE.md ).