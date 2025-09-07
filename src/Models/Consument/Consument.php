<?php

namespace Hanafalah\ModulePayment\Models\Consument;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModulePayment\Concerns\HasPaymentSummaryDeferred;
use Hanafalah\ModulePayment\Concerns\HasUserWallet;
use Hanafalah\ModulePayment\Resources\Consument\{
    ViewConsument, ShowConsument
};

class Consument extends BaseModel
{
    use HasUlids, HasProps, HasPaymentSummaryDeferred, HasUserWallet;

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
        'reference_type' => 'string',
        'name' => 'string'
    ];

    protected $getPropsQuery = [
        'name' => 'name'
    ];
    
    public function viewUsingRelation(){
        return ['paymentSummary','userWallet' => function($query){
            $query->where('props->prop_wallet->label','PERSONAL');
        }];
    }

    public function showUsingRelation(){
        return ['paymentSummary','userWallet' => function($query){
            $query->where('props->prop_wallet->label','PERSONAL');
        }];
    }

    public function getViewResource(){
        return ViewConsument::class;
    }

    public function getShowResource(){
        return ShowConsument::class;
    }

    public function reference(){return $this->morphTo();}
}
