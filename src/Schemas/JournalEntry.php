<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\{
    Supports\BaseModulePayment
};
use Hanafalah\ModulePayment\Contracts\Schemas\JournalEntry as ContractsJournalEntry;
use Hanafalah\ModulePayment\Contracts\Data\JournalEntryData;

class JournalEntry extends BaseModulePayment implements ContractsJournalEntry
{
    protected string $__entity = 'JournalEntry';
    public static $journal_entry_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'journal_entry',
            'tags'     => ['journal_entry', 'journal_entry-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreJournalEntry(JournalEntryData $journal_entry_dto): Model{
        $add = [
            'name'              => $journal_entry_dto->name ?? null,
            'journal_source_id' => $journal_entry_dto->journal_source_id,
            'author_type'       => $journal_entry_dto->author_type,
            'author_id'         => $journal_entry_dto->author_id,
        ];

        if (isset($journal_entry_dto->id)){
            $guard  = ['id' => $journal_entry_dto->id];
        }else{
            $guard = [
                'reference_type' => $journal_entry_dto->reference_type,
                'reference_id'   => $journal_entry_dto->reference_id,
                'transaction_id' => $journal_entry_dto->transaction_id,
            ];
        }

        $journal_entry = $this->usingEntity()->updateOrCreate($guard,$add);
        $this->fillingProps($journal_entry,$journal_entry_dto->props);
        $journal_entry->save();
        return static::$journal_entry_model = $journal_entry;
    }
}