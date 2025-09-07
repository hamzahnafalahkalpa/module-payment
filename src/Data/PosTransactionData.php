<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\ModulePayment\Contracts\Data\BillingData;
use Hanafalah\ModulePayment\Contracts\Data\PosTransactionData as DataPosTransactionData;
use Hanafalah\ModuleTransaction\Data\TransactionData as DataTransactionData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class PosTransactionData extends DataTransactionData implements DataPosTransactionData
{
    #[MapInputName('billing')]
    #[MapName('billing')]      
    public ?BillingData $billing = null;

    public static function before(array &$attributes){
        $new = static::new();
        if (isset($attributes['billing'])){
            $billing = &$attributes['billing'];
            if (isset($billing['invoices']) && count($billing['invoices']) > 0){
                if (isset($attributes['id'])){
                    $transaction = $new->TransactionModel()->with('consument')->findOrFail($attributes['id']);
                    $consument = $transaction->consument;
                    foreach ($billing['invoices'] as &$invoice) {
                        if (!isset($invoice['payer_type']) || !isset($invoice['payer_id'])){
                            $invoice['payer_type'] = $consument->getMorphClass();
                            $invoice['payer_id'] = $consument->getKey();
                        }
                    }
                }
            }
        }
    }
}
