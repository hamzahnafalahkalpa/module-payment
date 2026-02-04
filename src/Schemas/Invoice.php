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
        $billing_model = $invoice_dto->billing_model ?? $this->BillingModel()->findOrFail($invoice_dto->billing_id);

        // Initialize billing amounts if not reported yet
        if (!isset($billing_model->reported_at)){
            $billing_model->debt = 0;
            $billing_model->amount = 0;
            $billing_model->discount = 0;
            $billing_model->paid = 0;
        }

        // Calculate total money paid from split payments
        $total_money_paid = 0;
        if (isset($invoice_dto->split_payments) && count($invoice_dto->split_payments) > 0) {
            foreach ($invoice_dto->split_payments as $split_payment) {
                $total_money_paid += $split_payment->money_paid ?? 0;
            }
        }

        // Get discount from payment_history if available
        $payment_history_discount = 0;
        if (isset($invoice_dto->payment_history) && isset($invoice_dto->payment_history->discount)) {
            $payment_history_discount = $invoice_dto->payment_history->discount ?? 0;
        }

        if (isset($form) && isset($form['payment_summaries']) && count($form['payment_summaries']) > 0){
            foreach ($form['payment_summaries'] as &$payment_summary) {
                $payment_summary_model = $this->PaymentSummaryModel()->findOrFail($payment_summary['id']);

                if ($reporting) {
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

                        // Update billing with paid amounts (no payment_details means pay the whole summary)
                        $billing_model->amount += $payment_summary_data['amount'];
                        $billing_model->paid = ($billing_model->paid ?? 0) + $payment_summary_data['amount'];

                        // Reduce debt on the original payment summary
                        $payment_summary_model->debt -= $payment_summary_data['amount'];
                        $payment_summary_model->paid = ($payment_summary_model->paid ?? 0) + $payment_summary_data['amount'];
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

                        // Track amounts for billing before the debt changes
                        $detail_amount = $payment_detail_model->amount ?? 0;
                        $detail_debt = $payment_detail_model->debt ?? 0;
                        $detail_discount = $payment_detail_model->discount ?? 0;

                        if ($reporting){
                            if ($invoice_dto->is_deferred){
                                $payment_detail_model->payment_summary_id = $new_payment_summary->getKey();
                            }else{
                                // Mark payment detail as paid
                                // Note: PaymentDetail model events will automatically recalculate PaymentSummary
                                $payment_detail_model->paid = ($payment_detail_model->paid ?? 0) + $detail_debt;
                                $payment_detail_model->debt = 0;
                                $payment_detail_model->payment_history_id = $new_payment_summary->getKey();
                            }

                            // Update billing with paid amounts
                            $billing_model->amount += $detail_amount;
                            $billing_model->paid = ($billing_model->paid ?? 0) + $detail_debt;
                            $billing_model->discount += $detail_discount;
                        }else{
                            // Not reporting - just accumulate debt
                            $billing_model->debt += $detail_debt;
                            $billing_model->amount += $detail_amount;
                            $billing_model->discount += $detail_discount;
                        }

                        $payment_detail_model->invoice_id = $invoice->getKey();
                        $payment_detail_model->save();
                        // PaymentDetail::updated event will auto-recalculate PaymentSummary.debt
                    }
                }
            }
        }

        // Set money_paid from split payments
        if ($reporting && $total_money_paid > 0) {
            $billing_model->money_paid = ($billing_model->money_paid ?? 0) + $total_money_paid;
        }

        // Apply payment history discount to billing
        if ($reporting && $payment_history_discount > 0) {
            $billing_model->discount = ($billing_model->discount ?? 0) + $payment_history_discount;
            // Discount reduces the paid amount needed
            $billing_model->paid = ($billing_model->paid ?? 0) - $payment_history_discount;
            if ($billing_model->paid < 0) {
                $billing_model->paid = 0;
            }
        }

        $billing_model->save();
        $invoice_dto->billing_model = $billing_model;
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
