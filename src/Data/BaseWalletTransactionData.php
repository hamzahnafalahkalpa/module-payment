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
}