<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModulePayment\Contracts\Data\PaymentDetailData as DataPaymentDetailData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\BooleanType;

class PaymentDetailData extends Data implements DataPaymentDetailData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('parent_id')]
    #[MapName('parent_id')]
    public mixed $parent_id = null;

    #[MapInputName('name')]
    #[MapName('name')]
    public ?string $name = null;

    #[MapInputName('payment_summary_id')]
    #[MapName('payment_summary_id')]
    public mixed $payment_summary_id;

    #[MapInputName('transaction_item_id')]
    #[MapName('transaction_item_id')]
    public mixed $transaction_item_id;

    #[MapInputName('is_loan')]
    #[MapName('is_loan')]
    #[BooleanType]
    public ?bool $is_loan = false;

    #[MapInputName('qty')]
    #[MapName('qty')]
    public ?float $qty = 1;

    #[MapInputName('price')]
    #[MapName('price')]
    public ?int $price = 0;

    #[MapInputName('amount')]
    #[MapName('amount')]
    public ?int $amount = null;

    #[MapInputName('debt')]
    #[MapName('debt')]
    public ?int $debt = null;

    #[MapInputName('discount')]
    #[MapName('discount')]
    public ?int $discount = null;

    #[MapInputName('paid')]
    #[MapName('paid')]
    public ?int $paid = 0;

    #[MapInputName('cogs')]
    #[MapName('cogs')]
    public ?int $cogs = 0;

    #[MapInputName('tax')]
    #[MapName('tax')]
    public ?int $tax = 0;

    #[MapInputName('additional')]
    #[MapName('additional')]
    public ?int $additional = 0;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;
    
    public static function after (PaymentDetailData $data): PaymentDetailData{
        $data->amount ??= (($data->price * $data->qty) + $data->additional + $data->tax);
        $data->debt   ??= $data->amount;
        $data->discount ??= 0;
        return $data;
    }
}
