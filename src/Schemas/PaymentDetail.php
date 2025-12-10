<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModulePayment\Contracts\Schemas\PaymentDetail as ContractsPaymentDetail;
use Hanafalah\ModulePayment\Data\PaymentDetailData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends PackageManagement implements ContractsPaymentDetail
{
    protected string $__entity = 'PaymentDetail';
    public $payment_detail_model;

    public function prepareStorePaymentDetail(PaymentDetailData $payment_detail_dto): Model{
        if (isset($payment_detail_dto->id)) {
            $guard = ['id' => $payment_detail_dto->id];
        } else {
            $guard = [
                'parent_id'           => $payment_detail_dto->parent_id ?? null,
                'payment_summary_id'  => $payment_detail_dto->payment_summary_id,
                'transaction_item_id' => $payment_detail_dto->transaction_item_id
            ];
        }

        $payment_detail = $this->PaymentDetailModel()->firstOrCreate($guard,\call_user_func(function() use ($payment_detail_dto){
            $add  = [];
            $keys = ['name','is_loan','qty','amount','debt','price','discount','paid','cogs','tax','additional'];
            foreach ($keys as $key) $add[$key] = $payment_detail_dto->{$key};
            return $add;
        }));
        $this->fillingProps($payment_detail, $payment_detail_dto->props);
        $payment_detail->save();
        return $this->payment_detail_model = $payment_detail;
    }

    public function storePaymentDetail(?PaymentDetailData $payment_detail_dto = null): array{
        return $this->transaction(function() use ($payment_detail_dto){
            return $this->ShowPaymentDetail($this->prepareStorePaymentDetail($payment_detail_dto ?? $this->requestDTO(PaymentDetailData::class)));
        });
    }

    public function paymentDetail(mixed $conditionals = null): Builder{
        return $this->PaymentDetailModel()->withParameters()
                    ->conditionals($this->mergeCondition($conditionals ?? []))
                    ->orderBy('created_at','desc');
    }
}
