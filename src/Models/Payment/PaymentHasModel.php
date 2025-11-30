<?php

namespace Hanafalah\ModulePayment\Models\Payment;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Hanafalah\LaravelSupport\Models\BaseModel;

class PaymentHasModel extends BaseModel
{
    use HasUlids;

    public $incrementing   = false;
    protected $keyType     = 'string';
    protected $primaryKey  = 'id';

    protected $list        = [
        'id',
        'payment_type',
        'payment_id',
        'model_type',
        'model_id'
    ];

    public function payment(){return $this->morphTo();}
    public function model(){return $this->morphTo();}
    public function paymentSummary(){return $this->morphOneModel('PaymentSummary', 'reference');}
}
