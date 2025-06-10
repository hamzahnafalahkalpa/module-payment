<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModulePayment\Contracts\Schemas\Refund as ContractsRefund;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Hanafalah\ModulePayment\Resources\Refund\ShowRefund;
use Hanafalah\ModulePayment\Resources\Refund\ViewRefund;

class Refund extends PackageManagement implements ContractsRefund
{
    protected string $__entity = 'Refund';
    public static $refund_model;

    public function prepareViewRefundPaginate(mixed $cache_reference_type = null, ?array $morphs = null, int $perPage = 50, array $columns = ['*'], string $pageName = 'page', ?int $page = null, ?int $total = null): LengthAwarePaginator{
        $morphs ??= $cache_reference_type;
        $paginate_options = compact('perPage', 'columns', 'pageName', 'page', 'total');
        $cache_reference_type ??= 'all';
        $cache_reference_type .= '-paginate';
        // $this->localAddSuffixCache($cache_reference_type);
        return $this->getRefundBuilder()
            ->when(isset(request()->search_value) && request()->search_value, function ($q) {
                $q->whereHas('transaction', function ($q) {
                    $q->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(props, '$.\"prop_patient\".\"name\"')) LIKE ?", ['%' . request()->search_value . '%']);
                });
            })
            ->paginate(...$this->arrayValues($paginate_options))
            ->appends(request()->all());
    }

    public function getRefundBuilder()
    {
        return $this->refund(function ($query) {
            $query->with([
                'author',
                'transaction' => function ($query) {
                    $query->with([
                        'patient',
                    ]);
                },
                'refundItems.item' => function ($query) {
                    $query->with([
                        'payer',
                    ]);
                }
            ]);
        });
    }

    public function viewRefundPaginate(mixed $cache_reference_type = null, ?array $morphs = null, int $perPage = 10, array $columns = ['*'], string $pageName = 'page', ?int $page = null, ?int $total = null): array
    {
        $paginate_options = compact('perPage', 'columns', 'pageName', 'page', 'total');
        return $this->transforming($this->__resources['view'], function () use ($cache_reference_type, $morphs, $paginate_options) {
            return $this->prepareViewRefundPaginate($cache_reference_type, $morphs, ...$this->arrayValues($paginate_options));
        });
    }

    protected function showUsingRelation(): array
    {
        return [
            'author',
            'transaction' => function ($query) {
                $query->with([
                    'patient',
                ]);
            },
            'refundItems.item' => function ($query) {
                $query->with([
                    'payer',
                ]);
            }
        ];
    }

    public function prepareShowRefund(?Model $model = null): ?Model
    {
        $this->booting();

        $model ??= $this->getRefund();
        if (!isset($model)) {
            $model = $this->refund()->with($this->showUsingRelation())->find(request()->id);
        } else {
            $model->load($this->showUsingRelation());
        }

        return static::$refund_model = $model;
    }

    public function showRefund(?Model $model = null): array
    {
        return $this->transforming($this->__resources['show'], $this->prepareShowRefund($model));
    }

    // public function storeRefund(){
    //     // Implement store refund;
    // }

    public function refund(mixed $conditionals = null): Builder
    {
        return $this->RefundModel()->withParameters()->conditionals($conditionals)->orderBy('created_at', 'desc');
    }

    public function get(mixed $conditionals = null): Collection
    {
        return $this->refund($conditionals)->get();
    }

    public function getRefund(): mixed
    {
        return static::$refund_model;
    }
}
