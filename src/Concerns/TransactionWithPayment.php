<?php

namespace Hanafalah\ModulePayment\Concerns;

trait TransactionWithPayment{
    public function billing(){return $this->hasOneModel('Billing');}
    public function paymentHistory(){return $this->hasOneModel('PaymentHistory');}
    public function paymentSummary(){return $this->hasOneModel('PaymentSummary');}
    public function paymentSummaries(){return $this->hasManyModel('PaymentSummary');}
    public function transactionItem(){return $this->hasOneModel('TransactionItem');}
    public function transactionItems(){return $this->hasManyModel('TransactionItem');}
    public function voucherTransaction(){return $this->hasOneModel('VoucherTransaction', 'ref_transaction_id');}
    public function voucherTransactions(){return $this->hasManyModel('VoucherTransaction', 'ref_transaction_id');}
    public function transactionHasConsument(){return $this->hasOneModel('TransactionHasConsument');}
    public function consuments(){return $this->belongsToManyModel('Consument', 'TransactionHasConsument');}

    public function consument(){
        $consument_table           = $this->ConsumentModel()->getTable();
        $transaction_has_consument = $this->TransactionHasConsumentModel()->getTable();
        return $this->hasOneThroughModel(
            'Consument',
            'TransactionHasConsument',
            $this->getForeignKey(),
            $this->ConsumentModel()->getKeyName(),
            $this->getKeyName(),
            $this->ConsumentModel()->getForeignKey()
        )->select([
            "$consument_table.*",
            "$transaction_has_consument.*",
            "$consument_table.id as id"
        ]);
    }
}