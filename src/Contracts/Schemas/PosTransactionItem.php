<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\ModulePayment\Contracts\Data\PosTransactionItemData;
//use Hanafalah\ModulePayment\Contracts\Data\PosTransactionItemUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleTransaction\Contracts\Schemas\TransactionItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModulePayment\Schemas\PosTransactionItem
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updatePosTransactionItem(?PosTransactionItemData $pos_transaction_item_dto = null)
 * @method Model prepareUpdatePosTransactionItem(PosTransactionItemData $pos_transaction_item_dto)
 * @method bool deletePosTransactionItem()
 * @method bool prepareDeletePosTransactionItem(? array $attributes = null)
 * @method mixed getPosTransactionItem()
 * @method ?Model prepareShowPosTransactionItem(?Model $model = null, ?array $attributes = null)
 * @method array showPosTransactionItem(?Model $model = null)
 * @method Collection prepareViewPosTransactionItemList()
 * @method array viewPosTransactionItemList()
 * @method LengthAwarePaginator prepareViewPosTransactionItemPaginate(PaginateData $paginate_dto)
 * @method array viewPosTransactionItemPaginate(?PaginateData $paginate_dto = null)
 * @method array storePosTransactionItem(?PosTransactionItemData $pos_transaction_item_dto = null)
 * @method Collection prepareStoreMultiplePosTransactionItem(array $datas)
 * @method array storeMultiplePosTransactionItem(array $datas)
 */

interface PosTransactionItem extends TransactionItem
{
    public function prepareStorePosTransactionItem(PosTransactionItemData $pos_transaction_item_dto): Model;
    public function posTransactionItem(mixed $conditionals = null): Builder;
}