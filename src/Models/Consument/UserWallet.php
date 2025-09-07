<?php

namespace Hanafalah\ModulePayment\Models\Consument;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModulePayment\Enums\UserWallet\Status;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\ModulePayment\Resources\UserWallet\{
    ViewUserWallet,
    ShowUserWallet
};
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class UserWallet extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes;
    
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public $list = [
        'id',
        'user_wallet_code',
        'uuid',
        'wallet_id',
        'consument_type',
        'consument_id',
        'balance',
        'verified_at',
        'suspended_at',
        'status',
        'props',
    ];

    protected $casts = [
        'name' => 'string',
        'uuid' => 'string',
        'user_wallet_code' => 'string',
        'consument_name' => 'string'
    ];

    public function getPropsQuery(): array{
        return [
            'consument_name' => 'props->prop_consument->name',
        ];
    }

    protected static function booted(): void{
        parent::booted();
        static::creating(function ($query) {
            $query->user_wallet_code ??= static::hasEncoding('USER_WALLET');
            $query->status ??= self::getUserWalletStatus('DRAFT');
        });
    }

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return [
            'wallet', 'consument'
        ];
    }

    public static function getUserWalletStatus(string $status){
        return Status::from($status)->value;
    }

    public function getViewResource(){
        return ViewUserWallet::class;
    }

    public function getShowResource(){
        return ShowUserWallet::class;
    }

    public function wallet(){return $this->belongsToModel('Wallet');}    
    public function consument(){return $this->belongsToModel('Consument');}    
}
