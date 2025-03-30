<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModulePayment\Contracts\Data\CoaData;

interface Coa extends DataManagement
{
    public function getCoa(): mixed;
    public function prepareStoreCoa(CoaData $Coa_dto): Model;
    public function storeCoa(?CoaData $Coa_dto = null): array;
    public function prepareShowCoa(?Model $model = null, ?array $attributes = null): Model;
    public function showCoa(?Model $model = null): array;
    public function prepareViewCoaList(?array $attributes = null): Collection;
    public function viewCoaList(): array;
    public function prepareDeleteCoa(?array $attributes = null): bool;
    public function deleteCoa(): bool;
    public function Coa(mixed $conditionals = null): Builder;
    
}
