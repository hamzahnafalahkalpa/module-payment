<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\ModulePayment\Contracts\Data\PaymentMethodData;
use Hanafalah\ModulePayment\Contracts\Schemas\PaymentMethod as ContractsPaymentMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PaymentMethod extends FinanceStuff implements ContractsPaymentMethod
{
    protected string $__entity = 'PaymentMethod';
    public $payment_method_model;

    public function prepareStorePaymentMethod(PaymentMethodData $payment_method_dto): Model{
        $payment_method = $this->prepareStoreFinanceStuff($payment_method_dto);
        return $this->payment_method_model = $payment_method;
    }

    public function paymentMethod(mixed $conditionals = null): Builder{
        return $this->financeStuff($conditionals);
    }
}
