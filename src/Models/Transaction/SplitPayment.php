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
        'billing_id',
        'money_paid',
        'paid',
        'invoice_id',
        'payer_id',
        'payer_type',
        'props'
    ];
    protected $show      = [];

    protected static function booted(): void
    {
        parent::booted();
        static::creating(function ($query) {
            if (!isset($query->split_payment_code)) {
                $query->split_payment_code = static::hasEncoding('SPLIT_BILL');
            }
        });
    }

    public function getShowResource(){return ViewSplitPayment::class;}
    public function getViewResource(){return ViewSplitPayment::class;}

    public function getPaymentDetails()
    {
        $payment_history = $this->paymentHistory;
        $transaction_id = $payment_history->transaction_id;
        return $this->PaymentDetailModel()
            ->select('qty', 'amount', 'debt', 'tax', 'additional', 'props', 'transaction_item_id', 'id')
            ->with([
                'transactionItem:id,item_name',
                'transactionItem.item'
            ])
            ->whereHas('paymentHistory', function ($query) use ($transaction_id) {
                $query->where('transaction_id', $transaction_id);
            })->get()
            ->each(function ($data) {
                $data->transactionItem->item = $data->transactionItem->item ?? null;
            });
    }

    public function paymentMethod(){return $this->belongsToModel('PaymentMethod');}
    public function billing(){return $this->belongsToModel('Billing');}
    public function payer(){return $this->morphTo();}
    public function paymentHistory(){return $this->morphOneModel('PaymentHistory', 'reference', 'reference_type', 'reference_id', 'id');}
}
