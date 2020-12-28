<?php

namespace App\Http\Resources\Command\Get;

use Illuminate\Http\Resources\Json\JsonResource;

class GetCommandResource extends JsonResource
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
