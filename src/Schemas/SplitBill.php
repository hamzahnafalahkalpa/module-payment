<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModulePayment\Contracts\Data\SplitBillData;
use Hanafalah\ModulePayment\Contracts\Schemas\SplitBill as ContractsSplitBill;
use Illuminate\Database\Eloquent\Model;

class SplitBill extends PackageManagement implements ContractsSplitBill
{
    protected string $__entity = 'SplitBill';
    public $split_bill_model;

    public function prepareStoreSplitBill(SplitBillData $split_bill_dto): Model{
        if (isset($split_bill_dto->payer_type) && !isset($split_bill_dto->invoice_id)) {
            $payer = $this->{$split_bill_dto->payer_type . 'Model'}()->findOrFail($split_bill_dto->payer_id);
            if ($payer->getMorphClass() == $this->PayerModelMorph()) {
                $payer = $this->{$payer->flag . 'Model'}()->findOrFail($split_bill_dto->payer_id);
            }
            $invoice_id = $payer->invoice()->firstOrCreate()->getKey();
            $split_bill_dto->invoice_id = $invoice_id;
        }

        $invoice = $this->InvoiceModel()->draft()->find($invoice_id);
        $add = [
            'billing_id'     => $split_bill_dto->billing_id,
            'payment_method' => $split_bill_dto->payment_method,
            'paid'           => $split_bill_dto->paid ?? 0,
            'payer_type'     => $split_bill_dto->payer_type ?? null,
            'payer_id'       => $split_bill_dto->payer_id   ?? null,
            'invoice_id'     => $split_bill_dto->invoice_id ?? null
        ];

        if (isset($split_bill_dto->id)) {
            $guard      = ['id' => $split_bill_dto->id];
            $split_bill = $this->SplitBillModel()->updateOrCreate($guard, $add);
        } else {
            $split_bill = $this->SplitBillModel()->create($add);
        }
        $split_bill->paid_money = $split_bill_dto->paid_money ?? 0;
        $split_bill->cash_over  = $split_bill_dto->cash_over ?? 0;
        $split_bill->note       = $split_bill_dto->note ?? null;

        $transaction_split_bill = $split_bill->transaction;
        $billing = $split_bill_dto->billing ?? $split_bill->billing;
        $transaction_billing    = $billing->transaction;
        $transaction_split_bill->parent_id = $transaction_billing->getKey();
        $transaction_split_bill->save();

        if (isset($item['bank_id'])) {
            $bank = $this->BankModel()->findOrFail($item['bank_id']);
            $split_bill->bank_id = $bank->getKey();
            $split_bill->bank    = [
                'id'             => $bank->getKey(),
                'name'           => $bank->name,
                'account_name'   => $bank->account_name,
                'account_number' => $bank->account_number
            ];
        }
        if (isset($split_bill_dto->payment_method_detail)) {
            $this->paymentMethodProp($split_bill_dto->$yment_method, $split_bill);
        }

        if (isset($split_bill_dto->payment_summaries) && count($split_bill_dto->payment_summaries) > 0) {
            $payment_history = $this->schemaContract('payment_history')->prepareStorePaymentHistory([
                'payment_method'    => $split_bill_dto->payment_method,
                'split_bill'        => $split_bill,
                'billing'           => $billing,
                'parent_id'         => $invoice->paymentSummary()->firstOrCreate()->getKey(),
                'paid_money'        => $payment_method->name == 'DITAGIHKAN' ? 0 : $split_bill->paid_money,
                'cash_over'         => $split_bill->cash_over ?? 0,
                'transaction_id'    => $split_bill->transaction->getKey(),
                'reference_type'    => $split_bill->getMorphClass(),
                'reference_id'      => $split_bill->getKey(),
                'payment_summaries' => $split_bill_dto->payment_summaries ?? [],
                'payment_details'   => $split_bill_dto->payment_details ?? [],
                'discount'          => $split_bill_dto->discount ?? 0,
                'note'              => $split_bill_dto->note ?? null,
                'vouchers'          => $split_bill_dto->vouchers ?? []
            ]);
            if (!isset($split_bill_dto->paid)) {
                $split_bill->paid         = $payment_history->paid;
                $billing->paid          ??= 0;
                $billing->debt          ??= 0;
                $billing->gross         ??= 0;
                $billing->net           ??= 0;
                $billing->paid           += $split_bill->paid;
                $billing->debt           += $payment_history->debt;
                $billing->gross          += $payment_history->gross;
                $billing->net            += $payment_history->net;
            }
        } else {
            throw new \Exception('payment_summaries are required');
        }

        $split_bill->save();
        $split_bill->reporting();
        $billing->save();
        return $this->split_bill_model = $split_bill;
    }
}
