<?php

namespace Hanafalah\ModulePayment\Models\Price;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\ModulePayment\Resources\ComponentDetail\{ViewComponentDetail, ShowComponentDetail};

class ComponentDetail extends BaseModel
{
    use HasUlids, HasProps;

    public $timestamps    = false;
    public $incrementing  = false;
    protected $primaryKey = 'id';
    protected $keyType    = 'string';

    protected $list = ['id', 'reference_type', 'reference_id', 'flag', 'coa_id', 'props'];

    protected $casts = [
        'name' => 'string'
    ];

    public function getViewResource(){return ViewComponentDetail::class;}
    public function getShowResource(){return ShowComponentDetail::class;}
    public function reference(){return $this->morphTo();}
    public function coa(){return $this->belongsToModel('Coa');}
}
