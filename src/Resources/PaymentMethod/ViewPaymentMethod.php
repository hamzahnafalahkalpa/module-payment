<?php

namespace Hanafalah\ModulePayment\Resources\PaymentMethod;

use Hanafalah\LaravelSupport\Resources\ApiResource;
use Hanafalah\ModulePayment\Resources\FinanceStuff\ViewFinanceStuff;

class ViewPaymentMethod extends ViewFinanceStuff
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
        ];
        $arr = $this->mergeArray(parent::toArray($request), $arr);
        return $arr;
    }
}
