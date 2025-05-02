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
    protected $list = ['id', 'flag', 'name', 'code','status', 'props'];

    protected $casts = [
        'name' => 'string'
    ];

    protected static function booted(): void{
        parent::booted();
        static::addGlobalScope('coa-status', function ($query) {
            $query->where('status', Status::ACTIVE->value);
        });
        static::creating(function ($query) {
            if (!isset($query->status)) $query->status = Status::ACTIVE->value;
        });
    }

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return [];
    }

    public function getViewResource(){
        return ViewCoa::class;
    }

    public function getShowResource(){
        return ShowCoa::class;
    }

    public function childs(){return $this->hasManyModel('Coa', 'parent_id')->with('childs');}
}
