<?php

namespace Hanafalah\ModulePayment\Models;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\ModulePayment\Resources\CoaEntry\{
    ViewCoaEntry,
    ShowCoaEntry
};
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class CoaEntry extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes;
    
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public $list = [
        'id', 'journal_entry_id', 'coa_id', 'balance_type', 'value', 'props',
    ];

    protected $casts = [
        'name' => 'string',
        'balance_type' => 'string'
    ];

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return [];
    }

    public function getViewResource(){
        return ViewCoaEntry::class;
    }

    public function getShowResource(){
        return ShowCoaEntry::class;
    }

    public function coa(){return $this->belongsToModel('Coa');}
    public function journalEntry(){return $this->belongsToModel('JournalEntry');}
}
