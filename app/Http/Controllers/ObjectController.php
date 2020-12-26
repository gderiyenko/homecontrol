<?php

namespace App\Http\Controllers;

use App\Http\Resources\SmartObjectsList;
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
        return new SmartObjectsList(SmartObjectsPermissions::byUser($request->user()->id));
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
            return [
                'success' => true,
                'object' => [
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
     * Display the specified resource.
     *
     * @param  \App\Models\SmartObject  $object
     * @return \Illuminate\Http\Response
     */
    public function show(SmartObject $object)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SmartObject  $object
     * @return \Illuminate\Http\Response
     */
    public function destroy(SmartObject $object)
    {
        //
    }
}
