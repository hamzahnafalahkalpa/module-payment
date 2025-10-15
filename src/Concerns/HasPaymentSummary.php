<?php

namespace Hanafalah\ModulePayment\Concerns;

use Hanafalah\ModuleTransaction\Concerns\HasTransaction;

trait HasPaymentSummary
{
    // use HasTransaction;

    public function paymentSummary(){return $this->morphOneModel('PaymentSummary', 'reference');}
    public function paymentSummaries(){return $this->morphManyModel('PaymentSummary', 'reference');}
}
