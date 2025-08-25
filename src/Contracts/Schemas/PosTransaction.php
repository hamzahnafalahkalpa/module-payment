<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\ModulePayment\Contracts\Data\PosTransactionData;
use Hanafalah\ModuleTransaction\Contracts\Schemas\Transaction;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleTransaction\Schemas\PosTransaction
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method mixed export(string $type)
 * @method array updatePosTransaction(?PosTransactionData $pos_transaction_dto = null)
 * @method Model prepareUpdatePosTransaction(PosTransactionData $pos_transaction_dto)
 * @method bool deletePosTransaction()
 * @method bool prepareDeletePosTransaction(? array $attributes = null)
 * @method mixed getPosTransaction()
 * @method ?Model prepareShowPosTransaction(?Model $model = null, ?array $attributes = null)
 * @method array showPosTransaction(?Model $model = null)
 * @method Collection prepareViewPosTransactionList()
 * @method array viewPosTransactionList()
 * @method LengthAwarePaginator prepareViewPosTransactionPaginate(PaginateData $paginate_dto)
 * @method array viewPosTransactionPaginate(?PaginateData $paginate_dto = null)
 * @method array storePosTransaction(?PosTransactionData $pos_transaction_dto = null);
 */
interface PosTransaction extends Transaction
{
    public function prepareStorePosTransaction(PosTransactionData $pos_transaction_dto): Model;
}
