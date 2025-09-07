<?php

namespace Hanafalah\ModulePayment\Resources\PaymentSummary;

class ShowPaymentSummary extends ViewPaymentSummary
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
            'refund'           => $this->refund,
            'additional'       => $this->additional,
            'tax'              => $this->tax,
            'total_tax'        => $this->total_tax,
            'transaction'      => $this->relationValidation('transaction', function () {
                return $this->transaction->toShowApi()->resolve();
            },$this->prop_transaction),
            'note'             => $this->note,
            'payment_details'  => $this->relationValidation('paymentDetails', function () {
                return $this->paymentDetails->transform(function ($paymentDetail) {
                    return $paymentDetail->toShowApi();
                });
            }),
            'childs' => $this->relationValidation('childs', function () {
                return $this->childs->transform(function ($child) {
                    return $child->toShowApi();
                });
            }),
            'payment_summaries' => $this->relationValidation('paymentSummaries', function () {
                return $this->paymentSummaries->transform(function ($paymentSummary) {
                    return new static($paymentSummary);
                });
            }),
            'form' => $this->form ?? null
        ];

        if ($this->relationLoaded('recursiveChilds')) {
            $arr['childs'] = $this->relationValidation('recursiveChilds', function () {
                return $this->recursiveChilds->transform(function ($child) {
                    return new static($child);
                });
            });
        }

        $arr = $this->mergeArray(parent::toArray($request), $arr);
        return $arr;
    }
}
