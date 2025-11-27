<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\Contracts\Schemas\PaymentHasModel as ContractsPaymentHasModel;
use Hanafalah\ModulePayment\Contracts\Data\PaymentHasModelData;

class PaymentHasModel extends PackageManagement implements ContractsPaymentHasModel
{
    protected string $__entity = 'PaymentHasModel';
    public $payment_has_model_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'payment_has_model',
            'tags'     => ['payment_has_model', 'payment_has_model-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStorePaymentHasModel(PaymentHasModelData $payment_has_model_dto): Model{
        $add = [
            'payment_type' => $payment_has_model_dto->payment_type,
            'payment_id' => $payment_has_model_dto->payment_id,
            'model_type' => $payment_has_model_dto->model_type,
            'model_id' => $payment_has_model_dto->model_id,
        ];
        $payment_has_model = $this->usingEntity()->updateOrCreate($add);
        $this->fillingProps($payment_has_model,$payment_has_model_dto->props);
        $payment_has_model->save();
        return $this->payment_has_model_model = $payment_has_model;
    }
}