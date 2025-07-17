<?php

namespace Hanafalah\ModulePayment\Resources\VoucherTransaction;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewVoucherTransaction extends ApiResource
{
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
            'id'      => $this->id,
            'name'    => $this->name,
            'voucher' => $this->relationValidation('voucher', function () {
                return $this->voucher->toViewApi()->resolve();
            }),
            'consument' => $this->relationValidation('consument', function () {
                return $this->consument->toViewApi()->resolve();
            }),
            'payment_history' => $this->relationValidation('paymentHistory', function () {
                return $this->paymentHistory->toViewApi()->resolve();
            })
        ];

        $props = $this->getPropsData();
        foreach ($props as $key => $prop) {
            $arr[$key] = $prop;
        }

        return $arr;
    }
}
