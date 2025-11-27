<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\ModulePayment\Contracts\Data\PaymentHasModelData;
//use Hanafalah\ModulePayment\Contracts\Data\PaymentHasModelUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModulePayment\Schemas\PaymentHasModel
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updatePaymentHasModel(?PaymentHasModelData $payment_has_model_dto = null)
 * @method Model prepareUpdatePaymentHasModel(PaymentHasModelData $payment_has_model_dto)
 * @method bool deletePaymentHasModel()
 * @method bool prepareDeletePaymentHasModel(? array $attributes = null)
 * @method mixed getPaymentHasModel()
 * @method ?Model prepareShowPaymentHasModel(?Model $model = null, ?array $attributes = null)
 * @method array showPaymentHasModel(?Model $model = null)
 * @method Collection prepareViewPaymentHasModelList()
 * @method array viewPaymentHasModelList()
 * @method LengthAwarePaginator prepareViewPaymentHasModelPaginate(PaginateData $paginate_dto)
 * @method array viewPaymentHasModelPaginate(?PaginateData $paginate_dto = null)
 * @method array storePaymentHasModel(?PaymentHasModelData $payment_has_model_dto = null)
 * @method Collection prepareStoreMultiplePaymentHasModel(array $datas)
 * @method array storeMultiplePaymentHasModel(array $datas)
 */

interface PaymentHasModel extends DataManagement
{
    public function prepareStorePaymentHasModel(PaymentHasModelData $payment_has_model_dto): Model;
}