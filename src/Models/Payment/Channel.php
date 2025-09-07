<?php

namespace Hanafalah\ModulePayment\Models\Payment;

use Hanafalah\ModulePayment\Models\Payment\PaymentMethod;
use Hanafalah\ModulePayment\Resources\Channel\{ShowChannel, ViewChannel};

class Channel extends PaymentMethod
{
    protected $table = 'unicodes';

    protected static function booted(): void{
        parent::booted();
        static::addGlobalScope('flag',function($query){
            $query->where('flag','PaymentMethod');
        });
        static::creating(function ($query) {
            $query->flag = 'PaymentMethod';
        });
        static::addGlobalScope('label',function($query){
            $query->whereNotIn('label',['CREDIT CARD']);
        });
    }

    public function getShowResource(){return ShowChannel::class;}
    public function getViewResource(){return ViewChannel::class;}
}
