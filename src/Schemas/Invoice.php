<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModulePayment\Contracts\Data\InvoiceData;
use Hanafalah\ModulePayment\Contracts\Data\SplitPaymentData;
use Hanafalah\ModulePayment\Contracts\Schemas\Invoice as ContractsInvoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Invoice extends PackageManagement implements ContractsInvoice
{
    protected string $__entity = 'Invoice';
    public $invoice_model;

    public function prepareStoreInvoice(InvoiceData $invoice_dto): Model{
        $invoice   = $this->usingEntity()->updateOrCreate([
            'id' => $invoice_dto->id ?? null
        ],[
            'payer_id'   => $invoice_dto->payer_id,
            'payer_type' => $invoice_dto->payer_type,
            'billing_id' => $invoice_dto->billing_id,
            'author_type'    => $invoice_dto->author_type ?? null,
            'author_id'      => $invoice_dto->author_id ?? null,
            'reported_at'    => $invoice_dto->reported_at ?? null,
        ]);
        $payer = $invoice_dto->payer_model ?? $invoice->payer;

        $props = &$invoice_dto->props;
        $billing_model = $invoice_dto->billing_model ?? $this->BillingModel()->findOrFail($invoice_dto->billing_id);
        $props['prop_billing'] = $billing_model->toViewApi()->resolve();

        if (!isset($invoice->paid_at) && isset($invoice_dto->paid_at)) {
            $invoice->paid_at = $invoice_dto->paid_at;
            $invoice_dto->generated_at = now();
        }

        $this->generateTransaction($invoice_dto, $invoice)
             ->generatePaymentSummary($invoice_dto, $invoice)
             ->generatePaymentHistory($invoice_dto, $invoice);    

        if (isset($invoice_dto->split_payments) && count($invoice_dto->split_payments) > 0) {
            foreach ($invoice_dto->split_payments as &$split_payment_dto) {
                $this->generateSplitPayment($split_payment_dto, $invoice);    
            }
        }
        if ($invoice_dto->is_deferred){
            $payment_model = &$invoice->paymentSummary;
        }else{
            $payment_model = &$invoice->paymentHistory;
        }
        $this->fillingProps($invoice, $props);
        $invoice->save();

        $this->reporting($invoice_dto,$invoice,$payment_model);

        return $invoice;
    }

    protected function reporting(InvoiceData &$invoice_dto, Model &$invoice, Model &$payment_model){
        $form = $payment_model->form;
        $reporting = $invoice_dto->reporting;
        if (isset($form) && isset($form['payment_summaries']) && count($form['payment_summaries']) > 0){
            foreach ($form['payment_summaries'] as &$payment_summary) {
                if ($reporting) {
                    $payment_summary_model = $this->PaymentSummaryModel()->findOrFail($payment_summary['id']);
                    $payment_type = $payment_model->getMorphClass();
                    $payment_summary_data = [
                        'id' => null,
                        'parent_id' => $payment_model->getKey(),
                        'name' => $payment_summary_model->name,
                        'reference_type' => $payment_summary_model->reference_type,
                        'reference_id' => $payment_summary_model->reference_id,
                        'payment_has_model' => [
                            'id' => null,
                            'payment_id' => $payment_model->getKey(),
                            'payment_type' => $payment_type,
                            'model_type' => 'PaymentSummary',
                            'model_id' => $payment_summary_model->getKey()
                        ],
                        'payment_details' => null
                    ];                    
                    if (!isset($payment_summary['payment_details']) || count($payment_summary['payment_details']) == 0){
                        $payment_summary_data['debt'] ??= $payment_summary['debt'] ?? 0;
                        $payment_summary_data['amount'] ??= $payment_summary['amount'] ?? 0;
                        $payment_summary_model->debt -= $payment_summary_data['amount'];
                        $payment_summary_model->save();
                    }
                    $new_payment_summary = $this->schemaContract(Str::snake($payment_type))
                                                ->prepareStore(
                                                    $this->requestDTO(config('app.contracts.'.$payment_type.'Data'),
                                                    $payment_summary_data)
                                                );
                }
                
                if (isset($payment_summary['payment_details']) && count($payment_summary['payment_details']) > 0){
                    $payment_details = &$payment_summary['payment_details'];
                    foreach ($payment_details as &$payment_detail) {
                        $payment_detail_model = $this->PaymentDetailModel()->findOrFail($payment_detail['id']);
                        if ($reporting){
                            if ($invoice_dto->is_deferred){
                                $payment_detail_model->payment_summary_id = $new_payment_summary->getKey();
                            }else{
                                $payment_detail_model->paid ??= 0;
                                $payment_detail_model->paid += $payment_detail_model->debt;
                                $payment_detail_model->debt = 0;
                                $payment_detail_model->payment_history_id = $new_payment_summary->getKey();
                            }
                        }
                        $payment_detail_model->invoice_id = $invoice->getKey();
                        $payment_detail_model->save();
                    }
                }
            }
        }
        $payment_model->refresh();
        if ($reporting){
            $payment_model->form = null;
            $payment_model->save();
        }
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
            if ($invoice_dto->is_deferred && $invoice_dto->reporting){
                $payer = $invoice->payer;
                $payer->load('paymentSummary');
                $payment_summary_dto->parent_id = $payer->paymentSummary->getKey();
            }
            $payment_summary_model = $this->schemaContract('payment_summary')->prepareStorePaymentSummary($invoice_dto->payment_summary);
            $invoice->setRelation('paymentSummary', $payment_summary_model);
            $invoice_dto->payment_summary->id = $payment_summary_model->getKey();
        }
        return $this;
    }

    protected function generatePaymentHistory(InvoiceData &$invoice_dto, Model &$invoice): self{
        //WHEN BILLING TRIGGERED
        if (isset($invoice_dto->payment_history)) {
            $payment_history_dto = &$invoice_dto->payment_history;
            $payment_history_dto->transaction_id = $invoice->transaction->getKey();
            $payment_history_dto->reference_type = $invoice->getMorphClass();
            $payment_history_dto->reference_id = $invoice->getKey();
            $payment_history_model = $this->schemaContract('payment_history')->prepareStorePaymentHistory($payment_history_dto);
            $payment_history_dto->id = $payment_history_model->getKey();
        }
        return $this;
    }

    protected function generateSplitPayment(SplitPaymentData &$split_payment_dto, Model &$invoice): self{
        //WHEN BILLING TRIGGERED
        $split_payment_dto->invoice_id = $invoice->getKey();
        $split_payment_dto->invoice_model = $invoice;
        $split_payment_model = $this->schemaContract('split_payment')->prepareStoreSplitPayment($split_payment_dto);
        $split_payment_dto->id = $split_payment_model->getKey();
        return $this;
    }
}
