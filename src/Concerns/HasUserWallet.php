<?php

namespace Hanafalah\ModulePayment\Concerns;

trait HasUserWallet
{
    protected static function bootHasUserWallet(){
        static::created(function($model){
            $wallet = $model->WalletModel()->where('label','PERSONAL')->firstOrFail();
            app(config('app.contracts.UserWallet'))->prepareStoreUserWallet(
                $model->requestDTO(config('app.contracts.UserWalletData'),[
                    'wallet_id' => $wallet->getKey(),
                    'wallet_model' => $wallet,
                    'consument_type' => $model->getMorphClass(),
                    'consument_id' => $model->getKey(),
                    'balance' => 0,
                    'verifying' => true
                ])
            );
        });
    }

    public function userWallet(){return $this->morphOneModel('UserWallet','consument');}
    public function userWallets(){return $this->morphManyModel('UserWallet','consument')->where('props->prop_wallet->label','<>','PERSONAL');}
}
