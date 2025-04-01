<?php

namespace Hanafalah\ModulePayment\Models\Price;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModulePayment\Enums\Bank\Status;
use Hanafalah\ModulePayment\Resources\Bank\{ViewBank, ShowBank};
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends BaseModel
{
    use SoftDeletes, HasProps;
    protected $list = ['id', 'name', 'account_number', 'account_name', 'status', 'props'];

    protected $casts = [
        'name'            => 'string',
        'account_name'    => 'string',
        'account_number'  => 'string'
    ];

    protected static function booted(): void{
        parent::booted();
        static::addGlobalScope('bank-status', function ($query) {
            $query->where('status', Status::ACTIVE->value);
        });
        static::creating(function ($query) {
            if (!isset($query->status)) $query->status = Status::ACTIVE->value;
        });
    }

    public function getViewResource(){
        return ViewBank::class;
    }

    public function getShowResource(){
        return ShowBank::class;
    }
}
