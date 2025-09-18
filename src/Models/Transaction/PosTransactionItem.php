<?php

namespace Hanafalah\ModulePayment\Models\Transaction;

use Hanafalah\ModuleTransaction\Models\Transaction\TransactionItem;

class PosTransactionItem extends TransactionItem
{
    protected $table = 'transaction_items';

    public function getForeignKey(){
        return 'transaction_item_id';
    }
}
