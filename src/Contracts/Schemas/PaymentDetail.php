<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModulePayment\Data\PaymentDetailData;

interface PaymentDetail extends DataManagement
{
    public function prepareStorePaymentDetail(PaymentDetailData $payment_detail_dto): Model;
}
