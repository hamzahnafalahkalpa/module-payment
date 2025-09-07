<?php

namespace Hanafalah\ModulePayment\Models\Transaction;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModulePayment\Concerns\HasWalletTransaction;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\ModulePayment\Resources\BaseWalletTransaction\{
    ViewBaseWalletTransaction,
    ShowBaseWalletTransaction
};
use Hanafalah\ModuleTransaction\Concerns\HasTransaction;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class BaseWalletTransaction extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes, HasWalletTransaction, HasTransaction;
    
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public $list = [
        'id',
        'code',
        'name',
        'channel_id',
        'props',
    ];

    protected $casts = [
        'name' => 'string'
    ];

    public function viewUsingRelation(): array{
        return ['walletTransaction'];
    }

    public function showUsingRelation(): array{
        return ['walletTransaction'];
    }

    public function getViewResource(){
        return ViewBaseWalletTransaction::class;
    }

    public function getShowResource(){
        return ShowBaseWalletTransaction::class;
    }

    public function channel(){return $this->belongsToModel('Channel');}
}
