<?php

namespace Hanafalah\ModulePayment\Models\Transaction;

use Hanafalah\ModuleTransaction\Models\Transaction\TransactionItem;

class RefundItem extends TransactionItem
{
    protected $table = 'transaction_items';
    
    public function refund(){return $this->morphTo('reference');}
}
