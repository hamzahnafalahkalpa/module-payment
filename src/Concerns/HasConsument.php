<?php

namespace Hanafalah\ModulePayment\Concerns;

use Hanafalah\LaravelSupport\Concerns\Support\HasRequestData;
use Hanafalah\ModulePayment\Contracts\Data\ConsumentData;

trait HasConsument
{
    use HasRequestData;

    public static function bootHasConsument()
    {
        static::created(function ($query) {
            self::generateConsument($query);
        });
        static::updated(function ($query) {
            self::generateConsument($query);
        });
    }

    protected static function generateConsument(&$query): void{
        $consument = app(config('app.contracts.Consument'))->prepareStoreConsument($query->requestDTO(ConsumentData::class,[
            'name' => $query->name,
            'phone' => $query->phone ?? null,
            'reference_id' => $query->getKey(),
            'reference_type' => $query->getMorphClass()
        ]));
        $query->prop_consument = $consument->toViewApi()->resolve();
        static::withoutEvents(function () use ($query) {
            $query->save();
        });
    }

    public function consument(){return $this->morphOneModel('Consument', 'reference');}
}
