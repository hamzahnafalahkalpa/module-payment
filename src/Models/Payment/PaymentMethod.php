<?php

namespace Hanafalah\ModulePayment\Models\Payment;

use Hanafalah\ModulePayment\Models\Price\FinanceStuff;
use Hanafalah\ModulePayment\Resources\PaymentMethod\{
    ShowPaymentMethod,
    ViewPaymentMethod
};

class PaymentMethod extends FinanceStuff
{
    protected $table = 'unicodes';

    public function getShowResource()
    {
        return ShowPaymentMethod::class;
    }

    public function getViewResource()
    {
        return ViewPaymentMethod::class;
    }
}
