<?php

namespace Hanafalah\ModulePayment\Resources\BaseWalletTransaction;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewBaseWalletTransaction extends ApiResource
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
            'id'             => $this->id,
            'code'           => $this->code,
            'name'           => $this->reported_at,
            'channel_id'     => $this->channel_id,
            'channel'        => $this->prop_channel,
            'wallet_transaction' => $this->relationValidation('walletTransaction',function(){
                return $this->walletTransaction->toViewApi()->resolve();
            },$this->prop_wallet_transaction),
            'transaction'    => $this->relationValidation('transaction',function(){
                return $this->transaction->toViewApi()->resolve();
            },$this->prop_transaction),
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at
        ];

        return $arr;
    }
}
