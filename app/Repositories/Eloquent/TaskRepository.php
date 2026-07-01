<?php

namespace App\Repositories\Eloquent;

use App\Models\ActivityLog;
use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TaskRepository implements TaskRepositoryInterface
{
    public function __construct(protected Task $model)
    {
    }

    public function getPaginated(array $filters, string $sortColumn, string $sortDirection, int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->with('creator');

        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        if (!empty($filters['status'])) {
            $query->filterStatus($filters['status']);
        }

        if (!empty($filters['priority'])) {
            $query->filterPriority($filters['priority']);
        }

        $query->orderBy($sortColumn, $sortDirection);

        return $query->paginate($perPage)->withQueryString();
    }

    public function getStats(): array
    {
        return [
            'total'       => $this->model->count(),
            'pending'     => $this->model->where('status', 'pending')->count(),
            'in_progress' => $this->model->where('status', 'in_progress')->count(),
            'completed'   => $this->model->where('status', 'completed')->count(),
        ];
    }

    public function find(int $id): ?Task
    {
        return $this->model->find($id);
    }

    public function create(array $data): Task
    {
        
        $task = $this->model->create([
            ...$data,
            'created_by' => auth()->id(),
        ]);

        ActivityLog::record($task, 'created', "created task '{$task->title}'");

        return $task;
    }

    public function update(Task $task, array $data): Task
    {
        $task->update($data);

        ActivityLog::record($task, 'updated', "updated task '{$task->title}'");

        return $task;
    }

    public function delete(Task $task): bool
    {
        $title = $task->title;
        $deleted = $task->delete();

        ActivityLog::record($task, 'deleted', "deleted task '{$title}'");

        return $deleted;
    }

    public function updateStatus(Task $task, string $status): Task
    {
        $oldStatus = $task->status;
        $task->update(['status' => $status]);

        ActivityLog::record(
            $task,
            'status_changed',
            "changed status of task '{$task->title}' from {$oldStatus} to {$task->status}"
        );

        return $task;
    }
}