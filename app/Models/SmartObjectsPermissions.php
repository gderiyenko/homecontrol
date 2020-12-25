<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartObjectsPermissions extends Model
{
    use HasFactory;

    protected $table = "users_objects";

    protected $fillable = [
        'id',
        'user_id',
        'object_id',
        'owner',
        'deleted_at',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['object', 'user'];

    /**
     * Get objects by user function
     *
     * @param integer $userId
     * @return void
     */
    public static function byUser(int $userId)
    {
        return static::where('user_id', $userId)->get();
    }

    /* Relations */

    public function object()
    {
        return $this->belongsTo(SmartObject::class, 'object_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
