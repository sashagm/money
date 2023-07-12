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

Наш пакет предоставляет функционал для перевода денег между пользователями в Laravel приложении.


### Оглавление:

- [Требования](#требования)
- [Установка](#установка)
- [Использование](#использование)
  - [Конфигурация](#конфигурация)
  - [Роллевая зависимость](#роллевая-зависимость)
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


#### Роллевая зависимость

В конфигурационном файле `config/money.php` отвечает раздел `check`. Здесь вы можете настроить права доступа.

```php

    'check'                     => [

        'active'                => true, // Включить или отключить проверку прав
        'guard'                 => 'web',  // Под каким гардам будем работать
        'save_colum'            => 'id',   // По какому полю будем искать для группы/роли
        'save_value'            => [
            2, 3
        ],                              // Укажите массив с данными для перевода
        'abort_value'           => [
            3
        ],                              // Укажите массив с данными для отмены перевода

    ],

```
Виды прав доступа:

- `Певеводы` Для переводов есть ролевая зависимость, вы можете назначить группу/роль для доступа к данному модулю. Перевод и отмена перевода.


#### Дополнительные возможности

Наш пакет предоставляет ряд дополнительных возможностей, которые могут быть полезны при работе с темами:

- `php artisan money:install` - Данная команда установит все необходимые компоненты пакета.


#### Тестирование

Для проверки работоспособности можно выполнить специальную команду:

- ./vendor/bin/phpunit --configuration phpunit.xml

#### Лицензия

Этот пакет доступен на условиях лицензии MIT. Подробнее о лицензии можно узнать в файле LICENSE.