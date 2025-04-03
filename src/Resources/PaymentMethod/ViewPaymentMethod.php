<?php

namespace Hanafalah\ModulePayment\Resources\PaymentMethod;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewPaymentMethod extends ApiResource
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
            'name'              => $this->name,
        ];

        return $arr;
    }
}
