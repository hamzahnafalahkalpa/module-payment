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
        // static::created(function ($model) {
        //     $model->generatePaymentSummaryDeferred($model);
        // });
    }

    public function generatePaymentSummaryDeferred(){
        if (\method_exists($this, 'transaction')) {
            $transaction = app(config('app.contracts.Transaction'))->prepareStoreTransaction(
                $this->requestDTO(config('app.contracts.TransactionData'),[
                    'reference_id'   => $this->getKey(),
                    'reference_type' => $this->getMorphClass()
                ])
            );
            $transaction_id = $transaction->getKey();
        }
        return app(config('app.contracts.PaymentSummary'))->prepareStorePaymentSummary(
            $this->requestDTO(config('app.contracts.PaymentSummaryData'),[
                'name'           => $this->name ?? null,
                'transaction_id' => $transaction_id ?? null,
                'reference_id'   => $this->getKey(),
                'reference_type' => $this->getMorphClass()
            ])
        );
    }

    public function paymentSummary(){return $this->morphOneModel('PaymentSummary', 'reference');}
}
