<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\ModulePayment\Contracts\Data\ChannelData;
//use Hanafalah\ModulePayment\Contracts\Data\ChannelUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModulePayment\Schemas\Channel
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updateChannel(?ChannelData $channel_dto = null)
 * @method Model prepareUpdateChannel(ChannelData $channel_dto)
 * @method bool deleteChannel()
 * @method bool prepareDeleteChannel(? array $attributes = null)
 * @method mixed getChannel()
 * @method ?Model prepareShowChannel(?Model $model = null, ?array $attributes = null)
 * @method array showChannel(?Model $model = null)
 * @method Collection prepareViewChannelList()
 * @method array viewChannelList()
 * @method LengthAwarePaginator prepareViewChannelPaginate(PaginateData $paginate_dto)
 * @method array viewChannelPaginate(?PaginateData $paginate_dto = null)
 * @method array storeChannel(?ChannelData $channel_dto = null)
 * @method Collection prepareStoreMultipleChannel(array $datas)
 * @method array storeMultipleChannel(array $datas)
 */

interface Channel extends PaymentMethod
{
    public function prepareStoreChannel(ChannelData $channel_dto): Model;
}