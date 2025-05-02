<?php

namespace Hanafalah\ModulePayment\Models\Price;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\ModulePayment\Resources\FinanceStuff\{
    ViewFinanceStuff,
    ShowFinanceStuff
};
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class FinanceStuff extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes;
    
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public $list = [
        'id',
        'parent_id',
        'flag',
        'name',
        'props',
    ];

    protected $casts = [
        'name' => 'string',
        'flag' => 'string'
    ];

    public function viewUsingRelation(): array{
        return ['childs'];
    }

    public function showUsingRelation(): array{
        return ['childs'];
    }

    public function getViewResource(){
        return ViewFinanceStuff::class;
    }

    public function getShowResource(){
        return ShowFinanceStuff::class;
    }
    
}
