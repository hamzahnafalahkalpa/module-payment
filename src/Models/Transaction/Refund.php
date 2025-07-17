<?php

namespace Hanafalah\ModulePayment\Models\Transaction;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModuleTransaction\Concerns\HasTransaction;
use Hanafalah\ModulePayment\Resources\Refund\ShowRefund;
use Hanafalah\ModulePayment\Resources\Refund\ViewRefund;

class Refund extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes, HasTransaction;

    public $incrementing = false;
    protected $keyType   = "string";
    protected $primaryKey = 'id';
    protected $list      = ['id', 'billing_id', 'author_id', 'author_type', 'withdrawal_at', 'total', 'props'];
    protected $show      = [];
    protected static function booted(): void
    {
        parent::booted();
        static::creating(function ($query) {
            if (!isset($query->refund_code)) {
                $query->refund_code = static::hasEncoding('REFUND');
            }
        });
    }
    public function getShowResource()
    {
        return ShowRefund::class;
    }
    public function getViewResource()
    {
        return ViewRefund::class;
    }
    public function refundItem()
    {
        return $this->hasOneModel('RefundItem');
    }
    public function refundItems()
    {
        return $this->hasManyModel('RefundItem');
    }
    public function author()
    {
        return $this->morphTo();
    }
    public function transaction()
    {
        return $this->morphOneModel('Transaction', 'reference');
    }
    public function billing()
    {
        return $this->belongsToModel('Billing');
    }
}
