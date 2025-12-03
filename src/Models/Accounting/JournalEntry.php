<?php

namespace Hanafalah\ModulePayment\Models\Accounting;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\ModulePayment\Resources\JournalEntry\{
    ViewJournalEntry,
    ShowJournalEntry
};
use Hanafalah\ModuleTransaction\Concerns\HasTransaction;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class JournalEntry extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes, HasTransaction;
    
    const STATUS_DRAFT = 'DRAFT';
    const STATUS_POSTED = 'POSTED';

    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public $list = [
        'id', 'parent_id', 'name', 'reference_type', 'reference_id',
        'transaction_reference_id', 'journal_source_id',
        'reported_at', 'status', 'current_balance',
        'author_type', 'author_id', 'props',
    ];

    protected $casts = [
        'name' => 'string',
        'reported_at' => 'datetime',
        'journal_source_name' => 'string'
    ];

    public function getPropsQuery(): array{
        return ['journal_source_name' => 'props->prop_journal_source->name'];
    }

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return [
            'transactionReference', 'journalSource',
            'coaEntries', 'reference', 'author',
            'journalItems'
        ];
    }

    public function getViewResource(){
        return ViewJournalEntry::class;
    }

    public function getShowResource(){
        return ShowJournalEntry::class;
    }

    public function journalSource(){return $this->belongsToModel('JournalSource');}
    public function transactionReference(){return $this->belongsToModel('Transaction','transaction_reference_id');}
    public function reference(){return $this->morphTo();}
    public function author(){return $this->morphTo();}
    public function coaEntries(){return $this->hasManyModel('CoaEntry');}
    public function journalItems(){return $this->hasManyModel('JournalEntry','parent_id')->with(['journalSource','coaEntries']);}
}
