<?php

namespace Hanafalah\ModulePayment\Models\Payment;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModulePayment\Resources\PaymentSummary\ShowPaymentSummary;
use Hanafalah\ModulePayment\Resources\PaymentSummary\ViewPaymentSummary;

class PaymentSummary extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes;

    public $incrementing  = false;
    protected $keyType    = "string";
    protected $primaryKey = 'id';
    protected $list       = ['id', 'transaction_id', 'reference_type', 'amount', 'cogs', 'discount', 'debt', 'props'];
    protected $show       = ['parent_id', 'reference_id', 'refund', 'tax', 'paid', 'additional'];

    protected $casts = [
        'generated_at' => 'datetime',
    ];

    public function getPropsQuery(): array
    {
        return [
            'generated_at' => 'created_at',
        ];
    }

    protected static function booted(): void
    {
        parent::booted();
        static::created(function ($query) {
            static::recalculating($query);
        });
        static::updated(function ($query) {
            if ($query->isDirty('debt') || $query->isDirty('amount') || $query->isDirty('parent_id')) {
                static::recalculating($query);
            }
        });
        static::deleted(function ($query) {
            static::recalculating($query, true);
        });
    }

    private static function calculateCurrent($query, $field, $is_deleting = false)
    {
        $value = $query->{$field};
        if ($is_deleting) {
            $value *= -1;
        } else {
            $original_value = $query->getOriginal($field) ?? 0;
        }
        return ($value ?? 0) - ($original_value ?? 0);
    }

    protected static function recalculating($query, $is_deleting = false, $is_update_parent = true)
    {
        if ($query->isDirty('parent_id') && !$is_update_parent) {
            $previous_parent = $query->parent;
            $is_deleting = true;
        } else {
            
            if (!$query->isDirty('parent_id')) {
                $query->load('parent');
            }
        }
        $parent_payment_summary = $query->parent;
        if (isset($parent_payment_summary)) {
            $rate_names = ['debt', 'amount', 'total_tax', 'additional', 'discount', 'cogs', 'paid', 'refund'];
            foreach ($rate_names as $rate_name) {
                $parent_payment_summary->{$rate_name} += (!$is_update_parent) 
                    ? $query->{$rate_name} 
                    : static::calculateCurrent($query, $rate_name, $is_deleting);
            }
            // if ($query->reference_type == 'VisitRegistration') dd($query);

            $parent_payment_summary->save();
        }
        if (isset($previous_parent)) {
            $query->load('parent');
            self::recalculating($query, false, false);
        }
    }

    public function getShowResource(){
        return ShowPaymentSummary::class;
    }

    public function getViewResource(){
        return ViewPaymentSummary::class;
    }

    public function scopeDebtNotZero($builder){return $builder->gt('debt', 0);}

    public function reference(){return $this->morphTo();}
    public function tariffComponent(){return $this->belongsToModel('TariffComponent');}
    public function paymentDetail(){return $this->hasOneModel('PaymentDetail');}
    public function paymentDetails(){return $this->hasManyModel('PaymentDetail');}
    public function transaction(){return $this->belongsToModel('Transaction');}
    public function recursiveInvoiceChilds(){
        return $this->hasManyModel('PaymentSummary', 'parent_id')
                    ->with(['paymentDetails.transactionItem', 'recursiveInvoiceChilds'])->where('amount', '>', 0);
    }
    public function recursiveChilds(){
        return $this->hasManyModel('PaymentSummary', 'parent_id')
            ->with([
                'paymentDetails' => function ($query) {
                    $query->with('transactionItem');
                },
                'recursiveChilds'
            ]);
    }
    public function recursiveParent(){return $this->belongsToModel('PaymentSummary', 'parent_id')->with('recursiveParent');}
    public function paymentHasModel(){return $this->morphOneModel('PaymentHasModel', 'model');}
    public function transactionItem(){return $this->morphOneModel('TransactionItem', 'item');}
}
