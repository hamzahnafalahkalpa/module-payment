<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\ModuleTransaction\Contracts\Schemas\TransactionItem;

/**
 * @see \Hanafalah\ModuleTransaction\Schemas\RefundItem
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method mixed export(string $type)
 * @method array updateRefundItem(?RefundItemData $refund_item_dto = null)
 * @method Model prepareUpdateRefundItem(RefundItemData $refund_item_dto)
 * @method bool deleteRefundItem()
 * @method bool prepareDeleteRefundItem(? array $attributes = null)
 * @method mixed getRefundItem()
 * @method ?Model prepareShowRefundItem(?Model $model = null, ?array $attributes = null)
 * @method array showRefundItem(?Model $model = null)
 * @method Collection prepareViewRefundItemList()
 * @method array viewRefundItemList()
 * @method LengthAwarePaginator prepareViewRefundItemPaginate(PaginateData $paginate_dto)
 * @method array viewRefundItemPaginate(?PaginateData $paginate_dto = null)
 * @method array storeRefundItem(?RefundItemData $refund_item_dto = null);
 */
interface RefundItem extends TransactionItem {}
