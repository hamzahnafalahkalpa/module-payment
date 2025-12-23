<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModulePayment\Contracts\Schemas\Consument as ContractsConsument;
use Hanafalah\ModulePayment\Contracts\Data\ConsumentData;

class Consument extends PackageManagement implements ContractsConsument
{
    protected string $__entity = 'Consument';
    public $consument_model;

    public function prepareStoreConsument(ConsumentData $consument_dto): Model{
        $add = [
            'name'           => $consument_dto->name,
            'phone'          => $consument_dto->phone ?? null,
        ];
        if (isset($consument_dto->id)){
            $group  = ['id' => $consument_dto->id];
        }else{
            $group = [
                'reference_type' => $consument_dto->reference_type ?? null,
                'reference_id'   => $consument_dto->reference_id ?? null
            ];
        }
        $create = [$group,$add];
        $consument = $this->usingEntity()->updateOrCreate(...$create);
        $consument->generatePaymentSummaryDeferred();

        if (isset($consument_dto->reference_type) && isset($consument_dto->reference_id)) {
            $reference = $consument_dto->reference_model ?? $this->{$consument_dto->reference_type.'Model'}()->findOrFail($consument_dto->reference_id);
            $consument_dto->props['prop_reference'] = $reference->toViewApi()->resolve();
        }

        if (isset($consument_dto->user_wallet)) {
            $user_wallet_dto = &$consument_dto->user_wallet;
            $user_wallet_dto->consument_type = $consument->getMorphClass();
            $user_wallet_dto->consument_id = $consument->getKey();
            $this->schemaContract('user_wallet')->prepareStoreUserWallet($user_wallet_dto);
        }

        $this->fillingProps($consument,$consument_dto->props);
        $consument->save();
        return $this->consument_model = $consument;
    }
}