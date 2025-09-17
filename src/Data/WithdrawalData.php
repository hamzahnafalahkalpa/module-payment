<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\ModulePayment\Contracts\Data\WithdrawalData as DataWithdrawalData;
use Hanafalah\ModulePayment\Enums\WalletTransaction\TransactionType;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class WithdrawalData extends BaseWalletTransactionData  implements DataWithdrawalData
{
    #[MapName('reference_id')]
    #[MapInputName('reference_id')]
    public mixed $reference_id = null;

    #[MapName('reference_type')]
    #[MapInputName('reference_type')]
    public ?string $reference_type = null;

    public static function before(array &$attributes){
        $new = static::new();
        parent::before($attributes);
        if (isset($attributes['wallet_transaction'])){
            $new->initWalletTransaction($attributes,'Withdrawal',TransactionType::DEBIT->value);            
        }                
    }
}