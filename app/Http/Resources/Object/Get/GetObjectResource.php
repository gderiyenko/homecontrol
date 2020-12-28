<?php

namespace App\Http\Resources\Object\Get;

use Illuminate\Http\Resources\Json\JsonResource;

class GetObjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $connection = $this->object->username .
            '@' . $this->object->ip .
            ':' . $this->object->port .
            ' -p' . $this->object->keypass;

        $details = $this->owner
            ? $connection
            : 'Provided by ' . $this->user->name;

        return [
            'id' => $this->object->id,
            'name' => $this->object->name,
            'details' => $details,
            'ip' => $this->object->ip,
            'port' => $this->object->port,
            'username' => $this->object->username,
            'keypass' => $this->object->keypass,
        ];
    }
}
