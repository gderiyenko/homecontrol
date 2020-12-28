<?php

namespace App\Services;

use App\Models\SmartObject;
use App\Models\SmartObjectsPermissions;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ObjectsService
{
    /**
     * Get objects by user function
     *
     * @param integer $userId
     * @return Collection
     */
    public function getObjectsByUser(int $userId): Collection
    {
        return SmartObjectsPermissions::with('object', 'user')->byUser($userId)->get();
    }

    /**
     * Add object to database function
     *
     * @param Request $request
     * @return void
     */
    public function addOne(Request $request): SmartObject
    {
        $newObject = SmartObject::create([
            'name' => $request->name,
            'ip' => $request->ip,
            'port' => $request->port,
            'username' => $request->username,
            'keypass' => $request->keypass,
        ]);
        SmartObjectsPermissions::create([
            'user_id' => $request->user()->id,
            'object_id' => $newObject->id,
            'owner' => true,
        ]);
        return $newObject;
    }

    /**
     * Update object in database function
     *
     * @param Request $request
     * @param SmartObject $object
     * @return SmartObject
     */
    public function updateOne(Request $request, SmartObject $object): SmartObject
    {
        $object->update([
            'name' => $request->name,
            'ip' => $request->ip,
            'port' => $request->port,
            'username' => $request->username,
            'keypass' => $request->keypass,
        ]);
        return $object->fresh();
    }

    /**
     * Remove object from database function
     *
     * @param SmartObject $object
     * @return SmartObject
     */
    public function removeOne(SmartObject $object): SmartObject
    {
        SmartObjectsPermissions::byObject($object->id)->get()->each->delete();
        $object->delete();
        return $object;
    }
}
