<?php

namespace App\Services;

use App\Models\Command;
use App\Models\SmartObjectsPermissions;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CommandsService
{
    /**
     * Get all commands by user_id.
     *
     * @param  integer  $userId
     * @return \Illuminate\Http\Response
     */
    public function getCommandsByUser(int $userId): Collection
    {
        $result = Command::whereIn(
            'object_id',
            SmartObjectsPermissions::byUser($userId)->get()->pluck('object_id')
        )->get();
        return $result;
    }

    /**
     * Run command on related computer function
     *
     * @param Command $command
     * @param integer $userId
     * @return void
     */
    public function runOnComputer(Command $command, int $userId)
    {
        //
    }

    /**
     * Add command to database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addOne(Request $request): Command
    {
        return Command::create([
            'name' => $request->name,
            'content' => $request->content,
            'description' => $request->description,
            'input' => $request->input,
            'object_id' => $request->object_id,
        ]);
    }

    /**
     * Update the command in database.
     *
     * @param Request $request
     * @param Command $command
     * @return Command
     */
    public function updateOne(Request $request, Command $command): Command
    {
        $command->update([
            'name' => $request->name,
            'ip' => $request->ip,
            'port' => $request->port,
            'username' => $request->username,
            'keypass' => $request->keypass,
        ]);
        return $command->fresh();
    }

    /**
     * Remove the command from database.
     *
     * @param  \App\Models\Command  $command
     * @return \Illuminate\Http\Response
     */
    public function removeOne(Command $command): Command
    {
        $command->delete();
        return $command->fresh();
    }
}
