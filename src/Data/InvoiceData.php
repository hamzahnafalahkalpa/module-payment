<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModulePayment\Contracts\Data\InvoiceData as DataInvoiceData;
use Hanafalah\ModuleTransaction\Contracts\Data\TransactionData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class InvoiceData extends Data implements DataInvoiceData
{
    protected string $__entity = 'Invoice';

    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('author_type')]
    #[MapName('author_type')]
    public ?string $author_type = null;

    #[MapInputName('author_id')]
    #[MapName('author_id')]
    public mixed $author_id = null;

    #[MapInputName('payer_type')]
    #[MapName('payer_type')]
    public string $payer_type;

    #[MapInputName('payer_id')]
    #[MapName('payer_id')]
    public mixed $payer_id;

    #[MapInputName('payer_model')]
    #[MapName('payer_model')]
    public ?object $payer_model;

    #[MapInputName('billing_id')]
    #[MapName('billing_id')]
    public mixed $billing_id = null;

    #[MapInputName('billing_model')]
    #[MapName('billing_model')]
    public ?object $billing_model = null;

    #[MapInputName('reported_at')]
    #[MapName('reported_at')]
    public ?string $reported_at = null;

    #[MapInputName('reporting')]
    #[MapName('reporting')]
    public ?bool $reporting = null;

    #[MapInputName('paid_at')]
    #[MapName('paid_at')]
    public ?string $paid_at = null;

    #[MapInputName('is_deferred')]
    #[MapName('is_deferred')]
    public ?bool $is_deferred = false;

    #[MapInputName('transaction')]
    #[MapName('transaction')]
    public ?TransactionData $transaction = null;

    #[MapInputName('transaction_model')]
    #[MapName('transaction_model')]
    public ?object $transaction_model = null;

    #[MapInputName('payment_summary')]
    #[MapName('payment_summary')]
    public ?PaymentSummaryData $payment_summary = null;

    #[MapInputName('payment_history')]
    #[MapName('payment_history')]
    public ?PaymentHistoryData $payment_history = null;

    #[MapInputName('split_payments')]
    #[MapName('split_payments')]
    #[DataCollectionOf(SplitPaymentData::class)]
    public ?array $split_payments = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;

    public static function before(array &$attributes){
        $new = static::new();

        $attributes['is_deferred'] ??= isset($attributes['payment_summary']);
        $attributes['flag'] ??= 'Invoice';
        if ($attributes['is_deferred']){
            // $attributes['flag'] = 'DeferredPayment';
        }else{
            $attributes['paid_at'] ??= now();
        }

        if (isset($attributes['payer_model'])){
            $attributes['payer_id']   = $attributes['payer_model']->getKey();
            $attributes['payer_type'] = $attributes['payer_model']->getMorphClass();
        }else{
            $payer = $new->{$attributes['payer_type'].'Model'}()->findOrFail($attributes['payer_id']);
            $attributes['payer_model'] = $payer;
        }

        $payer_model = $attributes['payer_model'];
        $attributes['prop_payer'] = $payer_model->toViewApi()->resolve();

        $attributes['transaction'] = array_merge_recursive($attributes['transaction'] ?? [],[
            'id' => null,
            "reference_type" => $new->__entity,
            'consument' => [
                'id'             => null,
                'phone'          => $phone ?? null,
                'name'           => $payer_model?->name ?? null,
                'reference_type' => $attributes['payer_type'],
                'reference_id'   => $attributes['payer_id']
            ]
        ]);

        if (isset($attributes['payment_summary'])){
            $payment = &$attributes['payment_summary'];
        }elseif(isset($attributes['payment_history'])){
            $payment = &$attributes['payment_history'];
        }

        if (isset($payment)){
            $payment['is_deferred'] = $attributes['is_deferred'];
            $payment['name'] ??= $payer_model?->name ?? 'Total Tagihan'; 
        }
    }

    public static function after(InvoiceData $data): InvoiceData{
        $new = self::new();
        $props = &$data->props;
        if (isset($data->reporting) && $data->reporting) $data->reported_at = now()->toDateTimeString();
        if (isset($data->reported_at)) $data->reporting ??= true;        
        return $data;
    }
}
