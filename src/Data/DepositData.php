<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\ModulePayment\Contracts\Data\DepositData as DataDepositData;
use Hanafalah\ModulePayment\Enums\WalletTransaction\TransactionType;

class DepositData extends BaseWalletTransactionData implements DataDepositData
{
    public static function before(array &$attributes){
        $new = static::new();
        parent::before($attributes);
        if (isset($attributes['wallet_transaction'])){
            $new->initWalletTransaction($attributes,'Deposit',TransactionType::CREDIT->value);            
        }
    }
}