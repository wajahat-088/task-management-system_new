<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Http\Request;

class TaskApiController extends Controller
{
    // Wahi interface jo web TaskController use kar raha hai
    public function __construct(protected TaskRepositoryInterface $taskRepository)
    {
    }

    /**
     * GET /api/tasks
     */
    public function index(Request $request)
    {
        $sortColumn = in_array($request->sort, ['title', 'priority', 'status', 'due_date', 'created_at'])
            ? $request->sort
            : 'created_at';

        $sortDirection = $request->direction === 'asc' ? 'asc' : 'desc';

        $tasks = $this->taskRepository->getPaginated(
            filters: $request->only(['search', 'status', 'priority']),
            sortColumn: $sortColumn,
            sortDirection: $sortDirection,
        );

        return TaskResource::collection($tasks);
    }

    /**
     * GET /api/tasks/{task}
     */
    public function show(Task $task)
    {
        return new TaskResource($task->load('creator'));
    }

    /**
     * POST /api/tasks
     */
    public function store(TaskRequest $request)
    {
        $task = $this->taskRepository->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Task created successfully!',
            'data'    => new TaskResource($task),
        ], 201);
    }

    /**
     * PUT/PATCH /api/tasks/{task}
     */
    public function update(TaskRequest $request, Task $task)
    {
        $task = $this->taskRepository->update($task, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully!',
            'data'    => new TaskResource($task),
        ]);
    }

    /**
     * DELETE /api/tasks/{task}
     */
    public function destroy(Task $task)
    {
        $this->taskRepository->delete($task);

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully!',
        ]);
    }
}