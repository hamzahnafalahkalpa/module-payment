<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\Contracts\Schemas\JournalSource as ContractsJournalSource;
use Hanafalah\ModulePayment\Contracts\Data\JournalSourceData;
use Hanafalah\ModulePayment\Schemas\FinanceStuff;
use Illuminate\Database\Eloquent\Builder;

class JournalSource extends FinanceStuff implements ContractsJournalSource
{
    protected string $__entity = 'JournalSource';
    protected $__config_name = 'module-payment';
    public static $journal_source_model;
    protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'journal_source',
            'tags'     => ['journal_source', 'journal_source-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreJournalSource(JournalSourceData $journal_source_dto): Model{
        $journal_source = parent::prepareStoreFinanceStuff($journal_source_dto);
        return static::$journal_source_model = $journal_source;
    }

    public function journalSource(mixed $conditionals = null): Builder{
        return parent::financeStuff($conditionals);
    }
}