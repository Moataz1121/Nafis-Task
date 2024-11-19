<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\AssginRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $task = Task::all();
        return ApiResponse::sendResponse(200, 'Success', TaskResource::collection($task));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        //
        $validated = $request->validated();
        $task = Task::create($validated);
        return ApiResponse::sendResponse(200, 'Success', TaskResource::make($task));
    }

    /**
     * Display the specified resource.
     */
    public function assignUsers(AssginRequest $request, Task $task)
    {
        //
        $validated = $request->validated();
        $task->users()->sync($validated['user_ids']);
        return response()->json(['message' => 'Users assigned successfully', 'task' => $task->load('users')]);
        }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        //
        $validated = $request->validated();
        $task->update($validated);
        return ApiResponse::sendResponse(200, 'Success', TaskResource::make($task));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
        $task->delete();
        return ApiResponse::sendResponse(200, 'Success', TaskResource::make($task));
    }
    
    public function getTasksByUser(User $user)
    {
        $tasks = $user->tasks;
        return ApiResponse::sendResponse(200, 'Success', $tasks);
    }
}
