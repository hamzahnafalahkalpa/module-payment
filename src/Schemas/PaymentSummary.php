<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModulePayment\Contracts\Schemas\PaymentSummary as ContractsPaymentSummary;

class PaymentSummary extends PackageManagement implements ContractsPaymentSummary
{
    protected string $__entity = 'PaymentSummary';
    public static $payment_summary_model;
}
