<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\ModulePayment\Contracts\Data\BaseWalletTransactionData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\Contracts\Schemas\Refund as ContractsRefund;
use Hanafalah\ModulePayment\Contracts\Data\RefundData;

class Refund extends BaseWalletTransaction implements ContractsRefund
{
    protected string $__entity = 'Refund';
    public $refund_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'refund',
            'tags'     => ['refund', 'refund-index'],
            'duration' => 24 * 60
        ]
    ];


    protected function additionalData(BaseWalletTransactionData $base_wallet_transaction_dto): array{
        return [
            'name' => $base_wallet_transaction_dto->name,
            'invoice_id' => $base_wallet_transaction_dto->invoice_id
        ];
    }

    public function prepareStoreRefund(RefundData $refund_dto): Model{
        $refund = $this->prepareStoreBaseWalletTransaction($refund_dto);
        if (isset($refund_dto->refund_items) && count($refund_dto->refund_items) > 0){
            $refund->load('transaction');
            foreach ($refund_dto->refund_items as &$refund_item_dto) {
                $refund_item_dto->reference_id = $refund->getKey();
                $refund_item_dto->reference_type = $refund->getMorphClass();
                $refund_item_dto->transaction_id = $refund->transaction->getKey();
                $this->schemaContract('refund_item')->prepareStoreRefundItem($refund_item_dto);
            }
        }
        $this->fillingProps($refund,$refund_dto->props);
        $refund->save();
        return $this->refund_model = $refund;
    }

    public function refund(mixed $conditionals = null): Builder{
        return $this->baseWalletTransaction($conditionals);
    }
}