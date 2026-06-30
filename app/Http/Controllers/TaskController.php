<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Product;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;




class TaskController extends Controller
{
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

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully!');
    }

    /**
     * Remove the specified task from the database.
     */
    public function destroy(Task $task)
    {
        $task->delete();

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

        $task->update(['status' => $validated['status']]);

        return response()->json([
            'success' => true,
            'message' => 'Task status updated successfully!',
            'status'  => $task->status,
        ]);
    }
}