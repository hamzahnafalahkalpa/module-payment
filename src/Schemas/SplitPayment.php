<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModulePayment\Contracts\Data\SplitPaymentData;
use Hanafalah\ModulePayment\Contracts\Schemas\SplitPayment as ContractsSplitPayment;
use Illuminate\Database\Eloquent\Model;

class SplitPayment extends PackageManagement implements ContractsSplitPayment
{
    protected string $__entity = 'SplitPayment';
    public $split_payment_model;

    public function prepareStoreSplitPayment(SplitPaymentData $split_payment_dto): Model{
        if ($split_payment_dto->payment_method_model->label == 'DEPOSIT'){
            $invoice_model = $split_payment_dto->invoice_model ?? $this->InvoiceModel()->findOrFail($split_payment_dto->invoice_id);
            $invoice_model->load(['payer.userWallet' => fn($q) => $q->where('props->prop_wallet->label','Personal Pocket')]);
            $user_wallet_model = $invoice_model->payer->userWallet;
            $split_payment_dto->user_wallet_id = $user_wallet_model->getKey();
            $split_payment_dto->user_wallet_model = $user_wallet_model;
        }

        $add = [
            'payment_method_id' => $split_payment_dto->payment_method_id,
            'money_paid' => $split_payment_dto->money_paid,
            'user_wallet_id' => $split_payment_dto->user_wallet_id
        ];
        if (isset($split_payment_dto->id)){
            $guard = ['id' => $split_payment_dto->id];
        }else{
            $guard = ['invoice_id' => $split_payment_dto->invoice_id];
        }
        $create = [$guard,$add];

        $split_payment = $this->usingEntity()->updateOrCreate(...$create);
        if (isset($split_payment_dto->user_wallet_model)){
            $split_payment_dto->props['prop_user_wallet'] = $split_payment_dto->user_wallet_model->toViewApi()->resolve();
            $this->schemaContract('user_wallet')->pepareBalanceAdjustment();
        }
        $this->fillingProps($split_payment, $split_payment_dto->props);
        $this->save();
        return $this->split_payment_model = $split_payment;
    }
}
