<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModulePayment\Contracts\Data\InvoiceData;
use Hanafalah\ModulePayment\Contracts\Schemas\Invoice as ContractsInvoice;
use Illuminate\Database\Eloquent\Model;

class Invoice extends PackageManagement implements ContractsInvoice
{
    protected string $__entity = 'Invoice';
    public static $invoice_model;

    public function prepareStoreInvoice(InvoiceData $invoice_dto): Model{
        $add = [
            'author_type'    => $invoice_dto->author_type ?? null,
            'author_id'      => $invoice_dto->author_id ?? null
        ];

        if (isset($invoice_dto->id)) {
            $guard = ['id' => $invoice_dto->id];
        } else {
            $guard = [
                'consument_id'   => $invoice_dto->consument_id,
                'consument_type' => $invoice_dto->consument_type
            ];
        }

        $invoice = $this->invoice()->updateOrCreate($guard, $add);
        $consument = $invoice_dto->consument_model ?? $invoice->consument;

        $invoice->paid_at ??= $invoice_dto->paid_at;
        //WHEN BILLING TRIGGERED
        if (isset($invoice_dto->billing_at)) {
            $invoice->billing_at = $invoice_dto->billing_at;
            $invoice->save();
            $invoice->refresh();

            $billing_deferred        = $this->BillingDeferredModel()->with('paymentSummary')->find($invoice->getKey());
            $transaction             = $billing_deferred->transaction()->firstOrCreate();
            $payment_summary_billing = $billing_deferred->paymentSummary;
            if (isset($invoice_dto->payment_summary_ids)) {
                $new_invoice = $this->InvoiceModel()->where('consument_id', $invoice->consument_id)
                    ->where('consument_type', $invoice->consument_type)
                    ->draft()->first();
                $invoice->load([
                    'paymentSummaries' => fn($q) => $q->whereNotIn('id', $invoice_dto->payment_summary_ids)
                ]);

                foreach ($invoice->paymentSummaries as $payment_summary) {
                    $payment_summary->parent_id = $new_invoice->paymentSummary->getKey();
                    $payment_summary->save();
                }

                $invoice->load([
                    'paymentSummaries' => fn($q) => $q->whereIn('id', $invoice_dto->payment_summary_ids)
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

        //FOR SETTLED ONLY
        if (isset($invoice_dto->paid_at)) {
            $invoice->save();
        }

        $paymentSummary       = $invoice->paymentSummary()->firstOrCreate();
        $paymentSummary->name = $message ?? "Total Tagihan untuk {$consument->name}";
        $paymentSummary->save();

        return $invoice;
    }
}
