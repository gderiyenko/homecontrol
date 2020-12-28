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
            'id' => $this->id,
            'name' => $this->name,
            'content' => $this->content,
            'description' => $this->description,
            'input' => $this->input,
            'object' => $this->object,
        ];
    }
}
