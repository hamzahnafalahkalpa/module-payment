<?php

namespace Hanafalah\ModulePayment\Concerns;

use Hanafalah\LaravelSupport\Concerns\Support\HasRequestData;
use Hanafalah\ModuleTransaction\Concerns\HasTransaction;
use Illuminate\Database\Eloquent\Model;

trait HasPaymentSummaryDeferred
{
    use HasTransaction, HasRequestData;

    public static function bootHasPaymentSummaryDeferred()
    {
        static::created(function ($model) {
            $model->generatePaymentSummaryDeferred($model);
        });
    }

    public function generatePaymentSummaryDeferred(Model $model){
        if (\method_exists($model, 'transaction')) {
            $transaction = app(config('app.contracts.Transaction'))->prepareStoreTransaction(
                $model->requestDTO(config('app.contracts.TransactionData'),[
                    'reference_id'   => $model->getKey(),
                    'reference_type' => $model->getMorphClass()
                ])
            );
            $transaction_id = $transaction->getKey();
        }
        return app(config('app.contracts.PaymentSummary'))->prepareStorePaymentSummary(
            $model->requestDTO(config('app.contracts.PaymentSummaryData'),[
                'name'           => $model->name ?? null,
                'transaction_id' => $transaction_id ?? null,
                'reference_id'   => $model->getKey(),
                'reference_type' => $model->getMorphClass()
            ])
        );
    }

    public function paymentSummary(){return $this->morphOneModel('PaymentSummary', 'reference');}
}
