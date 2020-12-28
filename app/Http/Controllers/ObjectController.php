<?php

namespace App\Http\Controllers;

use App\Http\Resources\FailedActionResource;
use App\Http\Resources\Object\Get\GetObjectsListResource;
use App\Http\Resources\Object\Store\StoreObjectResource;
use App\Http\Resources\Object\Edit\EditObjectResource;
use App\Http\Resources\Object\Delete\DeleteObjectResource;
use App\Models\SmartObject;
use App\Services\ObjectsService;
use Illuminate\Http\Request;

class ObjectController extends Controller
{
    /**
     * Services and business logic implementations.
     */
    protected $objectsService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ObjectsService $objectsService)
    {
        $this->objectsService = $objectsService;
    }

    /**
     * Show all user's smart objects.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        try {
            return new GetObjectsListResource(
                $this->objectsService->getObjectsByUser($request->user()->id)
            );
        } catch (\Exception $e) {
            return new GetObjectsListResource([]);
        }
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
            return new StoreObjectResource(
                $this->objectsService->addOne($request)
            );
        } catch (\Exception $e) {
            return new FailedActionResource($e);
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
            return new EditObjectResource(
                $this->objectsService->updateOne($request, $object)
            );
        } catch (\Exception $e) {
            return new FailedActionResource($e);
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
            return new DeleteObjectResource(
                $this->objectsService->removeOne($object)
            );
        } catch (\Exception $e) {
            return new FailedActionResource($e);
        }
    }
}
