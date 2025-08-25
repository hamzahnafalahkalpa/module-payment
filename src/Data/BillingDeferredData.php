<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\ModulePayment\Contracts\Data\BillingDeferredData as DataBillingDeferredData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class BillingDeferredData extends InvoiceData implements DataBillingDeferredData
{
    protected string $__entity = 'BillingDeferred';

}