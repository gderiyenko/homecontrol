<?php

namespace App\Http\Resources\Object\Edit;

use Illuminate\Http\Resources\Json\JsonResource;

class EditObjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $connection = $this->username .
            '@' . $this->ip .
            ':' . $this->port .
            ' -p' . $this->keypass;

        return [
            'success' => true,
            'object' => [
                'id' => $this->id,
                'name' => $this->name,
                'details' => $connection,
                'ip' => $this->ip,
                'port' => $this->port,
                'username' => $this->username,
                'keypass' => $this->keypass,
            ]
        ];
    }
}
