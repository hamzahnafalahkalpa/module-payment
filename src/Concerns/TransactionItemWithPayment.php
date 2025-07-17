<?php

namespace Hanafalah\ModulePayment\Concerns;

trait TransactionItemWithPayment{
    public function paymentDetail(){return $this->hasOneModel('PaymentDetail');}
}