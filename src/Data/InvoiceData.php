<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModulePayment\Contracts\Data\InvoiceData as DataInvoiceData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class InvoiceData extends Data implements DataInvoiceData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('author_type')]
    #[MapName('author_type')]
    public ?string $author_type = null;

    #[MapInputName('author_id')]
    #[MapName('author_id')]
    public mixed $author_id = null;

    #[MapInputName('consument_type')]
    #[MapName('consument_type')]
    public string $consument_type;

    #[MapInputName('consument_id')]
    #[MapName('consument_id')]
    public mixed $consument_id;

    #[MapInputName('consument_model')]
    #[MapName('consument_model')]
    public ?object $consument_model;

    #[MapInputName('paid_at')]
    #[MapName('paid_at')]
    public ?string $paid_at = null;

    #[MapInputName('generated_at')]
    #[MapName('generated_at')]
    public ?string $generated_at = null;

    #[MapInputName('billing_at')]
    #[MapName('billing_at')]
    public ?string $billing_at = null;

    #[MapInputName('payment_summary')]
    #[MapName('payment_summary')]
    public ?PaymentSummaryData $payment_summary = null;

    #[MapInputName('payment_summary_ids')]
    #[MapName('payment_summary_ids')]
    public ?array $payment_summary_ids = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;

    public static function after(InvoiceData $data): InvoiceData{
        $new = self::new();
        $props = &$data->props;

        $consument = $new->{$data->consument_type.'Model'}()->findOrFail($data->consument_id);
        $props['prop_consument'] = $consument->toViewApi()->resolve();

        return $data;
    }
}
