<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\{
    Supports\BaseModulePayment
};
use Hanafalah\ModulePayment\Contracts\Schemas\JournalBatch as ContractsJournalBatch;
use Hanafalah\ModulePayment\Contracts\Data\JournalBatchData;

class JournalBatch extends BaseModulePayment implements ContractsJournalBatch
{
    protected string $__entity = 'JournalBatch';
    public $journal_batch_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'journal_batch',
            'tags'     => ['journal_batch', 'journal_batch-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreJournalBatch(JournalBatchData $journal_batch_dto): Model{
        $add = [
            'note'           => $journal_batch_dto->note,
            'status'         => $journal_batch_dto->status,
            'author_type'    => $journal_batch_dto->author_type,
            'author_id'      => $journal_batch_dto->author_id,
        ];
        if (!isset($journal_batch_dto->id)){
            $guard = [
                'reference_type' => $journal_batch_dto->reference_type,
                'reference_id'   => $journal_batch_dto->reference_id,
                'reported_at'    => $journal_batch_dto->reported_at,
            ];
            $create = [$guard, $add];
        }else{
            $add = array_merge($add, [
                'reference_type' => $journal_batch_dto->reference_type,
                'reference_id'   => $journal_batch_dto->reference_id,
                'reported_at'    => $journal_batch_dto->reported_at,
            ]);
        }

        $journal_batch = $this->usingEntity()->updateOrCreate(...$create);
        $this->fillingProps($journal_batch,$journal_batch_dto->props);
        $journal_batch->save();
        return $this->journal_batch_model = $journal_batch;
    }
}