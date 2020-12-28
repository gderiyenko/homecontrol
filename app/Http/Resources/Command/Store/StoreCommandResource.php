<?php

namespace App\Http\Resources\Command\Store;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreCommandResource extends JsonResource
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
            'success' => true,
            'command' => [
                'id' => $this->id,
                'name' => $this->name,
                'content' => $this->content,
                'description' => $this->description,
                'input' => $this->input,
                'object' => [
                    'id' => $this->object->id,
                    'name' => $this->object->name,
                ]
            ]
        ];
    }
}
