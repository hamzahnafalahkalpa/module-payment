<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModulePayment\Contracts\Schemas\Bank as ContractsBank;
use Hanafalah\ModulePayment\Contracts\Data\BankData;

class Bank extends PackageManagement implements ContractsBank
{
    protected string $__entity = 'Bank';
    public $bank_model;
    protected mixed $__order_by_created_at = false; //asc, desc, false

    public function prepareStoreBank(BankData $bank_dto): Model{
        if (isset($bank_dto->id)) {
            $model = $this->BankModel()->updateOrCreate(['id' => $bank_dto->id],[
                'status'         => $bank_dto->status,
                'name'           => $bank_dto->name,
                'account_number' => $bank_dto->account_number,
                'account_name'   => $bank_dto->account_name
            ]);
        }else{
            $model = $this->BankModel()->updateOrCreate([
                'name'           => $bank_dto->name,
                'account_number' => $bank_dto->account_number,
                'account_name'   => $bank_dto->account_name
            ],[
                'status' => $bank_dto->status
            ]);
        }

        return $this->bank_model = $model;
    }
}
