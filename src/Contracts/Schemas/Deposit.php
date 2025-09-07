<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

/**
 * @see \Hanafalah\ModuleTransaction\Schemas\Deposit
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method mixed export(string $type)
 * @method array updateDeposit(?DepositData $deposit_dto = null)
 * @method Model prepareUpdateDeposit(DepositData $deposit_dto)
 * @method bool deleteDeposit()
 * @method bool prepareDeleteDeposit(? array $attributes = null)
 * @method mixed getDeposit()
 * @method ?Model prepareShowDeposit(?Model $model = null, ?array $attributes = null)
 * @method array showDeposit(?Model $model = null)
 * @method Collection prepareViewDepositList()
 * @method array viewDepositList()
 * @method LengthAwarePaginator prepareViewDepositPaginate(PaginateData $paginate_dto)
 * @method array viewDepositPaginate(?PaginateData $paginate_dto = null)
 * @method array storeDeposit(?DepositData $deposit_dto = null);
 */
interface Deposit extends BaseWalletTransaction {
    
}
