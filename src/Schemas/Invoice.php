<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModulePayment\Contracts\Data\InvoiceData;
use Hanafalah\ModulePayment\Contracts\Schemas\Invoice as ContractsInvoice;
use Illuminate\Database\Eloquent\Model;

class Invoice extends PackageManagement implements ContractsInvoice
{
    protected string $__entity = 'Invoice';
    public $invoice_model;

    public function prepareStoreInvoice(InvoiceData $invoice_dto): Model{
        $add = [
            'author_type'    => $invoice_dto->author_type ?? null,
            'author_id'      => $invoice_dto->author_id ?? null
        ];

        if (isset($invoice_dto->id)) {
            $guard = ['id' => $invoice_dto->id];
        } else {
            $guard = [
                'payer_id'   => $invoice_dto->payer_id,
                'payer_type' => $invoice_dto->payer_type
            ];
        }

        $invoice   = $this->usingEntity()->updateOrCreate($guard, $add);
        $consument = $invoice_dto->consument_model ?? $invoice->consument;

        if (!isset($invoice->paid_at) && isset($invoice_dto->paid_at)) {
            $invoice->paid_at = $invoice_dto->paid_at;
            $invoice_dto->generated_at = now();
        }

        $this->generateInvoice($invoice_dto, $invoice)
             ->generateTransaction($invoice_dto, $invoice)
             ->generatePaymentSummary($invoice_dto, $invoice)
             ->generateBilling($invoice_dto, $invoice);        

        //FOR SETTLED ONLY
        if (isset($invoice_dto->paid_at)) {
            $invoice->save();
        }

        $paymentSummary       = $invoice->paymentSummary()->firstOrCreate();
        $paymentSummary->name = $message ?? "Total Tagihan untuk {$consument->name}";
        $paymentSummary->save();

        return $invoice;
    }

    protected function generateInvoice(InvoiceData &$invoice_dto, Model &$invoice): self{
        if (isset($invoice_dto->generated_at) && !isset($invoice->generated_at)) {
            $invoice->invoice_code ??= $invoice::hasEncoding('INVOICE');
            $this->generateTransaction($invoice_dto, $invoice);
        }
        return $this;
    }

    protected function generateTransaction(InvoiceData &$invoice_dto, Model &$invoice): self{
        if (isset($invoice_dto->transaction)){
            $transaction_dto = &$invoice_dto->transaction;
            $transaction_dto->reference_type  = $invoice->getMorphClass();
            $transaction_dto->reference_id    = $invoice->getKey();
            $transaction_dto->reference_model = $invoice;
            $transaction_model = $this->schemaContract('transaction')->prepareStoreTransaction($invoice_dto->transaction);
            $invoice->setRelation('transaction', $transaction_model);
            $invoice_dto->transaction->id = $transaction_model->getKey();
        }
        return $this;
    }

    protected function generatePaymentSummary(InvoiceData &$invoice_dto, Model &$invoice): self{
        if (isset($invoice_dto->payment_summary)){
            $payment_summary_dto = &$invoice_dto->payment_summary;
            $payment_summary_dto->transaction_id  = $invoice->transaction->getKey();
            $payment_summary_dto->reference_type  = $invoice->getMorphClass();
            $payment_summary_dto->reference_id    = $invoice->getKey();
            $payment_summary_dto->reference_model = $invoice;
            $payment_summary_model = $this->schemaContract('payment_summary')->prepareStorePaymentSummary($invoice_dto->payment_summary);
            $invoice->setRelation('payment_summary', $payment_summary_model);
            $invoice_dto->payment_summary->id = $payment_summary_model->getKey();
        }
        return $this;
    }

    protected function generateBilling(InvoiceData &$invoice_dto, Model &$invoice): self{
        //WHEN BILLING TRIGGERED
        if (isset($invoice_dto->billing_at) && !isset($invoice->billing_at)) {
            if (!isset($invoice->generated_at)) {
                $invoice_dto->generated_at = now();
                $this->generateInvoice($invoice_dto, $invoice);
            }

            if (isset($invoice_dto->payment_history)) {
                $payment_history_dto = &$invoice_dto->payment_history;
                $payment_history_dto->transaction_id = $invoice->transaction->getKey();
                $payment_history_dto->reference_type = $invoice->getMorphClass();
                $payment_history_dto->reference_id = $invoice->getKey();
                if ($payment_history_dto->is_deferred){
                    $payer = $invoice->payer;
                    $payer->load('billingDeferred.paymentSummary');
                    $payment_history_dto->parent_id = $payer->billingDeferred->paymentSummary->getKey();
                }
                $this->schemaContract('payment_history')->prepareStorePaymentHistory($payment_history_dto);
            }
        }
        return $this;
    }
}
