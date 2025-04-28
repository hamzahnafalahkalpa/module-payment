<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModulePayment\Contracts\Data\BankData;

/**
 * @see \Hanafalah\ModulePayment\Schemas\Bank
 * @method bool deleteBank()
 * @method bool prepareDeleteBank(? array $attributes = null)
 * @method mixed getBank()
 * @method ?Model prepareShowBank(?Model $model = null, ?array $attributes = null)
 * @method array showBank(?Model $model = null)
 * @method Collection prepareViewBankList()
 * @method array viewBankList()
 * @method LengthAwarePaginator prepareViewBankPaginate(PaginateData $paginate_dto)
 * @method array viewBankPaginate(?PaginateData $paginate_dto = null)
 * @method array storeBank(?BankData $funding_dto = null)
 * @method Builder bank(mixed $conditionals = null)
 */
interface Bank extends DataManagement
{
    public function prepareStoreBank(BankData $bank_dto): Model;
}
