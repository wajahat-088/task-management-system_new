<x-app-layout>
    <x-slot name="header">
        <div class="header-row">
            <h2 class="header-title">All Tasks</h2>

            {{-- only show to users with create-task permission --}}
            @can('create-task')
                <a href="{{ route('tasks.create') }}" class="btn btn--primary">
                    + Add Task
                </a>
            @endcan
        </div>

        {{-- only show to users with view-activity-logs permission --}}
        @can('view-activity-logs')
            <div class="header-actions-row">
                <a href="{{ route('activity-logs.index') }}" class="btn btn--primary">
                    View Activity Logs
                </a>
            </div>
        @endcan
    </x-slot>

    <div class="page-content">
        <div class="page-container">

            {{-- Search & Filters --}}
            <div class="filter-card">
                <form method="GET" action="{{ route('tasks.index') }}" class="filter-form">

                    <input type="text" name="search" placeholder="Search by title..."
                           value="{{ request('search') }}"
                           class="form-input form-input--grow">

                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending"     {{ request('status') == 'pending'     ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed"   {{ request('status') == 'completed'   ? 'selected' : '' }}>Completed</option>
                    </select>

                    <select name="priority" class="form-select">
                        <option value="">All Priority</option>
                        <option value="low"    {{ request('priority') == 'low'    ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high"   {{ request('priority') == 'high'   ? 'selected' : '' }}>High</option>
                    </select>

                    <button type="submit" class="btn btn--primary">
                        Filter
                    </button>
                    <a href="{{ route('tasks.index') }}" class="btn btn--secondary">
                        Reset
                    </a>
                </form>
            </div>

            {{-- Tasks Table --}}
            <div class="table-card">
                <table class="data-table">
                    <thead>
                        <tr>
                            @php
                                $columns = [
                                    'title'    => 'Title',
                                    'priority' => 'Priority',
                                    'status'   => 'Status',
                                    'due_date' => 'Due Date',
                                ];
                            @endphp

                            @foreach($columns as $column => $label)
                                <th>
                                    <a href="{{ route('tasks.index', array_merge(request()->query(), [
                                            'sort'      => $column,
                                            'direction' => ($sortColumn === $column && $sortDirection === 'asc') ? 'desc' : 'asc',
                                        ])) }}"
                                       class="sort-link">
                                        {{ $label }}
                                        @if($sortColumn === $column)
                                            @if($sortDirection === 'asc')
                                                <span>&uarr;</span>
                                            @else
                                                <span>&darr;</span>
                                            @endif
                                        @endif
                                    </a>
                                </th>
                            @endforeach

                            <th>Created By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                        <tr>
                            <td>{{ $task->title }}</td>

                            {{-- Priority Badge --}}
                            <td>
                                @if($task->priority == 'high')
                                    <span class="badge badge--danger">High</span>
                                @elseif($task->priority == 'medium')
                                    <span class="badge badge--warning">Medium</span>
                                @else
                                    <span class="badge badge--success">Low</span>
                                @endif
                            </td>

                            {{-- Status — if have edit permission then show dropdown for ajax request. --}}
                            <td>
                                @can('edit-task')
                                    @php
                                        $statusModifier = match($task->status) {
                                            'completed'   => 'status-select--completed',
                                            'in_progress' => 'status-select--progress',
                                            default       => 'status-select--pending',
                                        };
                                    @endphp
                                    <select
                                        class="status-select {{ $statusModifier }}"
                                        data-task-id="{{ $task->id }}"
                                        data-url="{{ route('tasks.updateStatus', $task) }}">
                                        <option value="pending"     {{ $task->status == 'pending'     ? 'selected' : '' }}>Pending</option>
                                        <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed"   {{ $task->status == 'completed'   ? 'selected' : '' }}>Completed</option>
                                    </select>
                                @else
                                    {{-- User role — sirf status text dikhe, dropdown nahi --}}
                                    @if($task->status == 'completed')
                                        <span class="badge badge--success">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span>
                                    @elseif($task->status == 'in_progress')
                                        <span class="badge badge--info">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span>
                                    @else
                                        <span class="badge badge--warning">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span>
                                    @endif
                                @endcan
                            </td>

                            <td>{{ $task->due_date }}</td>
                            <td>{{ $task->creator->name }}</td>

                            {{-- Actions --}}
                            <td>
                                <div class="row-actions">

                                    {{-- if have edit permission --}}
                                    @can('edit-task')
                                        <a href="{{ route('tasks.edit', $task) }}" class="btn-sm btn-sm--edit">
                                            Edit
                                        </a>
                                    @endcan

                                    {{-- if have delete permission show only delete button --}}
                                    @can('delete-task')
                                        <form method="POST"
                                              action="{{ route('tasks.destroy', $task) }}"
                                              onsubmit="return confirm('Delete this task?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-sm btn-sm--delete">
                                                Delete
                                            </button>
                                        </form>
                                    @endcan

                                    {{-- if no permission found show --}}
                                    @cannot('edit-task')
                                        @cannot('delete-task')
                                            <span class="no-action">&mdash;</span>
                                        @endcannot
                                    @endcannot

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="empty-row">
                                No tasks found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                @if($tasks->hasPages())
                <div class="table-footer">
                    {{ $tasks->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>

    {{-- Toast --}}
    <div id="toast" class="toast"></div>

    <script>
        @if(session('success'))
            document.addEventListener('DOMContentLoaded', () => {
                showToast(@json(session('success')), 'success');
            });
        @endif

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.className = 'toast toast--show ' + (type === 'success' ? 'toast--success' : 'toast--error');
            setTimeout(() => {
                toast.classList.remove('toast--show');
            }, 3000);
        }

        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function () {
                const url = this.dataset.url;
                fetch(url, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ status: this.value }),
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showToast(data.message, 'success');
                    } else {
                        showToast('Failed to update status.', 'error');
                    }
                })
                .catch(() => showToast('Something went wrong.', 'error'));
            });
        });
    </script>
</x-app-layout>