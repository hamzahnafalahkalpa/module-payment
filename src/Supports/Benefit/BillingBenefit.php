<?php

namespace Hanafalah\ModulePayment\Supports\Benefit;

use Hanafalah\ModulePayment\Contracts\Supports\Benefit\BillingBenefit as BillingInterface;

class BillingBenefit extends Benefit implements BillingInterface
{
    public function calculating(&$payment_history, &$voucher, &$attributes)
    {
        $this->initializeBenefit($voucher);
        $this->calculateBenefitByTypeValue($attributes, $payment_history);
        return $payment_history;
    }
}
