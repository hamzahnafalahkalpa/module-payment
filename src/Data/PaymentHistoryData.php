<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\ModulePayment\Contracts\Data\PaymentHistoryData as DataPaymentHistoryData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class PaymentHistoryData extends PaymentSummaryData implements DataPaymentHistoryData
{
    #[MapInputName('payment_history_details')]
    #[MapName('payment_history_details')]
    #[DataCollectionOf(PaymentHistoryDetailData::class)]
    public ?array $payment_history_details = null;

    #[MapInputName('payment_has_models')]
    #[MapName('payment_has_models')]
    #[DataCollectionOf(PaymentHasModelData::class)]
    public ?array $payment_has_models = null;

    #[MapInputName('childs')]
    #[MapName('childs')]
    #[DataCollectionOf(PaymentHistoryData::class)]
    public ?array $childs = null;

    public static function before(array &$attributes){
        parent::before($attributes);
        $new = static::new();
    }
}
