<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModulePayment\Contracts\Data\BaseWalletTransactionData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModulePayment\Schemas\BaseWalletTransaction
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method array updateBaseWalletTransaction(?BaseWalletTransactionData $base_wallet_transaction_dto = null)
 * @method Model prepareUpdateBaseWalletTransaction(BaseWalletTransactionData $base_wallet_transaction_dto)
 * @method bool deleteBaseWalletTransaction()
 * @method bool prepareDeleteBaseWalletTransaction(? array $attributes = null)
 * @method mixed getBaseWalletTransaction()
 * @method ?Model prepareShowBaseWalletTransaction(?Model $model = null, ?array $attributes = null)
 * @method array showBaseWalletTransaction(?Model $model = null)
 * @method Collection prepareViewBaseWalletTransactionList()
 * @method array viewBaseWalletTransactionList()
 * @method LengthAwarePaginator prepareViewBaseWalletTransactionPaginate(PaginateData $paginate_dto)
 * @method array viewBaseWalletTransactionPaginate(?PaginateData $paginate_dto = null)
 * @method array storeBaseWalletTransaction(?BaseWalletTransactionData $base_wallet_transaction_dto = null);
 * @method Builder baseWalletTransaction(mixed $conditionals = null);
 */
interface BaseWalletTransaction extends DataManagement{
    public function prepareStoreBaseWalletTransaction(BaseWalletTransactionData $base_wallet_transaction_dto): Model;
}
