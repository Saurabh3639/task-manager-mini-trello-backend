<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Board;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use App\Helpers\ApiResponse;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        $tasks = Task::where('column_id', $request->column_id)
                ->orderBy('position')
                ->get();

        return TaskResource::collection($tasks);
    }

    public function store(StoreTaskRequest $request)
    {
        $board = Board::findOrFail($request->board_id);
        $this->authorize('create', [Task::class, $board]);

        $task = $this->taskService->createTask($request->validated());

        return new TaskResource($task);
    }

    public function update(UpdateTaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);

        $this->authorize('update', $task);

        $task = $this->taskService->updateTask($task, $request->validated());

        return ApiResponse::success(new TaskResource($task), 'Task updated');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        $this->authorize('delete', $task);

        $this->taskService->deleteTask($task);

        return response()->json([
            "message" => "Task deleted"
        ]);
    }
}
