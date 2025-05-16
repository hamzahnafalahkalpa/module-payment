<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\ModulePayment\Contracts\Data\AccountGroupData;
//use Hanafalah\ModulePayment\Contracts\Data\AccountGroupUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModulePayment\Schemas\AccountGroup
 * @method self conditionals(mixed $conditionals)
 * @method array updateAccountGroup(?AccountGroupData $account_group_dto = null)
 * @method Model prepareUpdateAccountGroup(AccountGroupData $account_group_dto)
 * @method bool deleteAccountGroup()
 * @method bool prepareDeleteAccountGroup(? array $attributes = null)
 * @method mixed getAccountGroup()
 * @method ?Model prepareShowAccountGroup(?Model $model = null, ?array $attributes = null)
 * @method array showAccountGroup(?Model $model = null)
 * @method Collection prepareViewAccountGroupList()
 * @method array viewAccountGroupList()
 * @method LengthAwarePaginator prepareViewAccountGroupPaginate(PaginateData $paginate_dto)
 * @method array viewAccountGroupPaginate(?PaginateData $paginate_dto = null)
 * @method array storeAccountGroup(?AccountGroupData $account_group_dto = null);
 * @method Builder accountGroup(mixed $conditionals = null);
 */

interface AccountGroup extends DataManagement
{
    public function prepareStoreAccountGroup(AccountGroupData $account_group_dto): Model;
}