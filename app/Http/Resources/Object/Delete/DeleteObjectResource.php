<?php

namespace App\Http\Resources\Object\Delete;

use Illuminate\Http\Resources\Json\JsonResource;

class DeleteObjectResource extends JsonResource
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
            'object' => [
                'id' => $this->id,
                'name' => $this->name,
                'details' => $this->username.'@'.$this->ip.':'.$this->port.' -p'.$this->keypass,
                'ip' => $this->ip,
                'port' => $this->port,
                'username' => $this->username,
                'keypass' => $this->keypass,
            ]
        ];
    }
}
