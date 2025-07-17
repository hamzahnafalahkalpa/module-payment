<?php

namespace Hanafalah\ModulePayment\Resources\Billing;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewBilling extends ApiResource
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
            'uuid'           => $this->uuid,
            'id'             => $this->id,
            'billing_code'   => $this->billing_code,
            'transaction_id' => $this->transaction_id,
            'author'         => $this->relationValidation('author', function () {
                return $this->author->toViewApi()->resolve();
            }),
            'cashier'        => $this->relationValidation('cashier', function () {
                return $this->cashier->toViewApi()->resolve();
            }),
            'transaction'  => $this->relationValidation('hasTransaction', function () {
                return $this->hasTransaction->toShowApi()->resolve();
            }),
            'transaction_billing' => $this->relationValidation('transaction', function () {
                return $this->transaction->toShowApi()->resolve();
            }),
            'debt'     => $this->debt ?? 0,
            'amount'   => $this->amount ?? 0,
            'reported_at'    => $this->reported_at,
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at
        ];

        return $arr;
    }
}
