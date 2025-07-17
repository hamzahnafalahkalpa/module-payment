<?php

namespace Hanafalah\ModulePayment\Concerns;

trait HasInvoice
{
    public function invoice()
    {
        return $this->belongsToModel('Invoice');
    }
}
