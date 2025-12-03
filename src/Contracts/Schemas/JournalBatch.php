<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\ModulePayment\Contracts\Data\JournalBatchData;
//use Hanafalah\ModulePayment\Contracts\Data\JournalBatchUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModulePayment\Schemas\JournalBatch
 * @method self conditionals(mixed $conditionals)
 * @method array updateJournalBatch(?JournalBatchData $journal_batch_dto = null)
 * @method Model prepareUpdateJournalBatch(JournalBatchData $journal_batch_dto)
 * @method bool deleteJournalBatch()
 * @method bool prepareDeleteJournalBatch(? array $attributes = null)
 * @method mixed getJournalBatch()
 * @method ?Model prepareShowJournalBatch(?Model $model = null, ?array $attributes = null)
 * @method array showJournalBatch(?Model $model = null)
 * @method Collection prepareViewJournalBatchList()
 * @method array viewJournalBatchList()
 * @method LengthAwarePaginator prepareViewJournalBatchPaginate(PaginateData $paginate_dto)
 * @method array viewJournalBatchPaginate(?PaginateData $paginate_dto = null)
 * @method array storeJournalBatch(?JournalBatchData $journal_batch_dto = null);
 * @method Builder journalBatch(mixed $conditionals = null);
 */

interface JournalBatch extends DataManagement
{
    public function prepareStoreJournalBatch(JournalBatchData $journal_batch_dto): Model;
}