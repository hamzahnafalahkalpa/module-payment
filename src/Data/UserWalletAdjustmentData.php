<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModulePayment\Contracts\Data\UserWalletAdjustmentData as DataUserWalletAdjustmentData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class UserWalletAdjustmentData extends Data implements DataUserWalletAdjustmentData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id;

    #[MapInputName('user_wallet_model')]
    #[MapName('user_wallet_model')]
    public ?object $user_wallet_model;

    #[MapInputName('balance')]
    #[MapName('balance')]
    public int $balance;

    public static function after(self $data): self{
        $new = static::new();
        if (!isset($data->user_wallet_model)){
            $data->user_wallet_model = $new->UserWalletModel()->findOrFail($data->id);
        }
        return $data;
    }
}