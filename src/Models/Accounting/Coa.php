<?php

namespace Hanafalah\ModulePayment\Models\Accounting;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModulePayment\Enums\Coa\Status;
use Hanafalah\ModulePayment\Resources\Coa\{ViewCoa, ShowCoa};
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coa extends BaseModel
{
    use SoftDeletes, HasProps, HasUlids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    protected $list = [
        'id', 'parent_id', 'flag', 'name', 'coa_template_id', 'reference_type', 'reference_id',
        'coa_type_id', 'code', 'balance_type', 'status', 'props'
    ];

    protected $casts = [
        'name' => 'string',
        'code' => 'string'
    ];

    protected static function booted(): void{
        parent::booted();
        static::addGlobalScope('coa-status', function ($query) {
            $query->where('flag', 'Coa')
                  ->where('status', Status::ACTIVE->value);
        });
        static::creating(function ($query) {
            $query->flag = 'Coa';
            if (!isset($query->status)) $query->status = Status::ACTIVE->value;
        });
    }

    public function viewUsingRelation(): array{
        return ['childs'];
    }

    public function showUsingRelation(): array{
        return ['childs'];
    }

    public function getViewResource(){
        return ViewCoa::class;
    }

    public function getShowResource(){
        return ShowCoa::class;
    }

    public function parent(){return $this->belongsToModel('Coa', 'parent_id','id');}
    public function childs(){return $this->hasManyModel('Coa', 'parent_id','id')->with('childs');}
    public function accountGroup(){return $this->belongsToModel('AccountGroup', 'parent_id');}
    public function coaTemplate(){return $this->belongsToModel('Coa', 'coa_template_id');}
    public function reference(){return $this->morphTo();}
}
