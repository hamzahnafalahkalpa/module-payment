<?php

namespace Hanafalah\ModulePayment\Data;

use Carbon\Carbon;
use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModulePayment\Contracts\Data\BillingData as DataBillingData;
use Hanafalah\ModulePayment\Enums\Billing\Status;
use Hanafalah\ModuleTransaction\Contracts\Data\TransactionData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class BillingData extends Data implements DataBillingData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('uuid')]
    #[MapName('uuid')]
    public mixed $uuid = null;

    #[MapInputName('has_transaction_id')]
    #[MapName('has_transaction_id')]
    public mixed $has_transaction_id;

    #[MapInputName('has_transaction')]
    #[MapName('has_transaction')]
    public ?TransactionData $has_transaction = null;

    #[MapInputName('has_transaction_model')]
    #[MapName('has_transaction_model')]
    public ?object $has_transaction_model = null;

    #[MapInputName('transaction')]
    #[MapName('transaction')]
    public ?TransactionData $transaction = null;

    #[MapInputName('author_type')]
    #[MapName('author_type')]
    public ?string $author_type = null;

    #[MapInputName('author_id')]
    #[MapName('author_id')]
    public ?string $author_id = null;

    #[MapInputName('cashier_type')]
    #[MapName('cashier_type')]
    public ?string $cashier_type = null;

    #[MapInputName('cashier_id')]
    #[MapName('cashier_id')]
    public mixed $cashier_id = null;

    #[MapInputName('status')]
    #[MapName('status')]
    public ?string $status = Status::DRAFT->value;

    #[MapInputName('deferred_payments')]
    #[MapName('deferred_payments')]      
    #[DataCollectionOf(DeferredPaymentData::class)]
    public ?array $deferred_payments = null;

    #[MapInputName('invoice')]
    #[MapName('invoice')]      
    public ?InvoiceData $invoice = null;

    #[MapInputName('invoices')]
    #[MapName('invoices')]      
    #[DataCollectionOf(InvoiceData::class)]
    public ?array $invoices = null;

    #[MapInputName('reported_at')]
    #[MapName('reported_at')]
    public ?string $reported_at = null;

    #[MapInputName('reporting')]
    #[MapName('reporting')]
    public ?bool $reporting = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;

    public static function before(array &$attributes){
        $new = static::new();
        $attributes['transaction'] ??= [
            'id' => null
        ];

        if (isset($attributes['id'])){
            $billing = $new->BillingModel()->load('hasTransaction.consument')->findOrFail($attributes['id']);
            $attributes['has_transaction_model'] = $billing->hasTransaction;
        }

        if (isset($attributes['invoice'])){
            $attributes['invoices'] = [$attributes['invoice']];
            unset($attributes['invoice']);
        }

        if (isset($attributes['has_transaction_id']) && isset($attributes['invoices']) && count($attributes['invoices']) > 0){
            $transaction = $attributes['has_transaction_model'] ?? $new->TransactionModel()->with('consument')->findOrFail($attributes['has_transaction_id']);
            $consument = $transaction->consument;
            foreach ($attributes['invoices'] as &$invoice) {
                if (!isset($invoice['payer_type']) || !isset($invoice['payer_id'])){
                    $invoice['payer_type'] = $consument->getMorphClass();
                    $invoice['payer_id']   = $consument->getKey();
                }
            }
        }
    }

    public static function after(self $data): self{
        $new = self::new();

        $props = &$data->props;
        if (isset($data->author_type) && isset($data->author_id)){
            $author = $new->{$data->author_type.'Model'}()->findOrFail($data->author_id);
            $props['prop_author'] = $author->toViewApiOnlies('id','name');
        }

        if (isset($data->cashier_type) && isset($data->cashier_id)) {
            $cashier = $new->{$data->cashier_type.'Model'}()->findOrFail($data->cashier_id);
            $props['prop_cashier'] = $cashier->toViewApiOnlies('id','name');
        }

        if (isset($data->reporting) && $data->reporting) $data->reported_at = now()->toDateTimeString();
        if (isset($data->reported_at)) $data->reporting ??= true;
        return $data;
    }
}
