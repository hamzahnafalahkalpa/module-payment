<?php

namespace Hanafalah\ModulePayment\Models\Transaction;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModulePayment\Resources\Deposit\ShowDeposit;
use Hanafalah\ModulePayment\Resources\Deposit\ViewDeposit;

class Deposit extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes;

    public $incrementing = false;
    protected $keyType   = "string";
    protected $primaryKey = 'id';
    protected $list      = ['id', 'reference_type', 'reference_id', 'reported_at', 'total', 'props'];
    protected $show      = [];

    public $casts = [
        'reported_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        parent::booted();
        static::creating(function ($query) {
            if (!isset($query->deposit_code)) {
                $query->deposit_code = static::hasEncoding('DEPOSIT');
            }
        });
    }

    public function getShowResource()
    {
        return ShowDeposit::class;
    }

    public function getViewResource()
    {
        return ViewDeposit::class;
    }

    public function reference()
    {
        return $this->morphTo();
    }
}
