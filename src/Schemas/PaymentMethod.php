<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModulePayment\Contracts\Schemas\PaymentMethod as ContractsPaymentMethod;

class PaymentMethod extends PackageManagement implements ContractsPaymentMethod
{
    protected string $__entity = 'PaymentMethod';
    public static $payment_method_model;

    public function prepareStorePaymentMethod(mixed $attributes = null){
        $attributes ??= request()->all();

        $payment_method = isset(request()->id) ? $this->PaymentMethod()->find(request()->id) : $this->PaymentMethodModel();

        if (!$payment_method) {
            abort(404, 'Payment method not found.');
        }

        $isUpdatingName = !$payment_method->exists || $payment_method->name !== $attributes['name'];
        if ($isUpdatingName && $this->PaymentMethod()->where('name', $attributes['name'])->exists()) {
            abort(422, 'Payment method with this name already exists.');
        }

        $payment_method->name = $attributes['name'];
        $payment_method->jurnal = $attributes['jurnal'];
        $payment_method->save();
        return $payment_method;
    }
}
