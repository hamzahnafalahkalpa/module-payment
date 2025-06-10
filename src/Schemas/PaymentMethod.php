<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModulePayment\Contracts\Data\PaymentMethodData;
use Hanafalah\ModulePayment\Contracts\Schemas\PaymentMethod as ContractsPaymentMethod;

class PaymentMethod extends PackageManagement implements ContractsPaymentMethod
{
    protected string $__entity = 'PaymentMethod';
    public static $payment_method_model;

    public function prepareStorePaymentMethod(PaymentMethodData $payment_method_dto){
        $add = [
            'name' => $payment_method_dto->name,
            'flag' => $payment_method_dto->flag
        ];

        if (isset($payment_method_dto->id)){
            $guard = ['id' => $payment_method_dto->id];
            $create = [$guard,$add];
        }else{
            $create = [$add];
        }
        $payment_method = $this->PaymentMethodModel()->updateOrCreate(...$create);
        $this->fillingProps($payment_method, $payment_method_dto);
        $payment_method->save();
        return $payment_method;
    }
}
