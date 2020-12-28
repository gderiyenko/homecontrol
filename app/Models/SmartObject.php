<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SmartObject extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "objects";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'ip',
        'port',
        'username',
        'keypass',
        'deleted_at',
    ];

    protected $with = [
        'commands',
    ];

    /* Relations */

    /**
     * Get the permissions for the smart object.
     */
    public function permissions()
    {
        return $this->hasMany(SmartObjectsPermissions::class);
    }

    public function commands()
    {
        return $this->hasMany(Command::class, 'object_id');
    }
}
