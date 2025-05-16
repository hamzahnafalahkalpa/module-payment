<?php

namespace Hanafalah\ModulePayment\Resources\Coa;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewCoa extends ApiResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
            'id'             => $this->id,
            'parent_id'      => $this->parent_id,
            'name'           => $this->name,
            'code'           => $this->code,
            'status'         => $this->status,
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at
        ];
        return $arr;
    }
}
