<?php

namespace Hanafalah\ModulePayment\Resources\PaymentSummary;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewPaymentSummary extends ApiResource
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
            'id'               => $this->id,
            'reference_type'   => $this->reference_type,
            'amount'           => $this->amount,
            'discount'         => $this->discount,
            'debt'             => $this->debt,            
            'paid'             => $this->paid,
            'reference'        => $this->relationValidation('reference', function () {
                return $this->reference->toViewApi();
            }),
            'payment_details'  => $this->relationValidation('paymentDetails', function () {
                $paymentDetails = $this->paymentDetails;
                return $paymentDetails->transform(function ($paymentDetail) {
                    return $paymentDetail->toViewApi();
                });
            }),
            'transaction'      => $this->relationValidation('transaction', function () {
                $transaction = $this->transaction;
                return $transaction->toViewApi();
            }),
            'patient'      => $this->relationValidation('patient', function () {
                $patient = $this->patient;
                return $patient->toViewApi();
            }),
            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at,
            'childs'           => $this->relationValidation('childs', function () {
                $childs = $this->childs;
                return $childs->transform(function ($child) {
                    return $child->toViewApi();
                });
            }),
            'payment_summaries' => $this->relationValidation('paymentSummaries', function () {
                return $this->paymentSummaries->transform(function ($paymentSummary) {
                    return $paymentSummary->toViewApi();
                });
            })
        ];
        if (isset($this->pre_debt)) {
            $arr = $this->mergeArray($arr, [
                "pre_debt"       => $this->pre_debt,
                "pre_additional" => $this->pre_additional,
                "pre_discount"   => $this->pre_discount,
            ]);
        }

        return $arr;
    }
}
