<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\ModulePayment\Contracts\Data\WalletData;
//use Hanafalah\ModulePayment\Contracts\Data\WalletUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModulePayment\Schemas\Wallet
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updateWallet(?WalletData $wallet_dto = null)
 * @method Model prepareUpdateWallet(WalletData $wallet_dto)
 * @method bool deleteWallet()
 * @method bool prepareDeleteWallet(? array $attributes = null)
 * @method mixed getWallet()
 * @method ?Model prepareShowWallet(?Model $model = null, ?array $attributes = null)
 * @method array showWallet(?Model $model = null)
 * @method Collection prepareViewWalletList()
 * @method array viewWalletList()
 * @method LengthAwarePaginator prepareViewWalletPaginate(PaginateData $paginate_dto)
 * @method array viewWalletPaginate(?PaginateData $paginate_dto = null)
 * @method array storeWallet(?WalletData $wallet_dto = null)
 * @method Collection prepareStoreMultipleWallet(array $datas)
 * @method array storeMultipleWallet(array $datas)
 */

interface Wallet extends DataManagement
{
    public function prepareStoreWallet(WalletData $wallet_dto): Model;
}