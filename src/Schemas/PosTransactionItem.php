<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\Contracts\Schemas\PosTransactionItem as ContractsPosTransactionItem;
use Hanafalah\ModulePayment\Contracts\Data\PosTransactionItemData;
use Hanafalah\ModuleTransaction\Schemas\TransactionItem;
use Illuminate\Database\Eloquent\Builder;

class PosTransactionItem extends TransactionItem implements ContractsPosTransactionItem
{
    protected string $__entity = 'PosTransactionItem';
    public $pos_transaction_item_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'pos_transaction_item',
            'tags'     => ['pos_transaction_item', 'pos_transaction_item-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStorePosTransactionItem(mixed $pos_transaction_item_dto): Model{
        $this->pos_transaction_item_model = $this->prepareStoreTransactionItem($pos_transaction_item_dto);
        return $this->pos_transaction_item_model;
    }

    public function posTransactionItem(mixed $conditionals = null): Builder{
        return $this->transactionItem($conditionals);
    }
}