<?php

namespace Hanafalah\ModulePayment\Models\Transaction;

use Hanafalah\ModulePayment\Resources\Transaction\{ViewPosTransaction, ShowPosTransaction};
use Hanafalah\ModuleTransaction\Models\Transaction\Transaction;

class PosTransaction extends Transaction
{
    protected $table = 'transactions';

    protected $casts = [
        'reference_type' => 'string',
        'reference_id' => 'string',
        'journal_reported_at' => 'datetime',
        'reported_at' => 'datetime',
        'canceled_at' => 'datetime',
        'name'        => 'string',
        'consument_name' => 'string'
    ];

    public function getPropsQuery(): array{
        return [
            'name' => 'props->prop_reference->name',
            'consument_name' => 'props->prop_consument->name'
        ];
    }

    public function getForeignKey(){
        return 'transaction_id';
    }

    public function viewUsingRelation(): array{
        return $this->mergeArray(parent::viewUsingRelation(),[
            'paymentSummary','reference'
        ]);
    }

    public function showUsingRelation(): array{
        return $this->mergeArray(parent::showUsingRelation(),[
            'reference',
            'billing.invoices' => function($query){
                $query->with([
                    'splitPayments',
                    'paymentHistory' => function($query){
                        $query->with([
                            'childs.paymentHistoryDetails'
                        ]);
                    },
                    'paymentSummary' => function($query){
                        $query->with([
                            'paymentDetails' => function ($query) {
                                $query->with('transactionItem')->debtNotZero();
                            },
                            'recursiveChilds'
                        ]);
                    }
                ]);
            },
            'paymentSummary' => function($query){
                $query->with([
                    'paymentDetails' => function ($query) {
                        $query->with('transactionItem')->debtNotZero();
                    },
                    'recursiveChilds'
                ]);
            }
        ]);
    }

    public function getViewResource(){return ViewPosTransaction::class;}
    public function getShowResource(){return ShowPosTransaction::class;}

    public function transactionItem(){return $this->hasOneModel('PosTransactionItem');}    
    public function transactionItems(){return $this->hasManyModel('PosTransactionItem');}    
    public function paymentSummary(){return $this->hasOneModel("PaymentSummary");}
    public function billing(){return $this->hasOneModel("Billing",'has_transaction_id')->orderBy('created_at','desc');}
    public function billings(){return $this->hasManyModel("Billing",'has_transaction_id');}
}
