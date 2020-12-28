<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory;

    protected $table = "commands";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    /* Relations */

    /**
     * Get the object that owns command.
     */
    public function object()
    {
        return $this->belongsTo(SmartObject::class, 'object_id');
    } 
}
