<?php

namespace Hanafalah\ModulePayment\Models\Transaction;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModulePayment\Concerns\HasPaymentSummary;
use Hanafalah\ModuleTransaction\Concerns\HasTransaction;
use Hanafalah\ModulePayment\Resources\Invoice\ShowInvoice;
use Hanafalah\ModulePayment\Resources\Invoice\ViewInvoice;

class Invoice extends BaseModel
{
    use HasUlids, HasProps, HasPaymentSummary, HasTransaction;

    public $incrementing  = false;
    protected $primaryKey = 'id';
    protected $keyType    = "string";
    protected $list       = [
        'id',
        'author_id',
        'author_type',
        'consument_id',
        'consument_type',
        'paid_at',
        'generated_at',
        'billing_at',
        'props'
    ];
    protected $show  = ['invoice_code'];

    protected static function booted(): void
    {
        parent::booted();
        static::addGlobalScope('transaction_billing_deferred', function ($query) {
            $query->with('transactionBillingDeferred');
        });
        static::updated(function ($query) {
            if ($query->isDirty('billing_at')) {
                $consument = $query->consument;
                $consument->invoice()->firstOrCreate();

                $billing_deferred = app(config('database.models.BillingDeferred'))->find($query->getKey());
                $transaction      = $billing_deferred->transaction()->firstOrCreate([
                    'parent_id'   => $query->transaction->getKey()
                ]);
                $payment_summary  = $billing_deferred->paymentSummary()->firstOrCreate();
                $payment_summary->transaction_id = $transaction->getKey();
                $payment_summary->save();
            }
        });
    }

    public function getShowResource(){return ShowInvoice::class;}
    public function getViewResource(){return ViewInvoice::class;}
    public function scopeDraft($builder){return $builder->whereNull('billing_at');}
    public function scopeDeferred($builder){return $builder->whereNotNull('billing_at')->whereNull('paid_at');}
    public function scopePaid($builder){return $builder->whereNotNull('paid_at');}

    public function author(){return $this->morphTo('author');}
    public function consument(){return $this->morphTo('consument');}
    // public function listPaymentSummary(){return $this->paymentSummary()->with('childs');}
    public function transactionBillingDeferred(){
        return $this->hasOneModel('Transaction', 'reference_id', 'id')
                    ->where('reference_type', $this->BillingDeferredModelMorph());
    }
}
