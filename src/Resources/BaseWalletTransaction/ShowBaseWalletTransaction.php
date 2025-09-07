<?php

namespace Hanafalah\ModulePayment\Resources\BaseWalletTransaction;

class ShowBaseWalletTransaction extends ViewBaseWalletTransaction
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
            'wallet_transaction' => $this->relationValidation('walletTransaction',function(){
                return $this->walletTransaction->toShowApi();
            },$this->prop_wallet_transaction),
            'transaction'    => $this->relationValidation('transaction',function(){
                return $this->transaction->toShowApi();
            },$this->prop_transaction),
            'form' => $this->form
        ];
        $arr = $this->mergeArray(parent::toArray($request),$arr);
        return $arr;
    }
}
