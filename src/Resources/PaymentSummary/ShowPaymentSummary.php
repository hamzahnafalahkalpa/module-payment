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
            'reference_type'   => $this->reference_type,
            'transaction'      => $this->relationValidation('transaction', function () {
                return $this->transaction->toShowApi()->resolve();
            },$this->prop_transaction),
            'refund'           => $this->refund,
            'additional'       => $this->additional,
            'tax'              => $this->tax,
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
                    return $paymentSummary->toShowApi();
                });
            })
        ];

        if ($this->relationLoaded('recursiveChilds')) {
            $arr['childs'] = $this->relationValidation('recursiveChilds', function () {
                return $this->recursiveChilds->transform(function ($child) {
                    return $child->toShowApi();
                });
            });
        }

        if ($this->relationLoaded('recursiveInvoiceChilds')) {
            $arr['childs'] = $this->relationValidation('recursiveInvoiceChilds', function () {
                return $this->recursiveInvoiceChilds->transform(function ($child) {
                    return $child->toShowApi()->resolve();
                });
            });
        }

        $arr = $this->mergeArray(parent::toArray($request), $arr);
        return $arr;
    }
}
