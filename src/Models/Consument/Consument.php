<?php

namespace Hanafalah\ModulePayment\Models\Consument;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModulePayment\Concerns\HasBillingDeferred;
use Hanafalah\ModulePayment\Resources\Consument\{
    ViewConsument, ShowConsument
};

class Consument extends BaseModel
{
    use HasUlids, HasProps, HasBillingDeferred;

    public $incrementing  = false;
    protected $primaryKey = 'id';
    protected $keyType    = 'string';

    protected $list = [
        'id',
        'uuid',
        'name',
        'phone',
        'reference_id',
        'reference_type',
        'props'
    ];
    protected $show = [];

    protected $casts = [
        'name' => 'string'
    ];

    protected $getPropsQuery = [
        'name' => 'name'
    ];

    public function getViewResource(){
        return ViewConsument::class;
    }

    public function getShowResource(){
        return ShowConsument::class;
    }

    public function reference(){return $this->morphTo();}
}
