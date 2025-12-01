<?php

namespace Hanafalah\ModulePayment\Models\Transaction;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModulePayment\Concerns\HasPaymentSummary;
use Hanafalah\ModuleTransaction\Concerns\HasTransaction;
use Hanafalah\ModulePayment\Resources\Invoice\ShowInvoice;
use Hanafalah\ModulePayment\Resources\Invoice\ViewInvoice;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends BaseModel
{
    use HasUlids, HasProps, HasPaymentSummary, HasTransaction, SoftDeletes;

    public $incrementing  = false;
    protected $primaryKey = 'id';
    protected $keyType    = "string";
    protected $list       = [
        'id',
        'flag',
        'invoice_code',
        'author_id',
        'author_type',
        'payer_id',
        'payer_type',
        'billing_id',
        'reported_at',
        'paid_at',
        'props'
    ];

    public function viewUsingRelation(){
        return [
            'billing.hasTransaction.reference',
            'paymentSummary', 'paymentHistory'
        ];
    }

    public function showUsingRelation(){
        return [
            'billing.hasTransaction.reference',
            'paymentSummary' => function($query){
                return $query->with([
                    'paymentDetails',
                    'recursiveChilds'
                ]);
            },
            'paymentHistory' => function($query){
                return $query->with([
                    'childs.paymentHistoryDetails',
                ]);
            },
            'splitPayments'
        ];
    }

    protected static function booted(): void
    {
        parent::booted();
        static::addGlobalScope('flag',function($query){
            $query->flagIn((new static)->getMorphClass()); 
        });
        static::creating(function($query){
            $query->invoice_code ??= self::hasEncoding('INVOICE');
            $query->flag ??= (new static)->getMorphClass();
        });
    }

    public function getShowResource(){return ShowInvoice::class;}
    public function getViewResource(){return ViewInvoice::class;}
    public function paymentSummary(){return $this->morphOneModel('PaymentSummary', 'reference')->where('props->is_deferred',true);}
    public function paymentSummaries(){return $this->morphManyModel('PaymentSummary', 'reference')->where('props->is_deferred',true);}
    public function scopeDeferred($builder){return $builder->whereNotNull('billing_at')->whereNull('paid_at');}
    public function scopePaid($builder){return $builder->whereNotNull('paid_at');}

    public function splitPayments(){return $this->hasManyModel('SplitPayment');}
    public function billing(){return $this->belongsToModel('Billing');}
    public function paymentHistory(){return $this->morphOneModel('PaymentHistory','reference')->where('props->is_deferred',false);}
    public function author(){return $this->morphTo();}
    public function payer(){return $this->morphTo();}

    public function transactionDeferredPayment(){
        return $this->hasOneModel('Transaction', 'reference_id', 'id')
                    ->where('reference_type', $this->DeferredPaymentModelMorph());
    }
}
