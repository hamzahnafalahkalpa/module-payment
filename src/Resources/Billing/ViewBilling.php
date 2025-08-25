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
            'id'             => $this->id,
            'uuid'           => $this->uuid,
            'billing_code'   => $this->billing_code,
            'author'         => $this->relationValidation('author', function () {
                return $this->author->toViewApi()->resolve();
            }, $this->prop_author),
            'cashier'        => $this->relationValidation('cashier', function () {
                return $this->cashier->toViewApi()->resolve();
            }, $this->prop_cashier),
            'has_transaction_id' => $this->has_transaction_id,
            'has_transaction'  => $this->relationValidation('hasTransaction', function () {
                return $this->hasTransaction->toShowApi()->resolve();
            },$this->prop_has_transaction),
            'debt'           => $this->debt ?? 0,
            'amount'         => $this->amount ?? 0,
            'reported_at'    => $this->reported_at,
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at
        ];
        return $arr;
    }
}
