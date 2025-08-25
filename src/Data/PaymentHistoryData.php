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

    #[MapInputName('childs')]
    #[MapName('childs')]
    #[DataCollectionOf(PaymentHistoryData::class)]
    public ?array $childs = null;

    public static function before(array &$attributes){
        parent::before($attributes);
        $new = static::new();
        if (isset($attributes['form'])){
            $form = &$attributes['form'];
            if (isset($form['payment_summaries']) && count($form['payment_summaries']) > 0) {
                $attributes['childs'] = [];
                $childs = &$attributes['childs'];
                foreach ($form['payment_summaries'] as &$payment_summary) {
                    $payment_summary_model = $new->PaymentSummaryModel()->findOrFail($payment_summary['id']);
                    $child['id'] = null;
                }
            }
        }
    }
}
