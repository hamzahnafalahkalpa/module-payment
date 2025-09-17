<?php

namespace Hanafalah\ModulePayment\Models\Transaction;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModulePayment\Concerns\HasInvoice;
use Hanafalah\ModuleTransaction\Concerns\HasTransaction;
use Hanafalah\ModulePayment\Resources\SplitPayment\{
    ViewSplitPayment
};

class SplitPayment extends BaseModel
{
    use HasUlids, HasProps, HasInvoice, SoftDeletes, HasTransaction;

    public $incrementing = false;
    protected $keyType   = "string";
    protected $primaryKey = 'id';
    protected $list      = [
        'id',
        'payment_method_id',
        'invoice_id',
        'money_paid',
        'user_wallet_id',
        'paid',
        'props'
    ];

    protected static function booted(): void
    {
        parent::booted();
        static::creating(function ($query) {
            if (!isset($query->split_payment_code)) {
                $query->split_payment_code = static::hasEncoding('SPLIT_PAYMENT');
            }
        });
    }

    public function getShowResource(){return ViewSplitPayment::class;}
    public function getViewResource(){return ViewSplitPayment::class;}

    public function paymentMethod(){return $this->belongsToModel('PaymentMethod');}
    public function invoice(){return $this->belongsToModel('Invoice');}
    public function userWallet(){return $this->belongsToModel('UserWallet');}
}
