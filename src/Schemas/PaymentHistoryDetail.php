<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\Contracts\Schemas\PaymentHistoryDetail as ContractsPaymentHistoryDetail;
use Hanafalah\ModulePayment\Contracts\Data\PaymentHistoryDetailData;

class PaymentHistoryDetail extends PaymentDetail implements ContractsPaymentHistoryDetail
{
    protected string $__entity = 'PaymentHistoryDetail';
    public $payment_history_detail_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'payment_history_detail',
            'tags'     => ['payment_history_detail', 'payment_history_detail-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStorePaymentHistoryDetail(PaymentHistoryDetailData $payment_history_detail_dto): Model{
        $this->fillingProps($payment_history_detail,$payment_history_detail_dto->props);
        $payment_history_detail->save();
        return $this->payment_history_detail_model = $payment_history_detail;
    }
}