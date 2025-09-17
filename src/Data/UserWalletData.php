<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModulePayment\Contracts\Data\UserWalletData as DataUserWalletData;
use Hanafalah\ModulePayment\Enums\UserWallet\Status;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class UserWalletData extends Data implements DataUserWalletData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('wallet_id')]
    #[MapName('wallet_id')]
    public mixed $wallet_id = null;

    #[MapInputName('wallet_model')]
    #[MapName('wallet_model')]
    public ?object $wallet_model = null;

    #[MapInputName('consument_type')]
    #[MapName('consument_type')]
    public ?string $consument_type = null;

    #[MapInputName('consument_id')]
    #[MapName('consument_id')]
    public mixed $consument_id = null;

    #[MapInputName('balance')]
    #[MapName('balance')]
    public ?int $balance = null;

    #[MapInputName('verified_at')]
    #[MapName('verified_at')]
    public ?string $verified_at = null;

    #[MapInputName('verifying')]
    #[MapName('verifying')]
    public ?bool $verifying = null;

    #[MapInputName('suspended_at')]
    #[MapName('suspended_at')]
    public ?string $suspended_at = null;

    #[MapInputName('suspending')]
    #[MapName('suspending')]
    public ?bool $suspending = null;

    #[MapInputName('status')]
    #[MapName('status')]
    public ?string $status = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;

    public static function before(array &$attributes){
        $attributes['balance'] ??= 0;
        if (isset($attributes['verifying']) && $attributes['verifying']){
            $attributes['verified_at'] = now();
            $attributes['status'] = Status::REPORTED->value;
        }elseif(isset($attributes['suspending']) && $attributes['suspending']){
            $attributes['suspended_at'] = now();
            $attributes['status'] = Status::SUSPENDED->value;
        }
    }

    public static function after(self $data): self{
        $new = static::new();

        $props = &$data->props;
        if (isset($data->wallet_id)){
            $data->wallet_model = $wallet_model = $new->WalletModel()->findOrFail($data->wallet_id);
            $props['prop_wallet'] = $wallet_model->toViewApiOnlies('id','name','flag','label');
        }
        $data->wallet_id ??= $data->wallet_model->getKey();
        return $data;
    }
}