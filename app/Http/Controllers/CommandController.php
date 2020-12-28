<?php

namespace App\Http\Controllers;

use App\Http\Resources\Command\Delete\DeleteCommandResource;
use App\Http\Resources\Command\Edit\EditCommandResource;
use App\Http\Resources\Command\Get\GetCommandsListResource;
use App\Models\Command;
use App\Models\SmartObjectsPermissions;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    /**
     * Show all user's commands.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        return new GetCommandsListResource(Command::whereIn('object_id', SmartObjectsPermissions::byUser($request->user()->id)->get()->pluck('object_id'))->get());
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
            $newCommand = Command::create([
                'name' => $request->name,
                'content' => $request->content,
                'description' => $request->description,
                'input' => $request->input,
                'object_id' => $request->object_id,
            ]);
            return [
                'success' => true,
                'command' => [
                    'id' => $newCommand->id,
                    'name' => $newCommand->name,
                    'content' => $newCommand->content,
                    'description' => $newCommand->description,
                    'input' => $newCommand->input,
                    'object' => [
                        'id' => $newCommand->object->id,
                        'name' => $newCommand->object->name,
                    ]
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
     * @param  \App\Models\Command  $command
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Command $command)
    {
        try {
            $command->update([
                'name' => $request->name,
                'ip' => $request->ip,
                'port' => $request->port,
                'username' => $request->username,
                'keypass' => $request->keypass,
            ]);
            $command->fresh();
            return new EditCommandResource($command);
        } catch (\Exception $e) {
            return [
                'success' => false,
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Command  $command
     * @return \Illuminate\Http\Response
     */
    public function destroy(Command $command)
    {
        try {
            $command->delete();
            return new DeleteCommandResource($command);
        } catch (\Exception $e) {
            return [
                'success' => false,
            ];
        }
    }
}
