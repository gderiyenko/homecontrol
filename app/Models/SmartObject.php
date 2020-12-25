<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartObject extends Model
{
    use HasFactory;

    protected $table = "objects";

    protected $fillable = [
        'name',
        'ip',
        'port',
        'username',
        'keypass',
        'deleted_at',
    ];

    /* Relations */

    /**
     * Get the permissions for the smart object.
     */
    public function permissions()
    {
        return $this->hasMany(SmartObjectsPermissions::class);
    }
}
