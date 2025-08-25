<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

/**
 * @see \Hanafalah\ModulePayment\Schemas\PaymentHistoryDetail
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updatePaymentHistoryDetail(?PaymentHistoryDetailData $payment_history_detail_dto = null)
 * @method Model prepareUpdatePaymentHistoryDetail(PaymentHistoryDetailData $payment_history_detail_dto)
 * @method bool deletePaymentHistoryDetail()
 * @method bool prepareDeletePaymentHistoryDetail(? array $attributes = null)
 * @method mixed getPaymentHistoryDetail()
 * @method ?Model prepareShowPaymentHistoryDetail(?Model $model = null, ?array $attributes = null)
 * @method array showPaymentHistoryDetail(?Model $model = null)
 * @method Collection prepareViewPaymentHistoryDetailList()
 * @method array viewPaymentHistoryDetailList()
 * @method LengthAwarePaginator prepareViewPaymentHistoryDetailPaginate(PaginateData $paginate_dto)
 * @method array viewPaymentHistoryDetailPaginate(?PaginateData $paginate_dto = null)
 * @method array storePaymentHistoryDetail(?PaymentHistoryDetailData $payment_history_detail_dto = null)
 */
interface PaymentHistoryDetail extends PaymentDetail {}
