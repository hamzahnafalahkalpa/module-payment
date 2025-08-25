<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModulePayment\Contracts\Data\SplitPaymentData;
use Hanafalah\ModulePayment\Contracts\Schemas\SplitPayment as ContractsSplitPayment;
use Illuminate\Database\Eloquent\Model;

class SplitPayment extends PackageManagement implements ContractsSplitPayment
{
    protected string $__entity = 'SplitPayment';
    public $split_payment_model;

    public function prepareStoreSplitPayment(SplitPaymentData $split_payment_dto): Model{
        if (isset($split_payment_dto->payer_type) && !isset($split_payment_dto->invoice_id)) {
            $payer = $this->{$split_payment_dto->payer_type . 'Model'}()->findOrFail($split_payment_dto->payer_id);
            if ($payer->getMorphClass() == $this->PayerModelMorph()) {
                $payer = $this->{$payer->flag . 'Model'}()->findOrFail($split_payment_dto->payer_id);
            }
            $invoice_id = $payer->invoice()->firstOrCreate()->getKey();
            $split_payment_dto->invoice_id = $invoice_id;
        }

        $invoice = $this->InvoiceModel()->draft()->find($invoice_id);
        $add = [
            'billing_id'     => $split_payment_dto->billing_id,
            'payment_method' => $split_payment_dto->payment_method,
            'paid'           => $split_payment_dto->paid ?? 0,
            'payer_type'     => $split_payment_dto->payer_type ?? null,
            'payer_id'       => $split_payment_dto->payer_id   ?? null,
            'invoice_id'     => $split_payment_dto->invoice_id ?? null
        ];

        if (isset($split_payment_dto->id)) {
            $guard      = ['id' => $split_payment_dto->id];
            $split_payment = $this->SplitPaymentModel()->updateOrCreate($guard, $add);
        } else {
            $split_payment = $this->SplitPaymentModel()->create($add);
        }
        $split_payment->paid_money = $split_payment_dto->paid_money ?? 0;
        $split_payment->cash_over  = $split_payment_dto->cash_over ?? 0;
        $split_payment->note       = $split_payment_dto->note ?? null;

        $transaction_split_payment = $split_payment->transaction;
        $billing = $split_payment_dto->billing ?? $split_payment->billing;
        $transaction_billing    = $billing->transaction;
        $transaction_split_payment->parent_id = $transaction_billing->getKey();
        $transaction_split_payment->save();

        if (isset($item['bank_id'])) {
            $bank = $this->BankModel()->findOrFail($item['bank_id']);
            $split_payment->bank_id = $bank->getKey();
            $split_payment->bank    = [
                'id'             => $bank->getKey(),
                'name'           => $bank->name,
                'account_name'   => $bank->account_name,
                'account_number' => $bank->account_number
            ];
        }
        if (isset($split_payment_dto->payment_method_detail)) {
            $this->paymentMethodProp($split_payment_dto->$yment_method, $split_payment);
        }

        if (isset($split_payment_dto->payment_summaries) && count($split_payment_dto->payment_summaries) > 0) {
            $payment_history = $this->schemaContract('payment_history')->prepareStorePaymentHistory([
                'payment_method'    => $split_payment_dto->payment_method,
                'split_payment'        => $split_payment,
                'billing'           => $billing,
                'parent_id'         => $invoice->paymentSummary()->firstOrCreate()->getKey(),
                'paid_money'        => $payment_method->name == 'DITAGIHKAN' ? 0 : $split_payment->paid_money,
                'cash_over'         => $split_payment->cash_over ?? 0,
                'transaction_id'    => $split_payment->transaction->getKey(),
                'reference_type'    => $split_payment->getMorphClass(),
                'reference_id'      => $split_payment->getKey(),
                'payment_summaries' => $split_payment_dto->payment_summaries ?? [],
                'payment_details'   => $split_payment_dto->payment_details ?? [],
                'discount'          => $split_payment_dto->discount ?? 0,
                'note'              => $split_payment_dto->note ?? null,
                'vouchers'          => $split_payment_dto->vouchers ?? []
            ]);
            if (!isset($split_payment_dto->paid)) {
                $split_payment->paid         = $payment_history->paid;
                $billing->paid          ??= 0;
                $billing->debt          ??= 0;
                $billing->gross         ??= 0;
                $billing->net           ??= 0;
                $billing->paid           += $split_payment->paid;
                $billing->debt           += $payment_history->debt;
                $billing->gross          += $payment_history->gross;
                $billing->net            += $payment_history->net;
            }
        } else {
            throw new \Exception('payment_summaries are required');
        }

        $split_payment->save();
        $split_payment->reporting();
        $billing->save();
        return $this->split_payment_model = $split_payment;
    }
}
