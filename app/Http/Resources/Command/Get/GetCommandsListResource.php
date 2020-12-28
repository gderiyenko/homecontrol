<?php

namespace App\Http\Resources\Command\Get;

use Illuminate\Http\Resources\Json\JsonResource;

class GetCommandsListResource extends JsonResource
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
            $result[$id] = new GetCommandResource($item);
        }
        return $result;
    }
}
