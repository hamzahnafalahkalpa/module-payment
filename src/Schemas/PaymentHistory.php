<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\Contracts\Data\PaymentHistoryData;
use Hanafalah\ModulePayment\Contracts\Schemas\PaymentHistory as ContractsPaymentHistory;

class PaymentHistory extends PaymentSummary implements ContractsPaymentHistory
{
    public $payment_history_model;

    public function prepareStorePaymentHistory(PaymentHistoryData $payment_history_dto): Model{
        $payment_history = $this->prepareStorePaymentSummary($payment_history_dto);
        if (isset($payment_history_dto->payment_has_models) && count($payment_history_dto->payment_has_models) > 0) {
            foreach ($payment_history_dto->payment_has_models as &$payment_has_model_dto) {
                $payment_has_model = $this->schemaContract('payment_has_model')->prepareStorePaymentHasModel($payment_has_model_dto);
            }
        }
        return $this->payment_history_model = $payment_history;
    }

    // public function prepareStorePaymentHistory(PaymentHistoryData $payment_history_data): Model{
    //     $this->createPaymentHistory($this->storePaymentHistoryMapper($attributes));
    //     $attributes['split_payment_id'] = $payment_history->reference_id;
    //     $attributes['reported_at']   = now();
    //     $this->voucherProcessing($attributes);
    //     $payment_history->refresh();
    //     $payment_history->note            = $attributes['note'] ?? null;
    //     $payment_history->amount          = 0;
    //     $payment_history->debt            = 0;
    //     $payment_history->discount      ??= 0;
    //     $payment_history->discount       += $discount = $attributes['discount'] ??= 0;
    //     $payment_history->paid_money      = $attributes['paid_money'] ??= 0;
    //     $payment_history->cash_over       = $cash_over  = $attributes['cash_over'] ??= 0;
    //     $payment_history->omzet           = 0;
    //     $payment_history->save();
    //     $attributes['paid_money'] += $discount;
    //     $this->processUsingPaymentSummaries($payment_history, $attributes);
    //     $payment_history->refresh();
    //     $payment_history->debt          += $this->__history_debt;
    //     $payment_history->omzet         += $this->__history_omzet;
    //     $payment_history->cogs          += $this->__history_cogs;
    //     $payment_history->gross          = $this->__history_gross;
    //     $payment_history->net            = $this->__history_net - $discount;
    //     $payment_history->paid           = $payment_history->omzet + $cash_over - $discount; //total bayar
    //     $payment_history->charge         = $payment_history->paid_money - $payment_history->paid;
    //     // $payment_history->setAttribute('paid_summaries',$this->__history_paid_summaries);
    //     $payment_history->save();
    //     $payment_history->load('childs.paymentDetails');
    //     return $this->payment_history_model = $payment_history;
    // }
}
