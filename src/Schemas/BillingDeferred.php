<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\Contracts\Schemas\BillingDeferred as ContractsBillingDeferred;
use Hanafalah\ModulePayment\Contracts\Data\BillingDeferredData;

class BillingDeferred extends Invoice implements ContractsBillingDeferred
{
    protected string $__entity = 'BillingDeferred';
    public $billing_deferred_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'billing_deferred',
            'tags'     => ['billing_deferred', 'billing_deferred-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreBillingDeferred(BillingDeferredData $billing_deferred_dto): Model{
        $billing_deferred = parent::prepareStoreInvoice($billing_deferred_dto);
        $this->fillingProps($billing_deferred,$billing_deferred_dto->props);
        $billing_deferred->save();
        return $this->billing_deferred_model = $billing_deferred;
    }

    protected function generateBilling(mixed &$billing_deferred_dto, Model &$invoice): self{
        //WHEN BILLING TRIGGERED
        if (isset($billing_deferred_dto->billing_at) && !isset($invoice->billing_at)) {
            if (!isset($invoice->generated_at)) {
                $billing_deferred_dto->generated_at = now();
                $this->generateInvoice($billing_deferred_dto, $invoice);
            }

            $billing_deferred_model = $this->prepareStoreBillingDeffered($this->requestDTO(config('app.contracts.BillingDeferredData'), [
                'payer_id'   => $billing_deferred_dto->payer_id,
                'payer_type' => $billing_deferred_dto->payer_type,
                'transaction' => [
                    'parent_id' => $invoice->transaction->getKey()
                ],
                'payment_summary' => [
                    'id' => null
                ]
            ])); 

            if (isset($billing_deferred_dto->payment_summaries)) {
                // $new_invoice = $this->InvoiceModel()->where('consument_id', $invoice->consument_id)
                //     ->where('consument_type', $invoice->consument_type)
                //     ->draft()->first();
                $invoice->load([
                    'paymentSummaries' => fn($q) => $q->whereNotIn('id', $billing_deferred_dto->payment_summary_ids)
                ]);

                foreach ($invoice->paymentSummaries as $payment_summary) {
                    $payment_summary->parent_id = $new_invoice->paymentSummary->getKey();
                    $payment_summary->save();
                }

                $invoice->load([
                    'paymentSummaries' => fn($q) => $q->whereIn('id', $billing_deferred_dto->payment_summary_ids)
                ]);

                foreach ($invoice->paymentSummaries as $payment_summary) {
                    $transaction_item = $payment_summary->transactionItem()->firstOrCreate([
                        'item_id'        => $payment_summary->reference_id,
                        'item_type'      => $payment_summary->reference_type,
                        'item_name'      => $payment_summary->name,
                        'transaction_id' => $transaction->getKey()
                    ]);

                    $payment_detail = $transaction_item->paymentDetail()->firstOrCreate([
                        'payment_summary_id'  => $payment_summary_billing->getKey(),
                        'transaction_item_id' => $transaction_item->getKey()
                    ], [
                        'cogs'                => $payment_summary->cogs ?? 0,
                        'tax'                 => $payment_summary->tax ?? 0,
                        'additional'          => $payment_summary->additional,
                        'amount'              => $payment_summary->amount,
                        'debt'                => $payment_summary->debt,
                        'price'               => $payment_summary->amount
                    ]);
                }
            }
        }
        return $this;
    }
}