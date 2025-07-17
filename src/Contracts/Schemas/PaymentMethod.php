<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

/**
 * @see \Hanafalah\ModulePayment\Schemas\PaymentMethod
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method array storePaymentMethod(?PaymentMethodData $rab_work_list_dto = null)
 * @method bool deletePaymentMethod()
 * @method bool prepareDeletePaymentMethod(? array $attributes = null)
 * @method mixed getPaymentMethod()
 * @method ?Model prepareShowPaymentMethod(?Model $model = null, ?array $attributes = null)
 * @method array showPaymentMethod(?Model $model = null)
 * @method array viewPaymentMethodList()
 * @method Collection prepareViewPaymentMethodList(? array $attributes = null)
 * @method LengthAwarePaginator prepareViewPaymentMethodPaginate(PaginateData $paginate_dto)
 * @method array viewPaymentMethodPaginate(?PaginateData $paginate_dto = null)
 * @method Builder function paymentMethod(mixed $conditionals = null)
 */
interface PaymentMethod extends FinanceStuff {}
