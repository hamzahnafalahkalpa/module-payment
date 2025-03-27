<?php

namespace Hanafalah\ModulePayment\Models\Transaction;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModulePayment\Resources\RefundItem\{
    ShowRefundItem,
    ViewRefundItem
};

class RefundItem extends BaseModel
{
    use HasUlids, HasProps;

    protected $list      = [
        'id',
        'refund_id',
        'item_type',
        'item_id',
        'props'
    ];
    protected $show      = [];

    public function toShowApi()
    {
        return new ShowRefundItem($this);
    }

    public function toViewApi()
    {
        return new ViewRefundItem($this);
    }

    public function item()
    {
        return $this->morphTo();
    }
    public function refund()
    {
        return $this->belongsToModel('Refund');
    }
}
