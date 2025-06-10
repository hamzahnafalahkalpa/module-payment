<?php

namespace Hanafalah\ModulePayment\Models\Price;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModulePayment\Enums\Coa\Status;
use Hanafalah\ModulePayment\Resources\Coa\{ViewCoa, ShowCoa};
use Illuminate\Database\Eloquent\SoftDeletes;

class Coa extends BaseModel
{
    use SoftDeletes, HasProps;
    protected $list = ['id', 'parent_id', 'flag', 'name', 'coa_type_id', 'code', 'balance_type', 'status', 'props'];

    protected $casts = [
        'name' => 'string',
        'code' => 'string'
    ];

    protected static function booted(): void{
        parent::booted();
        static::addGlobalScope('coa-status', function ($query) {
            $query->flagIn(['Coa'])
                  ->where('status', Status::ACTIVE->value);
        });
        static::creating(function ($query) {
            $query->flag = 'Coa';
            if (!isset($query->status)) $query->status = Status::ACTIVE->value;
        });
    }

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return [
            'childs'
        ];
    }

    public function getViewResource(){
        return ViewCoa::class;
    }

    public function getShowResource(){
        return ShowCoa::class;
    }

    public function childs(){return $this->hasManyModel('Coa', 'parent_id')->with('childs');}
    public function accountGroup(){return $this->belongsToModel('AccountGroup', 'parent_id');}
}
