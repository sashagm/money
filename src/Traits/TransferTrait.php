<?php

namespace  Sashagm\Money\Traits;


use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sashagm\Money\Models\Transfer;
use Illuminate\Support\Facades\Auth;
use Sashagm\Money\Http\Requests\TransferRequest;


trait TransferTrait
{
    public function send_proccess(TransferRequest $request)
    {

        

    }

    public function abort_proccess(Request $request)
    {

  

    }
}

