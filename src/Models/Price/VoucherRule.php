<?php

namespace Hanafalah\ModulePayment\Models\Price;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModulePayment\Enums\Voucher\Status;
use Hanafalah\ModulePayment\Resources\Voucher\{ViewVoucher, ShowVoucher};
use Hanafalah\ModulePayment\Resources\VoucherRule\{ViewVoucherRule, ShowVoucherRule};

class VoucherRule extends BaseModel
{
    use HasUlids, HasProps;

    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    protected $list       = [
        'id',
        'name',
        'voucher_id',
        'condition',
        'props'
    ];

    protected $casts = [
        'name' => 'string'
    ];

    public function getViewResource()
    {
        return ViewVoucherRule::class;
    }

    public function getShowResource()
    {
        return ShowVoucherRule::class;
    }

    public function voucher()
    {
        return $this->belongsToModel('Voucher');
    }
}
