<?php

namespace Hanafalah\ModulePayment\Models\Transaction;

use Hanafalah\ModulePayment\Resources\Refund\{ShowRefund, ViewRefund};

class Refund extends BaseWalletTransaction{
    public $list = [
        'id',
        'code',
        'name',
        'invoice_id',
        'props',
    ];

    protected static function booted(): void
    {
        parent::booted();
        static::creating(function ($query) {
            if (!isset($query->code)) $query->code = static::hasEncoding('Refund');
        });
    }

    public function viewUsingRelation(): array{
        return [
            'walletTransaction'
        ];
    }

    public function showUsingRelation(): array{
        return [
            'walletTransaction',
            'refundItems'
        ];
    }

    public function getViewResource(){
        return ViewRefund::class;
    }

    public function getShowResource(){
        return ShowRefund::class;
    }

    public function refundItems(){return $this->morphManyModel('RefundItem','reference');}
    public function invoice(){return $this->belongsToModel('Invoice');}
}
