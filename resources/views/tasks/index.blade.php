<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">All Tasks</h2>
            <a href="{{ route('tasks.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                + Add Task
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Search & Filters --}}
            <div class="bg-white rounded-lg shadow p-4 mb-6">
                <form method="GET" action="{{ route('tasks.index') }}"
                      class="flex flex-wrap gap-3">

                    {{-- Search by title --}}
                    <input type="text" name="search" placeholder="Search by title..."
                           value="{{ request('search') }}"
                           class="border rounded px-3 py-2 flex-1 min-w-[200px]">

                    {{-- Status filter --}}
                    <select name="status" class="border rounded px-3 py-2">
                        <option value="">All Status</option>
                        <option value="pending"     {{ request('status') == 'pending'     ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed"   {{ request('status') == 'completed'   ? 'selected' : '' }}>Completed</option>
                    </select>

                    {{-- Priority filter --}}
                    <select name="priority" class="border rounded px-3 py-2">
                        <option value="">All Priority</option>
                        <option value="low"    {{ request('priority') == 'low'    ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high"   {{ request('priority') == 'high'   ? 'selected' : '' }}>High</option>
                    </select>

                    <button type="submit"
                            class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Filter
                    </button>
                    <a href="{{ route('tasks.index') }}"
                       class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                        Reset
                    </a>
                </form>
            </div>

            {{-- Tasks Table --}}
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3 text-left">Title</th>
                            <th class="px-6 py-3 text-left">Priority</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Due Date</th>
                            <th class="px-6 py-3 text-left">Created By</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($tasks as $task)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium">{{ $task->title }}</td>

                            {{-- Priority Badge --}}
                            <td class="px-6 py-4">
                                @if($task->priority == 'high')
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">High</span>
                                @elseif($task->priority == 'medium')
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">Medium</span>
                                @else
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Low</span>
                                @endif
                            </td>

                            {{-- Status — Editable AJAX Dropdown --}}
                            <td class="px-6 py-4">
                                <select
                                    class="status-select text-xs border rounded px-2 py-1 cursor-pointer
                                        @if($task->status == 'completed') bg-green-100 text-green-700
                                        @elseif($task->status == 'in_progress') bg-blue-100 text-blue-700
                                        @else bg-yellow-100 text-yellow-700 @endif"
                                    data-task-id="{{ $task->id }}"
                                    data-url="{{ route('tasks.updateStatus', $task) }}">
                                    <option value="pending"     {{ $task->status == 'pending'     ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed"   {{ $task->status == 'completed'   ? 'selected' : '' }}>Completed</option>
                                </select>
                            </td>

                            <td class="px-6 py-4">{{ $task->due_date }}</td>
                            <td class="px-6 py-4">{{ $task->creator->name }}</td>

                            {{-- Actions --}}
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('tasks.edit', $task) }}"
                                       class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600">
                                        Edit
                                    </a>
                                    <form method="POST"
                                          action="{{ route('tasks.destroy', $task) }}"
                                          onsubmit="return confirm('Delete this task?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                                No tasks found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                @if($tasks->hasPages())
                <div class="px-6 py-4 border-t">
                    {{ $tasks->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>

    {{-- Toast Notification Container --}}
    <div id="toast"
         class="fixed top-5 right-5 hidden px-4 py-3 rounded shadow-lg text-white text-sm z-50">
    </div>

    <script>
        // Show success toast if redirected here with a session flash message
        @if(session('success'))
            document.addEventListener('DOMContentLoaded', () => {
                showToast(@json(session('success')), 'success');
            });
        @endif

        /**
         * Display a toast notification on screen for 3 seconds.
         */
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.className = `fixed top-5 right-5 px-4 py-3 rounded shadow-lg text-white text-sm z-50
                ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
            toast.classList.remove('hidden');

            setTimeout(() => toast.classList.add('hidden'), 3000);
        }

        /**
         * Handle AJAX-based task status update from the dropdown,
         * without requiring a full page reload.
         */
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