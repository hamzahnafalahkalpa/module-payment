<?php

namespace Hanafalah\ModulePayment\Resources\SplitPayment;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewSplitPayment extends ApiResource
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
            'id'                => $this->id,
            'split_payment_code'=> $this->split_payment_code,
            'payment_method'    => $this->payment_method,
            'money_paid'        => $this->money_paid,
            'paid'              => $this->paid,
            'note'              => $this->note
        ];
        return $arr;
    }
}
