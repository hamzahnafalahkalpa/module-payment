<?php

namespace Hanafalah\ModulePayment\Models\Transaction;

use Hanafalah\ModulePayment\Concerns\HasTransaction;

class BillingDeferred extends Invoice
{
    protected $table = 'invoices';
}
