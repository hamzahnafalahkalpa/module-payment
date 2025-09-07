<?php

namespace Hanafalah\ModulePayment\Models\Payment;

use Hanafalah\ModulePayment\Resources\PaymentHistory\{ShowPaymentHistory, ViewPaymentHistory};

class PaymentHistory extends PaymentSummary
{
    protected $table = 'payment_summaries';

    public function getShowResource(){
        return ShowPaymentHistory::class;
    }

    public function getViewResource(){
        return ViewPaymentHistory::class;
    }

    public function paymentHistoryDetails(){return $this->hasManyModel('PaymentHistoryDetail', 'payment_history_id');}
    public function paymentHasModel(){return $this->morphOneModel('PaymentHasModel', 'payment');}
    public function childs(){return $this->hasManyModel('PaymentHistory', 'parent_id')->with(["childs", "paymentHistoryDetails.transactionItem"]);}
}
