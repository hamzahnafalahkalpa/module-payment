<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\ModulePayment\Contracts\Data\JournalEntryData;
//use Hanafalah\ModulePayment\Contracts\Data\JournalEntryUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModulePayment\Schemas\JournalEntry
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method array updateJournalEntry(?JournalEntryData $journal_entry_dto = null)
 * @method Model prepareUpdateJournalEntry(JournalEntryData $journal_entry_dto)
 * @method bool deleteJournalEntry()
 * @method bool prepareDeleteJournalEntry(? array $attributes = null)
 * @method mixed getJournalEntry()
 * @method ?Model prepareShowJournalEntry(?Model $model = null, ?array $attributes = null)
 * @method array showJournalEntry(?Model $model = null)
 * @method Collection prepareViewJournalEntryList()
 * @method array viewJournalEntryList()
 * @method LengthAwarePaginator prepareViewJournalEntryPaginate(PaginateData $paginate_dto)
 * @method array viewJournalEntryPaginate(?PaginateData $paginate_dto = null)
 * @method array storeJournalEntry(?JournalEntryData $journal_entry_dto = null);
 * @method Builder journalEntry(mixed $conditionals = null);
 */
interface JournalEntry extends DataManagement
{
    public function prepareStoreJournalEntry(JournalEntryData $journal_entry_dto): Model;
}