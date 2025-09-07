<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModulePayment\Contracts\Data\PaymentSummaryData as DataPaymentSummaryData;
use Hanafalah\ModulePayment\Contracts\Data\PaymentSummaryPropsData;
use Hanafalah\ModuleTax\Contracts\Data\TotalTaxData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class PaymentSummaryData extends Data implements DataPaymentSummaryData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('parent_id')]
    #[MapName('parent_id')]
    public mixed $parent_id = null;

    #[MapInputName('transaction_id')]
    #[MapName('transaction_id')]
    public mixed $transaction_id = null;

    #[MapInputName('reference_type')]
    #[MapName('reference_type')]
    public ?string $reference_type = null;

    #[MapInputName('reference_id')]
    #[MapName('reference_id')]
    public mixed $reference_id = null;

    #[MapInputName('reference_model')]
    #[MapName('reference_model')]
    public ?object $reference_model = null;

    #[MapInputName('amount')]
    #[MapName('amount')]
    public ?float $amount = null;

    #[MapInputName('discount')]
    #[MapName('discount')]
    public ?float $discount = 0;

    #[MapInputName('debt')]
    #[MapName('debt')]
    public ?int $debt = null;

    #[MapInputName('paid')]
    #[MapName('paid')]
    public ?int $paid = 0;

    #[MapInputName('tax')]
    #[MapName('tax')]
    public ?int $tax = 0;

    #[MapInputName('cogs')]
    #[MapName('cogs')]
    public ?int $cogs = 0;

    #[MapInputName('total_tax')]
    #[MapName('total_tax')]
    public ?TotalTaxData $total_tax = null;

    #[MapInputName('additional')]
    #[MapName('additional')]
    public ?int $additional = 0;

    #[MapInputName('payment_details')]
    #[MapName('payment_details')]
    #[DataCollectionOf(PaymentDetailData::class)]
    public ?array $payment_details = null;

    #[MapInputName('payment_summaries')]
    #[MapName('payment_summaries')]
    #[DataCollectionOf(PaymentSummaryData::class)]
    public ?array $payment_summaries = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?PaymentSummaryPropsData $props = null;

    public static function before(array &$attributes){
        $attributes['total_tax'] ??= [
            'total' => 0
        ];
    }
}
