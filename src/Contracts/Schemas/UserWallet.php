<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\ModulePayment\Contracts\Data\UserWalletData;
//use Hanafalah\ModulePayment\Contracts\Data\UserWalletUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModulePayment\Schemas\UserWallet
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updateUserWallet(?UserWalletData $user_wallet_dto = null)
 * @method Model prepareUpdateUserWallet(UserWalletData $user_wallet_dto)
 * @method bool deleteUserWallet()
 * @method bool prepareDeleteUserWallet(? array $attributes = null)
 * @method mixed getUserWallet()
 * @method ?Model prepareShowUserWallet(?Model $model = null, ?array $attributes = null)
 * @method array showUserWallet(?Model $model = null)
 * @method Collection prepareViewUserWalletList()
 * @method array viewUserWalletList()
 * @method LengthAwarePaginator prepareViewUserWalletPaginate(PaginateData $paginate_dto)
 * @method array viewUserWalletPaginate(?PaginateData $paginate_dto = null)
 * @method array storeUserWallet(?UserWalletData $user_wallet_dto = null)
 * @method Collection prepareStoreMultipleUserWallet(array $datas)
 * @method array storeMultipleUserWallet(array $datas)
 */

interface UserWallet extends DataManagement
{
    public function prepareStoreUserWallet(UserWalletData $user_wallet_dto): Model;
}