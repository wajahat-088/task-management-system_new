<?php

namespace App\Repositories\Interfaces;

use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TaskRepositoryInterface
{
    /**
     * Get paginated, searched, filtered, sorted tasks.
     */
    public function getPaginated(array $filters, string $sortColumn, string $sortDirection, int $perPage = 10): LengthAwarePaginator;

    /**
     * Get task stats (used on dashboard).
     */
    public function getStats(): array;

    /**
     * Find a task by id (or return model instance passed via route model binding).
     */
    public function find(int $id): ?Task;

    /**
     * Create a new task.
     */
    public function create(array $data): Task;

    /**
     * Update an existing task.
     */
    public function update(Task $task, array $data): Task;

    /**
     * Delete a task.
     */
    public function delete(Task $task): bool;

    /**
     * Update only the status of a task.
     */
    public function updateStatus(Task $task, string $status): Task;
}