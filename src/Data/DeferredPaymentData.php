<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\ModulePayment\Contracts\Data\DeferredPaymentData as DataDeferredPaymentData;

class DeferredPaymentData extends InvoiceData implements DataDeferredPaymentData
{
    protected string $__entity = 'DeferredPayment';
    public static function before(array &$attributes){
        $attributes['flag'] ??= 'DeferredPayment';
        parent::before($attributes);
    }
}