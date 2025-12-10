<?php

namespace Hanafalah\ModulePayment\Models\Transaction;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModulePayment\Resources\Billing\{
    ShowBilling,
    ViewBilling
};
use Illuminate\Support\Str;
use Hanafalah\ModuleTransaction\Concerns\HasTransaction;
use Hanafalah\ModulePayment\Enums\Billing\Status;

class Billing extends BaseModel
{
    use HasUlids, HasProps, HasTransaction;

    public $incrementing  = false;
    protected $keyType    = "string";
    protected $primaryKey = 'id';
    protected $list       = [
        'id',
        'uuid',
        'billing_code',
        'has_transaction_id',
        'author_type',
        'author_id',
        'cashier_type',
        'cashier_id',
        'status',
        'reported_at',
        'props'
    ];
    protected $show  = [];

    protected $casts = [
        'billing_code' => 'string',
        'has_transaction_id' => 'string',
        'author_type' => 'string',
        'author_id' => 'string',
        'cashier_type' => 'string',
        'cashier_id' => 'string'
    ];

    protected static function booted(): void
    {
        parent::booted();
        static::creating(function ($query) {
            if (!isset($query->billing_code)) $query->billing_code = static::hasEncoding('BILLING');
            if (!isset($query->uuid))         $query->uuid = Str::orderedUuid();
            if (!isset($query->status))       $query->status = Status::DRAFT->value;
        });
    }

    public function viewUsingRelation(): array{
        return ['hasTransaction'];
    }

    public function showUsingRelation(): array{
        return [
            'hasTransaction',
            'invoices' => function($query){
                return $query->with([
                    'paymentSummary' =>function($query){
                        return $query->with([
                            'paymentDetails',
                            'recursiveChilds'
                        ]);
                    },
                    'paymentHistory' => function($query){
                        return $query->with([
                            'paymentHistoryDetails',
                            'childs'
                        ]);
                    },
                    'splitPayments'
                ])->orderBy('created_at','desc');
            },
        ];
    }

    public function getShowResource(){
        return ShowBilling::class;
    }

    public function getViewResource(){
        return ViewBilling::class;
    }

    public function reference(){return $this->morphTo();}
    public function paymentHistory(){return $this->morphOneModel('PaymentHistory', 'reference');}
    public function paymentHistories(){return $this->morphManyModel('PaymentHistory', 'reference');}
    public function cashier(){return $this->morphTo();}
    public function author(){return $this->morphTo();}
    public function hasTransaction(){return $this->belongsToModel("Transaction",'has_transaction_id');}
    public function deferredPayments(){return $this->hasManyModel("DeferredPayment",'billing_id');}
    public function invoice(){return $this->hasOneModel("Invoice",'billing_id');}
    public function invoices(){return $this->hasManyModel("Invoice",'billing_id');}
}
