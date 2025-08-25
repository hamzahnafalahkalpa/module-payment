<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Hanafalah\ModulePayment\Concerns\PaymentCalculation;
use Hanafalah\ModulePayment\Contracts\Data\PaymentHistoryData;
use Hanafalah\ModulePayment\Contracts\Schemas\PaymentHistory as ContractsPaymentHistory;

class PaymentHistory extends PaymentSummary implements ContractsPaymentHistory
{
    use PaymentCalculation;

    public $payment_history_model;
    private $__split_payment_model;
    private $__billing_model;
    private $__split_transaction_model;
    private $__payment_summary_history_model;
    private $__history_debt = 0;
    private $__history_omzet = 0;
    private $__history_net = 0;
    private $__history_cogs = 0;
    private $__history_gross = 0;
    private $__history_paid_summaries;

    protected function createPaymentHistory(PaymentHistoryData $payment_history_dto): Model{
        parent::prepareStorePaymentSummary($payment_history_dto);
    }

    public function prepareStorePaymentHistory(PaymentHistoryData $payment_history_dto): Model{
        $this->createPaymentHistory($payment_history_dto);
        $attributes['split_payment_id'] = $payment_history->reference_id;
        $attributes['reported_at']   = now();
        $this->voucherProcessing($attributes);
        $payment_history->refresh();
        $payment_history->note            = $attributes['note'] ?? null;
        $payment_history->amount          = 0;
        $payment_history->debt            = 0;
        $payment_history->discount      ??= 0;
        $payment_history->discount       += $discount = $attributes['discount'] ??= 0;
        $payment_history->paid_money      = $attributes['paid_money'] ??= 0;
        $payment_history->cash_over       = $cash_over  = $attributes['cash_over'] ??= 0;
        $payment_history->omzet           = 0;
        $payment_history->save();
        $attributes['paid_money'] += $discount;
        $this->processUsingPaymentSummaries($payment_history, $attributes);
        $payment_history->refresh();
        $payment_history->debt          += $this->__history_debt;
        $payment_history->omzet         += $this->__history_omzet;
        $payment_history->cogs          += $this->__history_cogs;
        $payment_history->gross          = $this->__history_gross;
        $payment_history->net            = $this->__history_net - $discount;
        $payment_history->paid           = $payment_history->omzet + $cash_over - $discount; //total bayar
        $payment_history->charge         = $payment_history->paid_money - $payment_history->paid;
        // $payment_history->setAttribute('paid_summaries',$this->__history_paid_summaries);
        $payment_history->save();
        $payment_history->load('childs.paymentDetails');
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

    protected function clonePaymentSummary(Model &$payment_history, Model $payment_summary): Model
    {
        $payment_history_has_model = $payment_history->paymentHistoryHasModel()->firstOrCreate([
            'payment_history_id' => $payment_history->getKey(),
            'model_type'         => $payment_summary->getMorphClass(),
            'model_id'           => $payment_summary->getKey()
        ]);

        $new_payment_summary = $this->PaymentSummaryModel()->firstOrCreate([
            'parent_id'      => $payment_history->getKey(),
            'transaction_id' => $payment_history->transaction_id,
            'reference_id'   => $payment_history_has_model->getKey(),
            'reference_type' => $payment_history_has_model->getMorphClass()
        ]);
        $new_payment_summary->name = $payment_summary->name;
        $new_payment_summary->save();
        $new_payment_summary->refresh();
        return $this->__payment_summary_history_model = $new_payment_summary;
    }

    protected function voucherProcessing(array &$attributes): Model
    {
        $vouchers           = $this->VoucherModel()->where('is_auto_implement', true)->get();
        $voucher_ids        = $vouchers->pluck('id')->toArray() ?? [];
        $rendering_vouchers = $vouchers;

        if (isset($attributes['vouchers']) && count($attributes['vouchers']) > 0) {
            foreach ($attributes['vouchers'] as $voucher_id) {
                $voucher_model = $this->VoucherModel()->findOrFail($voucher_id);
                if (is_numeric($this->searchArray($voucher_ids, $voucher_model->getKey()))) continue;
                $rendering_vouchers->push($voucher_model);
            }
        }
        $billing_transaction = $this->__billing_model->transaction;
        $attributes['split_payment_id']   = $attributes['split_payment_id'];
        $attributes['consument_id']    = $billing_transaction->reference_id;
        $attributes['consument_type']  = $billing_transaction->reference_type;
        list($vouchers, $payment_history) = $this->schemaContract('voucher')->prepareRevalidateVoucher($vouchers, $attributes);
        return $payment_history;
    }

    protected function processUsingPaymentSummaries(Model &$payment_history, array &$attributes): void
    {
        if (isset($attributes['payment_summaries']) && count($attributes['payment_summaries']) > 0) {
            $payment_summaries = new Collection;
            $paid_money        = $attributes['paid_money'];
            foreach ($attributes['payment_summaries'] as $attr_payment_summary) {
                if (!$this->hasPaymentDetails($attr_payment_summary)) throw new \Exception('Payment details not found');

                //GET PAYMENT SUMMARY BY ID
                $payment_summary = $this->PaymentSummaryModel()->findOrfail($attr_payment_summary['id']);
                $payment_summary->setRelation('paymentDetails', new Collection);

                $this->clonePaymentSummary($payment_history, $payment_summary);
                $is_deferred = $attributes['payment_method'] == $this->PaymentMethodModel()::PAYMENT_METHOD_DEFERRED;
                foreach ($attr_payment_summary['payment_details'] as $key => $attr_payment_detail) {
                    $payment_detail = $this->PaymentDetailModel()->findOrFail($attr_payment_detail['id']);
                    $this->__history_gross += $payment_detail->debt;
                    if (!$is_deferred) {
                        $this->__history_cogs += $payment_detail->cogs * $attr_payment_detail['qty'] ??= 1;
                        $this->paymentWithoutDeferred($payment_history, $payment_summary, $payment_detail, $paid_money);
                        if ($paid_money == 0) break;
                    } else {
                        $this->paymentWithDeferred($this->__payment_summary_history_model, $payment_detail);
                    }
                }
                $this->__payment_summary_history_model->refresh();
                $payment_summaries->push($this->__payment_summary_history_model);
                $payment_summaries->transform(function ($payment_summary) {
                    return $payment_summary->toShowApi();
                });
            }
            $this->__history_paid_summaries = $payment_summaries;
        }
    }

    protected function paymentWithoutDeferred(Model &$payment_history, Model &$payment_summary, Model $payment_detail, int &$paid_money)
    {
        $this->__history_net               += $payment_detail->debt;
        $debt                               = $payment_detail->debt - $paid_money;
        $debt                               = $debt < 0 ? 0 : $debt;
        $this->__history_omzet             += $payment_detail->debt - $debt;
        $this->__history_debt        += $debt;
        $payment_detail->paid              += $paid = $payment_detail->debt - $debt;
        $payment_detail->debt               = $debt;
        if ($debt == 0) {
            $payment_detail->payment_history_id = $this->__payment_summary_history_model->getKey();
            $payment_detail->save();
            $this->__payment_summary_history_model->refresh();
        } else {
            $payment_detail = $this->PaymentDetailModel()->withoutEvents(function () use ($payment_detail, $payment_history, $paid) {
                $clone_payment_detail                     = clone $payment_detail;
                $clone_payment_detail->debt               = 0;
                $clone_payment_detail->parent_id          = $payment_detail->getKey();
                $clone_payment_detail->amount             = $paid;
                $clone_payment_detail->payment_history_id = $this->__payment_summary_history_model->getKey();
                $clone_payment_detail->save();

                return $clone_payment_detail;
            });
        }

        // $payment_summary->paymentDetails->push($this->PaymentDetailModel()->findOrFail($payment_detail->getKey()));
        $paid_money -= $payment_detail->paid;
        $paid_money = ($paid_money < 0) ? 0 : $paid_money;
    }

    protected function paymentWithDeferred(Model $payment_summary, Model $payment_detail): void
    {
        $previous_payment_summary                = $payment_detail->paymentSummary;
        $previous_payment_summary->amount       -= $payment_detail->debt;
        $previous_payment_summary->debt         -= $payment_detail->debt;
        $previous_payment_summary->save();

        $payment_detail->payment_summary_id = $payment_summary->getKey();
        $payment_detail->save();
        $payment_detail->refresh();
    }

    public function paymentHistory(mixed $conditionals = null): Builder
    {
        $this->booting();
        return $this->PaymentHistoryModel()->withParameters()->conditionals($conditionals);
    }

    public function prepareShowPaymentHistory(?array $attributes = null): Model
    {
        $attributes ??= request()->all();

        $model ??= $this->getPaymentHistory();
        if (!isset($model)) {
            $id = $attributes['id'] ?? null;
            if (!isset($id)) throw new \Exception('Payment history not found');
            $model = $this->PaymentHistory()->with($this->showUsingRelation())->findOrFail($id);
        } else {
            $model->load($this->showUsingRelation());
        }
        return $this->payment_history_model = $model;
    }

    public function showPaymentHistory(?Model $model = null): array
    {
        return $this->transforming($this->__resources['show'], function () use ($model) {
            return $this->prepareShowPaymentHistory($model);
        });
    }
}
