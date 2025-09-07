<?php

namespace Hanafalah\ModulePayment\Models\Transaction;

class Deposit extends BaseWalletTransaction{
    protected static function booted(): void
    {
        parent::booted();
        static::creating(function ($query) {
            $query->code ??= static::hasEncoding('DEPOSIT');
        });
    }
}
