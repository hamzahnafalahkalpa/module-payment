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
            $wallet_transaction = &$attributes['wallet_transaction'];
            if (!isset($attributes['user_wallet_id'])){
                $user_wallet = $new->UserWalletModel()
                            ->with(['wallet', 'consument'])
                            ->where('props->prop_wallet->label','PERSONAL')
                            ->where('consument_type',$attributes['consument_type'])
                            ->where('consument_id',$attributes['consument_id'])
                            ->firstOrFail();
                $wallet_transaction['user_wallet_id'] = $user_wallet->getKey();
                $wallet_transaction['user_wallet_model'] = $user_wallet;
            }
            $wallet_transaction['name'] ??= $attributes['name'];
            $wallet_transaction['transaction_type'] = TransactionType::CREDIT->value;
            $wallet_transaction['reference_type'] = 'Deposit';
        }
    }
}