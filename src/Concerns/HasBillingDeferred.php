<?php

namespace Hanafalah\ModulePayment\Concerns;

trait HasBillingDeferred
{
    public static function bootHasBillingDeferred()
    {
        static::created(function ($query) {
            $query->billingDeferred()->firstOrCreate();
        });
    }

    public function billingDeferred()
    {
        return $this->morphOneModel('BillingDeferred', 'payer');
    }

    public function invoice()
    {
        return $this->morphOneModel('Invoice', 'payer');
    }
}
