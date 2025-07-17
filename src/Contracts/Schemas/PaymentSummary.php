<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;

/**
 * @see \Hanafalah\ModulePayment\Schemas\PaymentSummary
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method array storePaymentSummary(?PaymentSummaryData $rab_work_list_dto = null)
 * @method bool deletePaymentSummary()
 * @method bool prepareDeletePaymentSummary(? array $attributes = null)
 * @method mixed getPaymentSummary()
 * @method ?Model prepareShowPaymentSummary(?Model $model = null, ?array $attributes = null)
 * @method array showPaymentSummary(?Model $model = null)
 * @method array viewPaymentSummaryList()
 * @method Collection prepareViewPaymentSummaryList(? array $attributes = null)
 * @method LengthAwarePaginator prepareViewPaymentSummaryPaginate(PaginateData $paginate_dto)
 * @method array viewPaymentSummaryPaginate(?PaginateData $paginate_dto = null)
 * @method Builder function paymentSummary(mixed $conditionals = null)
 */
interface PaymentSummary extends DataManagement
{
}
