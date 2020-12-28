<?php

namespace App\Http\Controllers;

use App\Http\Resources\Command\Get\GetCommandsListResource;
use App\Http\Resources\Command\Store\StoreCommandResource;
use App\Http\Resources\Command\Edit\EditCommandResource;
use App\Http\Resources\Command\Delete\DeleteCommandResource;
use App\Http\Resources\FailedActionResource;
use App\Models\Command;
use App\Services\CommandsService;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    /**
     * Services and business logic implementations.
     */
    protected $commandsService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CommandsService $commandsService)
    {
        $this->commandsService = $commandsService;
    }

    /**
     * Show all user's commands.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        try {
            return new GetCommandsListResource(
                $this->commandsService->getCommandsByUser($request->user()->id)
            );
        } catch (\Exception $e) {
            return new GetCommandsListResource([]);
        }
    }

    /**
     * Run $command on related smart-object computer.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function run(Request $request, Command $command)
    {
        try {
            $this->commandsService->runOnComputer(
                $command,
                $request->user()->id,
                $request->input ?? ""
            );
            return [
                'success' => true,
            ];
        } catch (\Exception $e) {
            return new FailedActionResource($e);
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
            return new StoreCommandResource(
                $this->commandsService->addOne($request)
            );
        } catch (\Exception $e) {
            return new FailedActionResource($e);
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
            return new EditCommandResource(
                $this->commandsService->updateOne($request, $command)
            );
        } catch (\Exception $e) {
            return new FailedActionResource($e);
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
            return new DeleteCommandResource(
                $this->commandsService->removeOne($command)
            );
        } catch (\Exception $e) {
            return new FailedActionResource($e);
        }
    }
}
