<?php

namespace Hanafalah\ModulePayment\Models\Transaction;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\ModulePayment\Resources\WalletTransaction\{
    ViewWalletTransaction,
    ShowWalletTransaction
};
use Hanafalah\ModulePayment\Enums\WalletTransaction\Status;

use Illuminate\Database\Eloquent\Concerns\HasUlids;

class WalletTransaction extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes;
    
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public $list = [
        'id',
        'uuid',
        'transaction_type',
        'name',
        'wallet_id',
        'user_wallet_id',
        'reference_type',
        'reference_id',
        'consument_type',
        'consument_id',
        'previous_balance',
        'current_balance',
        'nominal',
        'author_type',
        'author_id',
        'reported_at',
        'status',
        'props',
    ];

    protected $casts = [
        'name' => 'string'
    ];

    protected static function booted():void {
        parent::booted();
        static::creating(function($query){
            $query->status ??= self::getWalletTransactionStatus('DRAFT');
        });
    }

    public static function getWalletTransactionStatus(string $status){
        return Status::from($status)->value;
    }

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return [
            'consument','author', 'wallet', 'reference'
        ];
    }

    public function getViewResource(){
        return ViewWalletTransaction::class;
    }

    public function getShowResource(){
        return ShowWalletTransaction::class;
    }

   public function author(){return $this->morphTo();} 
   public function consument(){return $this->morphTo();} 
   public function reference(){return $this->morphTo();} 
   public function wallet(){return $this->belongsToModel('Wallet');} 
   public function userWallet(){return $this->belongsToModel('UserWallet');} 
}
