<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;

/**
 * @see \Hanafalah\ModulePayment\Schemas\Deposit
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method array storeDeposit(?DepositData $rab_work_list_dto = null)
 * @method bool deleteDeposit()
 * @method bool prepareDeleteDeposit(? array $attributes = null)
 * @method mixed getDeposit()
 * @method ?Model prepareShowDeposit(?Model $model = null, ?array $attributes = null)
 * @method array showDeposit(?Model $model = null)
 * @method array viewDepositList()
 * @method Collection prepareViewDepositList(? array $attributes = null)
 * @method LengthAwarePaginator prepareViewDepositPaginate(PaginateData $paginate_dto)
 * @method array viewDepositPaginate(?PaginateData $paginate_dto = null)
 * @method Builder function deposit(mixed $conditionals = null)
 */
interface Deposit extends DataManagement {}
