<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\ModulePayment\Contracts\Data\WithdrawalData;
//use Hanafalah\ModulePayment\Contracts\Data\WithdrawalUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModulePayment\Schemas\Withdrawal
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updateWithdrawal(?WithdrawalData $withdrawal_dto = null)
 * @method Model prepareUpdateWithdrawal(WithdrawalData $withdrawal_dto)
 * @method bool deleteWithdrawal()
 * @method bool prepareDeleteWithdrawal(? array $attributes = null)
 * @method mixed getWithdrawal()
 * @method ?Model prepareShowWithdrawal(?Model $model = null, ?array $attributes = null)
 * @method array showWithdrawal(?Model $model = null)
 * @method Collection prepareViewWithdrawalList()
 * @method array viewWithdrawalList()
 * @method LengthAwarePaginator prepareViewWithdrawalPaginate(PaginateData $paginate_dto)
 * @method array viewWithdrawalPaginate(?PaginateData $paginate_dto = null)
 * @method array storeWithdrawal(?WithdrawalData $withdrawal_dto = null)
 * @method Collection prepareStoreMultipleWithdrawal(array $datas)
 * @method array storeMultipleWithdrawal(array $datas)
 */

interface Withdrawal extends BaseWalletTransaction
{
    public function prepareStoreWithdrawal(WithdrawalData $withdrawal_dto): Model;
}