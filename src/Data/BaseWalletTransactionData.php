<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModulePayment\Contracts\Data\BaseWalletTransactionData as DataBaseWalletTransactionData;
use Hanafalah\ModulePayment\Contracts\Data\BaseWalletTransactionPropsData;
use Hanafalah\ModulePayment\Contracts\Data\WalletTransactionData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class BaseWalletTransactionData extends Data implements DataBaseWalletTransactionData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('code')]
    #[MapName('code')]
    public ?string $code = null;

    #[MapInputName('name')]
    #[MapName('name')]
    public string $name;

    #[MapInputName('channel_id')]
    #[MapName('channel_id')]
    public mixed $channel_id = null;

    #[MapInputName('channel_model')]
    #[MapName('channel_model')]
    public ?object $channel_model = null;

    #[MapInputName('wallet_transaction')]
    #[MapName('wallet_transaction')]
    public ?WalletTransactionData $wallet_transaction = null;

    #[MapName('withdrawal')]
    #[MapInputName('withdrawal')]
    public ?WithdrawalData $withdrawal = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?BaseWalletTransactionPropsData $props = null;

    public static function before(array &$attributes){
        $new = static::new();        

        if (isset($attributes['channel_id'])){
            $attributes['channel_model'] = $channel_model = $new->ChannelModel()->findOrFail($attributes['channel_id']);
            $attributes['prop_channel'] = $channel_model->toViewApi()->resolve();        
        }
    }

    protected function initWithdrawal(){
        $new = static::new();
    }

    protected function initWalletTransaction(array &$attributes, string $transaction_type, string $transaction_type_value){
        $new = static::new();
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
        $wallet_transaction['transaction_type'] = $transaction_type_value;
        $wallet_transaction['reference_type'] = $transaction_type;
    }
}