<?php

namespace Hanafalah\ModulePayment\Models\Transaction;

use Hanafalah\ModuleTransaction\Models\Transaction\Transaction;

class PosTransaction extends Transaction
{
    protected $table = 'transactions';

    public function billing(){return $this->hasOneModel("Billing");}
    public function billings(){return $this->hasManyModel("Billing");}
}
