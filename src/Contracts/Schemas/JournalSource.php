<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\ModulePayment\Contracts\Data\JournalSourceData;
//use Hanafalah\ModulePayment\Contracts\Data\JournalSourceUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModulePayment\Schemas\JournalSource
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method array updateJournalSource(?JournalSourceData $journal_source_dto = null)
 * @method Model prepareUpdateJournalSource(JournalSourceData $journal_source_dto)
 * @method bool deleteJournalSource()
 * @method bool prepareDeleteJournalSource(? array $attributes = null)
 * @method mixed getJournalSource()
 * @method ?Model prepareShowJournalSource(?Model $model = null, ?array $attributes = null)
 * @method array showJournalSource(?Model $model = null)
 * @method Collection prepareViewJournalSourceList()
 * @method array viewJournalSourceList()
 * @method LengthAwarePaginator prepareViewJournalSourcePaginate(PaginateData $paginate_dto)
 * @method array viewJournalSourcePaginate(?PaginateData $paginate_dto = null)
 * @method array storeJournalSource(?JournalSourceData $journal_source_dto = null);
 */

interface JournalSource extends FinanceStuff
{
    public function prepareStoreJournalSource(JournalSourceData $journal_source_dto): Model;
    public function journalSource(mixed $conditionals = null): Builder;
}