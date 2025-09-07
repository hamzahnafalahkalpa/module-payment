<?php

namespace Hanafalah\ModulePayment\Models\Consument;

use Hanafalah\ModulePayment\Models\Price\FinanceStuff;
use Hanafalah\ModulePayment\Resources\Wallet\{
    ViewWallet,
    ShowWallet
};

class Wallet extends FinanceStuff
{
    protected $table = 'unicodes';

    public function getViewResource(){
        return ViewWallet::class;
    }

    public function getShowResource(){
        return ShowWallet::class;
    }
}
