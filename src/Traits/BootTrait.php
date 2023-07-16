<?php

namespace  Sashagm\Money\Traits;



trait BootTrait
{


    public function bootSys()
    {

        $this->app['router']->aliasMiddleware('sendMoney', \Sashagm\Money\Http\Middleware\SendMoney::class);
        $this->app['router']->aliasMiddleware('abortMoney', \Sashagm\Money\Http\Middleware\AbortMoney::class);
        $this->app['router']->aliasMiddleware('getBonus', \Sashagm\Money\Http\Middleware\GetBonus::class);

    }




}
