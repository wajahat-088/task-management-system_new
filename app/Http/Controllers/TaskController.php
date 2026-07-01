<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Product;
use App\Http\Requests\TaskRequest;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TaskController extends Controller implements HasMiddleware
{
    
    public function __construct(protected TaskRepositoryInterface $taskRepository)
    {
    }

    /**
     * Route-level permission checks.
     * Each middleware entry maps a Spatie permission to the specific
     * controller method(s) it should protect.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('can:view-task',    only: ['index']),
            new Middleware('can:create-task',  only: ['create', 'store']),
            new Middleware('can:edit-task',    only: ['edit', 'update', 'updateStatus']),
            new Middleware('can:delete-task',  only: ['destroy']),
        ];
    }

    /**
     * Show the dashboard with quick stats for tasks and products.
     */
    public function dashboard()
    {
        // Task stats now come from the repository instead of raw Eloquent calls.
        $stats_tasks = $this->taskRepository->getStats();

        // Product stats are still queried directly for now.
        // TODO: move this to a ProductRepository once it's created,
        // to keep the pattern consistent across the app.
        $stats_products = [
            'total'       => Product::count(),
            'pending'     => Product::where('status', 'pending')->count(),
            'in_progress' => Product::where('status', 'in_progress')->count(),
            'completed'   => Product::where('status', 'completed')->count(),
        ];

        return view('dashboard', compact('stats_tasks', 'stats_products'));
    }

    /**
     * Display a paginated, searchable, filterable, and sortable list of tasks.
     * All the actual query building (search, filters, sorting, pagination)
     * happens inside the repository — this method just prepares the request input.
     */
    public function index(Request $request)
    {
        // Whitelist sortable columns to prevent sorting on arbitrary/unsafe columns.
        $sortColumn = in_array($request->sort, ['title', 'priority', 'status', 'due_date', 'created_at'])
            ? $request->sort
            : 'created_at';

        // Default to descending order unless the user explicitly asked for ascending.
        $sortDirection = $request->direction === 'asc' ? 'asc' : 'desc';

        // Pass only the filter-related inputs to the repository.
        $tasks = $this->taskRepository->getPaginated(
            filters: $request->only(['search', 'status', 'priority']),
            sortColumn: $sortColumn,
            sortDirection: $sortDirection,
        );

        return view('tasks.index', compact('tasks', 'sortColumn', 'sortDirection'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created task.
     * Supports both a normal form submission and an AJAX/JSON request.
     */
    public function store(TaskRequest $request)
    {
        // Repository handles creation and the related activity log entry internally,
        // so this method stays focused purely on the HTTP response.
        $task = $this->taskRepository->create($request->validated());

        // Return JSON for AJAX calls, otherwise fall back to a normal redirect.
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success'  => true,
                'message'  => 'Task created successfully!',
                'redirect' => route('tasks.index'),
            ]);
        }

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully!');
    }

    /**
     * Show the form for editing an existing task.
     * $task is resolved automatically via route model binding.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update an existing task with validated data.
     */
    public function update(TaskRequest $request, Task $task)
    {
        // Update logic + activity logging is handled inside the repository.
        $this->taskRepository->update($task, $request->validated());

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully!');
    }

    /**
     * Delete a task.
     */
    public function destroy(Task $task)
    {
        // Deletion + activity logging is handled inside the repository.
        $this->taskRepository->delete($task);

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully!');
    }

    /**
     * Update only the status of a task via an AJAX request.
     * Route: PATCH /tasks/{task}/status
     */
    public function updateStatus(Request $request, Task $task)
    {
        // Only the status field is accepted here — nothing else can be changed
        // through this endpoint.
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        // Repository takes care of updating the status and logging the change
        // (including the old -> new status transition).
        $task = $this->taskRepository->updateStatus($task, $validated['status']);

        return response()->json([
            'success' => true,
            'message' => 'Task status updated successfully!',
            'status'  => $task->status,
        ]);
    }
}