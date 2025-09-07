<?php

namespace Hanafalah\ModulePayment\Concerns;

trait HasWalletTransaction
{
    public function walletTransaction(){return $this->morphOneModel('WalletTransaction','reference');}
}
