<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModulePayment\Contracts\Data\WalletTransactionData as DataWalletTransactionData;
use Hanafalah\ModulePayment\Enums\WalletTransaction\TransactionType;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class WalletTransactionData extends Data implements DataWalletTransactionData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('name')]
    #[MapName('name')]
    public ?string $name = null;

    #[MapInputName('transaction_type')]
    #[MapName('transaction_type')]
    public string $transaction_type;

    #[MapInputName('wallet_id')]
    #[MapName('wallet_id')]
    public mixed $wallet_id = null;

    #[MapInputName('wallet_model')]
    #[MapName('wallet_model')]
    public ?object $wallet_model = null;

    #[MapInputName('user_wallet_id')]
    #[MapName('user_wallet_id')]
    public mixed $user_wallet_id;

    #[MapInputName('user_wallet_model')]
    #[MapName('user_wallet_model')]
    public ?object $user_wallet_model = null;

    #[MapInputName('reference_type')]
    #[MapName('reference_type')]
    public ?string $reference_type = null;

    #[MapInputName('reference_id')]
    #[MapName('reference_id')]
    public mixed $reference_id = null;

    #[MapInputName('consument_type')]
    #[MapName('consument_type')]
    public ?string $consument_type = null;

    #[MapInputName('consument_id')]
    #[MapName('consument_id')]
    public mixed $consument_id = null;

    #[MapInputName('consument_model')]
    #[MapName('consument_model')]
    public ?object $consument_model = null;

    #[MapInputName('nominal')]
    #[MapName('nominal')]
    public int $nominal;

    #[MapInputName('previous_balance')]
    #[MapName('previous_balance')]
    public int $previous_balance;

    #[MapInputName('current_balance')]
    #[MapName('current_balance')]
    public int $current_balance;

    #[MapInputName('author_type')]
    #[MapName('author_type')]
    public ?string $author_type = null;

    #[MapInputName('author_id')]
    #[MapName('author_id')]
    public mixed $author_id = null;

    #[MapInputName('reported_at')]
    #[MapName('reported_at')]
    public ?string $reported_at = null;

    #[MapInputName('reporting')]
    #[MapName('reporting')]
    public ?bool $reporting = null;

    #[MapInputName('status')]
    #[MapName('status')]
    public ?string $status = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;

    public static function before(array &$attributes){
        $new = static::new();

        if (isset($attributes['user_wallet_id'])){
            $user_wallet_model = $attributes['user_wallet_model'] ?? $new->UserWalletModel()->with([
                'wallet', 'consument'
            ])->findOrFail($attributes['user_wallet_id']);
        }else{
            $consument_model = $attributes['consument_model'] = $new->{$attributes['consument_type'].'Model'}()
                                    ->with(['userWallet' => function($query){
                                        $query->with('wallet')->where('props->prop_wallet->label','PERSONAL');
                                    }])
                                    ->findOrFail($attributes['consument_id']); 
            $user_wallet_model = $consument_model->userWallet;
            $attributes['user_wallet_id'] = $user_wallet_model->getKey();
        }
        $attributes['user_wallet_model'] ??= $user_wallet_model;
        $consument_model ??= $attributes['consument_model'] = $user_wallet_model->consument;
        $wallet_model = $attributes['wallet_model'] = $user_wallet_model->wallet;
        $attributes['wallet_id'] ??= $wallet_model->getKey();
        $attributes['consument_type'] ??= $consument_model->getMorphClass();
        $attributes['consument_id'] ??= $consument_model->getKey();
        $attributes['previous_balance'] ??= $user_wallet_model->balance ?? 0;
        $nominal = $attributes['nominal'];
        $current_balance = $attributes['previous_balance'] + 
            ($attributes['transaction_type'] == TransactionType::DEBIT->value ? -$nominal : $nominal);
        if ($current_balance < 0) throw new \Exception('Not enough balance');
        $attributes['current_balance'] = $current_balance;
    }

    public static function after(self $data): self{
        $new = self::new();
        $props = &$data->props;
        if (isset($data->reporting) && $data->reporting) $data->reported_at = now()->toDateTimeString();
        if (isset($data->reported_at)) $data->reporting ??= true;        
        return $data;
    }
}