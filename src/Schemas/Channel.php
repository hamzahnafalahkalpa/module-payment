<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\Contracts\Schemas\Channel as ContractsChannel;
use Hanafalah\ModulePayment\Contracts\Data\ChannelData;

class Channel extends PaymentMethod implements ContractsChannel
{
    protected string $__entity = 'Channel';
    public $channel_model;
    protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'channel',
            'tags'     => ['channel', 'channel-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreChannel(ChannelData $channel_dto): Model{
        $channel = $this->prepareStorePaymentMethod($channel_dto);
        return $this->channel_model = $channel;
    }

    public function channel(mixed $conditionals = null){
        return $this->paymentMethod($conditionals);
    }
}