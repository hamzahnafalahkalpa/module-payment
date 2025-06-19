<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;

/**
 * @see \Hanafalah\ModulePayment\Schemas\Invoice
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method array storeInvoice(?InvoiceData $rab_work_list_dto = null)
 * @method bool deleteInvoice()
 * @method bool prepareDeleteInvoice(? array $attributes = null)
 * @method mixed getInvoice()
 * @method ?Model prepareShowInvoice(?Model $model = null, ?array $attributes = null)
 * @method array showInvoice(?Model $model = null)
 * @method array viewInvoiceList()
 * @method Collection prepareViewInvoiceList(? array $attributes = null)
 * @method LengthAwarePaginator prepareViewInvoicePaginate(PaginateData $paginate_dto)
 * @method array viewInvoicePaginate(?PaginateData $paginate_dto = null)
 * @method Builder function invoice(mixed $conditionals = null)
 */
interface Invoice extends DataManagement {}
