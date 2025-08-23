<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModulePayment\Contracts\Data\SplitBillData as DataSplitBillData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class SplitBillData extends Data implements DataSplitBillData
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

    #[MapName('billing_id')]
    #[MapInputName('billing_id')]
    public mixed $billing_id = null;

    #[MapName('billing_model')]
    #[MapInputName('billing_model')]
    public ?object $billing_model = null;

    #[MapName('paid')]
    #[MapInputName('paid')]
    public ?int $paid = null;

    #[MapName('discount')]
    #[MapInputName('discount')]
    public ?int $discount = null;

    #[MapName('invoice_id')]
    #[MapInputName('invoice_id')]
    public mixed $invoice_id = null;

    #[MapName('payer_id')]
    #[MapInputName('payer_id')]
    public mixed $payer_id = null;

    #[MapName('payer_type')]
    #[MapInputName('payer_type')]
    public ?string $payer_type = null;

    #[MapName('props')]
    #[MapInputName('props')]
    public ?array $props = null;

    public static function after(self $data): self{
        $new = static::new();

        $props = &$data->props;
        $props['paid_money'] ??= 0;
        $props['cash_over'] ??= 0;
        $props['note'] ??= '';

        $data->payment_method_model = $payment_method_model = $new->PaymentMethodModel()->findOrFail($data->payment_method_id);
        $props['payment_method'] = $payment_method_model->toViewApi()->resolve();
        
        return $data;
    }
}
