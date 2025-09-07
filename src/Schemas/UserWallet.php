<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\{
    Supports\BaseModulePayment
};
use Hanafalah\ModulePayment\Contracts\Data\UserWalletAdjustmentData;
use Hanafalah\ModulePayment\Contracts\Schemas\UserWallet as ContractsUserWallet;
use Hanafalah\ModulePayment\Contracts\Data\UserWalletData;

class UserWallet extends BaseModulePayment implements ContractsUserWallet
{
    protected string $__entity = 'UserWallet';
    public $user_wallet_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'user_wallet',
            'tags'     => ['user_wallet', 'user_wallet-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreUserWallet(UserWalletData $user_wallet_dto): Model{
        $add = [
            'balance' => $user_wallet_dto->balance,
            'verified_at' => $user_wallet_dto->verified_at,
            'suspended_at' => $user_wallet_dto->suspended_at,
            'status' => $user_wallet_dto->status
        ];
        if (isset($user_wallet_dto->id)){
            $guard  = ['id' => $user_wallet_dto->id];
        }else{
            $guard = [
                'wallet_id' => $user_wallet_dto->wallet_id,
                'consument_type' => $user_wallet_dto->consument_type,
                'consument_id' => $user_wallet_dto->consument_id,
            ];
        }
        $create = [$guard, $add];
        $user_wallet = $this->usingEntity()->updateOrCreate(...$create);
        $this->fillingProps($user_wallet,$user_wallet_dto->props);
        $user_wallet->save();
        return $this->user_wallet_model = $user_wallet;
    }

    public function pepareBalanceAdjustment(UserWalletAdjustmentData $user_wallet_adjusment_dto): Model{
        $user_wallet_model = $user_wallet_adjusment_dto->user_wallet_model;
        $user_wallet_model->balance = $user_wallet_adjusment_dto->balance;
        $user_wallet_model->save();
        return $user_wallet_model;
    }
}