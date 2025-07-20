<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\Contracts\Schemas\AccountGroup as ContractsAccountGroup;
use Hanafalah\ModulePayment\Contracts\Data\AccountGroupData;

class AccountGroup extends Coa implements ContractsAccountGroup
{
    protected string $__entity = 'AccountGroup';
    public $account_group_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'account_group',
            'tags'     => ['account_group', 'account_group-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreAccountGroup(AccountGroupData $account_group_dto): Model{
        $coa = $this->prepareStoreCoa($account_group_dto);
        if (isset($account_group_dto->coas) && count($account_group_dto->coas) > 0){
            foreach ($account_group_dto->coas as $coa_dto){
                $coa_dto->parent_id     = $coa->getKey();
                $coa_dto->coa_type_id ??= $account_group_dto->coa_type_id ?? null;
                $this->prepareStoreCoa($coa_dto);
            }
        }
        $coa->load('coas');
        return $this->account_group_model = $coa;
    }
}