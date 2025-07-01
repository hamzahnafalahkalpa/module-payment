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
            'name'             => $this->name ?? null,
            'reference_type'   => $this->reference_type,
            'transaction'      => $this->relationValidation('transaction', function () {
                return $this->transaction->toShowApi()->resolve();
            }),
            'refund'           => $this->refund,
            'additional'       => $this->additional,
            'tax'              => $this->tax,
            'note'             => $this->note,
            'payment_details'  => $this->relationValidation('paymentDetails', function () {
                $paymentDetails = $this->paymentDetails;
                return $paymentDetails->transform(function ($paymentDetail) {
                    $paymentDetail->load('paymentHistory');
                    return $paymentDetail->toShowApi()->resolve();
                });
            }),
            'childs' => $this->relationValidation('childs', function () {
                $childs = $this->childs;
                return $childs->transform(function ($child) {
                    return $child->toShowApi()->resolve();
                });
            }),
            'payment_summaries' => $this->relationValidation('paymentSummaries', function () {
                return $this->paymentSummaries->transform(function ($paymentSummary) {
                    return $paymentSummary->toShowApi()->resolve();
                });
            })
        ];

        if ($this->relationLoaded('recursiveChilds')) {
            $arr['childs'] = $this->relationValidation('recursiveChilds', function () {
                $childs = $this->recursiveChilds;
                return $childs->transform(function ($child) {
                    return $child->toShowApi()->resolve();
                });
            });
        }

        if ($this->relationLoaded('recursiveInvoiceChilds')) {
            $arr['childs'] = $this->relationValidation('recursiveInvoiceChilds', function () {
                $childs = $this->recursiveInvoiceChilds;
                return $childs->transform(function ($child) {
                    return $child->toShowApi()->resolve();
                });
            });
        }
        return $arr;
    }
}
