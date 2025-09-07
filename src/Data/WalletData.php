<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\ModulePayment\Contracts\Data\WalletData as DataWalletData;

class WalletData extends FinanceStuffData implements DataWalletData
{    
    public static function before(array &$attributes){
        $attributes['flag'] ??= 'Wallet';
        parent::before($attributes);
    }
}