<?php

namespace Hanafalah\ModulePayment\Concerns;

trait HasConsumentInvoice
{
    public static function bootHasConsumentInvoice()
    {
        static::created(function ($query) {
            $invoice = $query->invoice()->firstOrCreate();
        });
    }

    public function invoice()
    {
        return $this->morphOneModel('Invoice', 'consument');
    }
}
