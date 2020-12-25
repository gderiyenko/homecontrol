<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SmartObject extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $details = $this->owner
            ? $this->object->username.'@'.$this->object->ip.':'.$this->object->port.' -p'.$this->object->keypass
            : 'Provided by '.$this->user->name;
        return [
            'name' => $this->object->name,
            'details' => $details,
            'ip' => $this->object->ip,
            'port' => $this->object->port,
            'username' => $this->object->username,
            'keypass' => $this->object->keypass,
        ];
    }
}
