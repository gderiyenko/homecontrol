<?php

namespace App\Http\Controllers;

use App\Http\Resources\Object\Delete\DeleteObjectResource;
use App\Http\Resources\Object\Edit\EditObjectResource;
use App\Http\Resources\Object\Get\GetObjectsListResource;
use App\Models\SmartObject;
use App\Models\SmartObjectsPermissions;
use Illuminate\Http\Request;

class ObjectController extends Controller
{
    /**
     * Show all user's smart objects.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        return new GetObjectsListResource(SmartObjectsPermissions::with('object', 'user')->byUser($request->user()->id)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
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
            return [
                'success' => true,
                'object' => [
                    'id' => $newObject->id,
                    'name' => $newObject->name,
                    'details' => $newObject->username.'@'.$newObject->ip.':'.$newObject->port.' -p'.$newObject->keypass,
                    'ip' => $newObject->ip,
                    'port' => $newObject->port,
                    'username' => $newObject->username,
                    'keypass' => $newObject->keypass,
                ]
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
            ];
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SmartObject  $object
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SmartObject $object)
    {
        try {
            $object->update([
                'name' => $request->name,
                'ip' => $request->ip,
                'port' => $request->port,
                'username' => $request->username,
                'keypass' => $request->keypass,
            ]);
            $object->fresh();
            return new EditObjectResource($object);
        } catch (\Exception $e) {
            return [
                'success' => false,
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SmartObject  $object
     * @return \Illuminate\Http\Response
     */
    public function destroy(SmartObject $object)
    {
        try {
            SmartObjectsPermissions::byObject($object->id)->get()->each->delete();
            $object->delete();
            return new DeleteObjectResource($object);
        } catch (\Exception $e) {
            return [
                'success' => false,
            ];
        }
    }
}
