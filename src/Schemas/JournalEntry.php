<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\{
    Supports\BaseModulePayment
};
use Hanafalah\ModulePayment\Contracts\Schemas\JournalEntry as ContractsJournalEntry;
use Hanafalah\ModulePayment\Contracts\Data\JournalEntryData;

class JournalEntry extends BaseModulePayment implements ContractsJournalEntry
{
    protected string $__entity = 'JournalEntry';
    public $journal_entry_model;

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
            'reported_at'      => $journal_entry_dto->reported_at,
        ];

        if (isset($journal_entry_dto->id)){
            $guard  = ['id' => $journal_entry_dto->id];
        }else{
            $guard = [
                'id'             => null,
                'reference_type' => $journal_entry_dto->reference_type,
                'reference_id'   => $journal_entry_dto->reference_id,
                'transaction_reference_id' => $journal_entry_dto->transaction_reference_id,
            ];
        }
        $journal_entry = $this->usingEntity()->updateOrCreate($guard,$add);
        if (isset($journal_entry_dto->coa_entries) && count($journal_entry_dto->coa_entries) > 0){
            $current_balance = 0;
            $kredit_balance  = 0;
            $debit_balance   = 0;
            foreach ($journal_entry_dto->coa_entries as $coa_entry){
                $coa_entry->journal_entry_id = $journal_entry->getKey();
                $coa_entry = $this->schemaContract('coa_entry')->prepareStoreCoaEntry($coa_entry);
                if ($coa_entry->balance_type == 'debit'){
                    $debit_balance += $coa_entry->value;
                }else{
                    $kredit_balance += $coa_entry->value;
                }
            }
            $current_balance = $debit_balance - $kredit_balance;
            $journal_entry->current_balance = $current_balance;
            $journal_entry->save();
        }

        if (isset($journal_entry_dto->journal_items) && count($journal_entry_dto->journal_items) > 0){
            foreach ($journal_entry_dto->journal_items as $journal_item){
                $journal_item->reference_type ??= $journal_entry->reference_type;
                $journal_item->reference_id   ??= $journal_entry->reference_id;
                $journal_item->parent_id   ??= $journal_entry->parent_id;
                $this->prepareStoreJournalEntry($journal_item);
            }
        }

        $this->fillingProps($journal_entry,$journal_entry_dto->props);
        $journal_entry->save();
        return $this->journal_entry_model = $journal_entry;
    }
}