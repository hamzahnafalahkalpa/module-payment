<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\ModulePayment\Contracts\Data\RefundItemData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\Contracts\Schemas\RefundItem as ContractsRefundItem;
use Hanafalah\ModuleTransaction\Schemas\TransactionItem;

class RefundItem extends TransactionItem implements ContractsRefundItem
{
    protected string $__entity = 'RefundItem';
    public $refund_item_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'refund_item',
            'tags'     => ['refund_item', 'refund_item-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreRefundItem(RefundItemData $refund_item_dto): Model{
        $refund_item = $this->prepareStoreTransactionItem($refund_item_dto);
        return $this->refund_item_model = $refund_item;
    }

    public function refund(mixed $conditionals = null): Builder{
        return $this->tansactionItem($conditionals);
    }
}