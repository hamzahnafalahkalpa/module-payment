<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModulePayment\Contracts\Data\SplitPaymentData as DataSplitPaymentData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class SplitPaymentData extends Data implements DataSplitPaymentData
{
    #[MapName('id')]
    #[MapInputName('id')]
    public mixed $id = null;

    #[MapName('payment_method_id')]
    #[MapInputName('payment_method_id')]
    public mixed $payment_method_id;

    #[MapName('payment_method_model')]
    #[MapInputName('payment_method_model')]
    public ?object $payment_method_model;

    #[MapName('invoice_id')]
    #[MapInputName('invoice_id')]
    public mixed $invoice_id = null;

    #[MapName('invoice_model')]
    #[MapInputName('invoice_model')]
    public ?object $invoice_model = null;

    #[MapName('money_paid')]
    #[MapInputName('money_paid')]
    public ?int $money_paid = null;

    #[MapName('paid')]
    #[MapInputName('paid')]
    public ?int $paid = 0;

    #[MapName('props')]
    #[MapInputName('props')]
    public ?array $props = null;

    public static function after(self $data): self{
        $new = static::new();

        $props = &$data->props;
        $props['paid_money'] ??= 0;
        $props['cash_over']  ??= 0;
        $props['note']       ??= '';

        $data->payment_method_model = $payment_method_model = $new->PaymentMethodModel()->findOrFail($data->payment_method_id);
        $props['payment_method'] = $payment_method_model->toViewApiOnlies('id','name','flag','label');
        return $data;
    }
}
