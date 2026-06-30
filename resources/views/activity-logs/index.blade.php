<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Activity Logs</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filter --}}
            <div class="bg-white rounded-lg shadow p-4 mb-6">
                <form method="GET" action="{{ route('activity-logs.index') }}" class="flex flex-wrap gap-3">
                    <select name="action" class="border rounded px-8 py-2">
                        <option value="">All Actions</option>
                        <option value="created"        {{ request('action') == 'created'        ? 'selected' : '' }}>Created</option>
                        <option value="updated"        {{ request('action') == 'updated'        ? 'selected' : '' }}>Updated</option>
                        <option value="deleted"        {{ request('action') == 'deleted'        ? 'selected' : '' }}>Deleted</option>
                        <option value="status_changed" {{ request('action') == 'status_changed' ? 'selected' : '' }}>Status Changed</option>
                    </select>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Filter
                    </button>
                    <a href="{{ route('activity-logs.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                        Reset
                    </a>
                </form>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3 text-left">User</th>
                            <th class="px-6 py-3 text-left">Module</th>
                            <th class="px-6 py-3 text-left">Action</th>
                            <th class="px-6 py-3 text-left">Description</th>
                            <th class="px-6 py-3 text-left">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($logs as $log)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium">{{ $log->user->name ?? 'Unknown' }}</td>

                            {{-- class_basename "App\Models\Task" ko sirf "Task" bana deta hai --}}
                            <td class="px-6 py-4">{{ class_basename($log->loggable_type) }}</td>

                            <td class="px-6 py-4">
                                @if($log->action == 'created')
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Created</span>
                                @elseif($log->action == 'updated')
                                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">Updated</span>
                                @elseif($log->action == 'deleted')
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Deleted</span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">Status Changed</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-gray-600">{{ $log->description }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $log->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                No activity yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                @if($logs->hasPages())
                <div class="px-6 py-4 border-t">
                    {{ $logs->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>