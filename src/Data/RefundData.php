<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\ModulePayment\Contracts\Data\RefundData as DataRefundData;
use Hanafalah\ModulePayment\Enums\WalletTransaction\TransactionType;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class RefundData extends BaseWalletTransactionData  implements DataRefundData
{
    #[MapName('invoice_id')]
    #[MapInputName('invoice_id')]
    public mixed $invoice_id = null;

    #[MapName('invoice_model')]
    #[MapInputName('invoice_model')]
    public ?object $invoice_model = null;

    #[MapName('refund_items')]
    #[MapInputName('refund_items')]
    #[DataCollectionOf(RefundItemData::class)]
    public ?array $refund_items = null;

    public static function before(array &$attributes){
        $new = static::new();
        parent::before($attributes);
        $attributes['invoice_model'] ??= $new->InvoiceModel()->findOrFail($attributes['invoice_id']);
        $attributes['invoice_id'] ??= $attributes['invoice_model']->getKey();

        $attributes['prop_invoice'] = $attributes['invoice_model']->toViewApi()->resolve();

        if (!isset($attributes['consument_id']) && isset($attributes['invoice_model'])){
            $attributes['consument_id'] = $attributes['invoice_model']->payer_id;
            $attributes['consument_type'] = $attributes['invoice_model']->payer_type;

        }
        
        if (isset($attributes['wallet_transaction'])){
            $wallet_transaction = &$attributes['wallet_transaction'];
            if (!isset($attributes['user_wallet_id'])){
                $user_wallet = $new->UserWalletModel()
                            ->with(['wallet', 'consument'])
                            ->where('props->prop_wallet->label','PERSONAL')
                            ->where('consument_type',$attributes['consument_type'])
                            ->where('consument_id',$attributes['consument_id'])
                            ->firstOrFail();
                $wallet_transaction['user_wallet_id'] = $user_wallet->getKey();
                $wallet_transaction['user_wallet_model'] = $user_wallet;
            }
            $wallet_transaction['name'] ??= $attributes['name'];
            $wallet_transaction['transaction_type'] = TransactionType::CREDIT->value;
            $wallet_transaction['reference_type'] = 'Refund';
        }                
    }
}