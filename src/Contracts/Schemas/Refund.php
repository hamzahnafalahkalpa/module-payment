<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

/**
 * @see \Hanafalah\ModuleTransaction\Schemas\Refund
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method mixed export(string $type)
 * @method array updateRefund(?RefundData $refund_dto = null)
 * @method Model prepareUpdateRefund(RefundData $refund_dto)
 * @method bool deleteRefund()
 * @method bool prepareDeleteRefund(? array $attributes = null)
 * @method mixed getRefund()
 * @method ?Model prepareShowRefund(?Model $model = null, ?array $attributes = null)
 * @method array showRefund(?Model $model = null)
 * @method Collection prepareViewRefundList()
 * @method array viewRefundList()
 * @method LengthAwarePaginator prepareViewRefundPaginate(PaginateData $paginate_dto)
 * @method array viewRefundPaginate(?PaginateData $paginate_dto = null)
 * @method array storeRefund(?RefundData $refund_dto = null);
 */
interface Refund extends BaseWalletTransaction {}
