<?php

namespace Hanafalah\ModulePayment\Models\Accounting;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\ModulePayment\Resources\JournalBatch\{
    ViewJournalBatch,
    ShowJournalBatch
};
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class JournalBatch extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes;
    
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public $list = [
        'id',
        'reference_type',
        'reference_id',
        'reported_at',
        'note',
        'status',
        'author_type',
        'author_id',
        'props'
    ];

    protected $casts = [
        'name' => 'string'
    ];

    

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return [];
    }

    public function getViewResource(){
        return ViewJournalBatch::class;
    }

    public function getShowResource(){
        return ShowJournalBatch::class;
    }

    

    
}
