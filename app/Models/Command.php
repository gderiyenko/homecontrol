<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Command extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "commands";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'content',
        'description',
        'input',
        'object_id',
        'deleted_at',
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
