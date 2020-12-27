<?php

namespace App\Http\Resources\Object\Get;

use Illuminate\Http\Resources\Json\JsonResource;

class GetObjectsListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $result = [];
        foreach ($this->resource as $id => $item) {
            $result[$id] = new GetObjectResource($item);
        }
        return $result;
    }
}
