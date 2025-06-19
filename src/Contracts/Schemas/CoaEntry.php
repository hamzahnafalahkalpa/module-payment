<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\ModulePayment\Contracts\Data\CoaEntryData;
//use Hanafalah\ModulePayment\Contracts\Data\CoaEntryUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModulePayment\Schemas\CoaEntry
 * @method self conditionals(mixed $conditionals)
 * @method array updateCoaEntry(?CoaEntryData $coa_entry_dto = null)
 * @method Model prepareUpdateCoaEntry(CoaEntryData $coa_entry_dto)
 * @method bool deleteCoaEntry()
 * @method bool prepareDeleteCoaEntry(? array $attributes = null)
 * @method mixed getCoaEntry()
 * @method ?Model prepareShowCoaEntry(?Model $model = null, ?array $attributes = null)
 * @method array showCoaEntry(?Model $model = null)
 * @method Collection prepareViewCoaEntryList()
 * @method array viewCoaEntryList()
 * @method LengthAwarePaginator prepareViewCoaEntryPaginate(PaginateData $paginate_dto)
 * @method array viewCoaEntryPaginate(?PaginateData $paginate_dto = null)
 * @method array storeCoaEntry(?CoaEntryData $coa_entry_dto = null);
 * @method Builder coaEntry(mixed $conditionals = null);
 */

interface CoaEntry extends DataManagement
{
    public function prepareStoreCoaEntry(CoaEntryData $coa_entry_dto): Model;
}