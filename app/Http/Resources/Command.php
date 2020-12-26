<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Command extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'object_id' => $this->object->id,
            'object_name' => $this->object->name,
            'commands' => $this->object->commands,
        ];
    }
}
