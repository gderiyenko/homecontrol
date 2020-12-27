<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SmartObjectsPermissions extends Model
{
    use HasFactory, SoftDeletes;

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
    protected $with = [];

    /**
     * Get by user scope function
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param integer $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUser($q, int $userId)
    {
        return $q->where('user_id', $userId);
    }

    /**
     * Get by object scope function
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param integer $objectId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByObject($q, int $objectId)
    {
        return $q->where('object_id', $objectId);
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
