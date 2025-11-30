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
            'name'             => $this->name ?? null,
            'amount'           => $this->amount,
            'discount'         => $this->discount,
            'debt'             => $this->debt,            
            'paid'             => $this->paid,
            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at
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
