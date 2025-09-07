<?php

namespace Hanafalah\ModulePayment\Models\Transaction;

class DeferredPayment extends Invoice
{
    protected $table = 'invoices';

    protected static function booted(): void
    {
        parent::booted();
        static::addGlobalScope('flag',function($query){
            $query->flagIn((new static)->getMorphClass()); 
        });
        static::creating(function($query){
            $query->invoice_code ??= self::hasEncoding('INVOICE');
            $query->flag ??= (new static)->getMorphClass();
        });
    }
}
