<?php

namespace Hanafalah\ModulePayment\Models\Transaction;

use Hanafalah\ModulePayment\Resources\Transaction\{ViewPosTransaction, ShowPosTransaction};
use Hanafalah\ModuleTransaction\Models\Transaction\Transaction;

class PosTransaction extends Transaction
{
    protected $table = 'transactions';

    public function getForeignKey(){
        return 'transaction_id';
    }

    public function viewUsingRelation(): array{
        return $this->mergeArray(parent::viewUsingRelation(),[
            'paymentSummary'
        ]);
    }

    public function showUsingRelation(): array{
        return $this->mergeArray(parent::showUsingRelation(),[
            'billing',
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

    public function paymentSummary(){return $this->hasOneModel("PaymentSummary");}
    public function billing(){return $this->hasOneModel("Billing",'has_transaction_id');}
    public function billings(){return $this->hasManyModel("Billing",'has_transaction_id');}
}
