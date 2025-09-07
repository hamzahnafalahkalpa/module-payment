<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\ModulePayment\Contracts\Data\WalletTransactionData;
//use Hanafalah\ModulePayment\Contracts\Data\WalletTransactionUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModulePayment\Schemas\WalletTransaction
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updateWalletTransaction(?WalletTransactionData $wallet_transaction_dto = null)
 * @method Model prepareUpdateWalletTransaction(WalletTransactionData $wallet_transaction_dto)
 * @method bool deleteWalletTransaction()
 * @method bool prepareDeleteWalletTransaction(? array $attributes = null)
 * @method mixed getWalletTransaction()
 * @method ?Model prepareShowWalletTransaction(?Model $model = null, ?array $attributes = null)
 * @method array showWalletTransaction(?Model $model = null)
 * @method Collection prepareViewWalletTransactionList()
 * @method array viewWalletTransactionList()
 * @method LengthAwarePaginator prepareViewWalletTransactionPaginate(PaginateData $paginate_dto)
 * @method array viewWalletTransactionPaginate(?PaginateData $paginate_dto = null)
 * @method array storeWalletTransaction(?WalletTransactionData $wallet_transaction_dto = null)
 * @method Collection prepareStoreMultipleWalletTransaction(array $datas)
 * @method array storeMultipleWalletTransaction(array $datas)
 */

interface WalletTransaction extends DataManagement
{
    public function prepareStoreWalletTransaction(WalletTransactionData $wallet_transaction_dto): Model;
}