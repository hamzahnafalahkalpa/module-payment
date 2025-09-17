<?php

namespace Hanafalah\ModulePayment\Models\Transaction;

use Hanafalah\ModulePayment\Resources\Withdrawal\{ShowWithdrawal, ViewWithdrawal};

class Withdrawal extends BaseWalletTransaction{
    public $list = [
        'id',
        'code',
        'name',
        'reference_type',
        'reference_id',
        'props',
    ];

    protected static function booted(): void
    {
        parent::booted();
        static::creating(function ($query) {
            if (!isset($query->code)) $query->code = static::hasEncoding('Withdrawal');
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
            'reference'
        ];
    }

    public function getViewResource(){
        return ViewWithdrawal::class;
    }

    public function getShowResource(){
        return ShowWithdrawal::class;
    }

    public function WithdrawalItems(){return $this->morphManyModel('WithdrawalItem','reference');}
    public function invoice(){return $this->belongsToModel('Invoice');}
    public function withdrawal(){return $this->morphOneModel('Withdrawal','reference');}
}
