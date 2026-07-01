<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Product;
use App\Http\Requests\TaskRequest;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;




class TaskController extends Controller implements HasMiddleware
{

    /**
     * constructor to apply middleware for permissions
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
     * Display the dashboard with task statistics.
     */
    public function dashboard()
    {
        $stats_tasks = [
            'total'       => Task::count(),
            'pending'     => Task::where('status', 'pending')->count(),
            'in_progress' => Task::where('status', 'in_progress')->count(),
            'completed'   => Task::where('status', 'completed')->count(),
        ];
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
 */
public function index(Request $request)
{
    $query = Task::with('creator');

    if ($request->filled('search')) {
        $query->search($request->search);
    }

    if ($request->filled('status')) {
        $query->filterStatus($request->status);
    }

    if ($request->filled('priority')) {
        $query->filterPriority($request->priority);
    }

    // Only allow sorting on these specific columns (prevents arbitrary column injection)
    $sortColumn = in_array($request->sort, ['title', 'priority', 'status', 'due_date', 'created_at'])
        ? $request->sort
        : 'created_at';

    $sortDirection = $request->direction === 'asc' ? 'asc' : 'desc';

    $query->orderBy($sortColumn, $sortDirection);

    $tasks = $query->paginate(10)->withQueryString();

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
     * Store a newly created task in the database.
     * Supports both standard form submission and AJAX requests.
     */
    public function store(TaskRequest $request)
    {
        $task = Task::create([
            ...$request->validated(),
            'created_by' => auth()->id(),
        ]);
       //create an activity log entry for the newly created task
        ActivityLog::record($task, 'created', "created task '{$task->title}'");

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Task created successfully!',
                'redirect' => route('tasks.index'),
            ]);
        }

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully!');
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified task in the database.
     */
    public function update(TaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        //create an activity log entry for the updated task
         ActivityLog::record($task, 'updated', "updated task '{$task->title}'");

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully!');
    }

    /**
     * Remove the specified task from the database.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        //create an activity log entry for the deleted task
        ActivityLog::record($task, 'deleted', "deleted task '{$task->title}'");
        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully!');
    }

    /**
     * Update only the status of a task via AJAX.
     * Route: PATCH /tasks/{task}/status
     */
    public function updateStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $oldStatus = $task->status; // to track prev status for activity log
        $task->update(['status' => $validated['status']]);

        // Activity log entry
        ActivityLog::record($task, 'status_changed',
            "changed status of task '{$task->title}' from {$oldStatus} to {$task->status}");

        return response()->json([
            'success' => true,
            'message' => 'Task status updated successfully!',
            'status'  => $task->status,
        ]);
    }
}