<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModulePayment\Contracts\Schemas\PaymentHistoryDetail as ContractsPaymentHistoryDetail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class PaymentHistoryDetail extends PaymentDetail implements ContractsPaymentHistoryDetail
{
    //FOR BILLING HISTORICAL PAYMENT
}
