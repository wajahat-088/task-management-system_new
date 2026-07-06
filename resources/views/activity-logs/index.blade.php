<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">Activity Logs</h2>
    </x-slot>

    <div class="page-content">
        <div class="page-container">

            {{-- Filter --}}
            <div class="filter-card">
                <form method="GET" action="{{ route('activity-logs.index') }}" class="filter-form">
                    <select name="action" class="form-select">
                        <option value="">All Actions</option>
                        <option value="created"        {{ request('action') == 'created'        ? 'selected' : '' }}>Created</option>
                        <option value="updated"        {{ request('action') == 'updated'        ? 'selected' : '' }}>Updated</option>
                        <option value="deleted"        {{ request('action') == 'deleted'        ? 'selected' : '' }}>Deleted</option>
                        <option value="status_changed" {{ request('action') == 'status_changed' ? 'selected' : '' }}>Status Changed</option>
                    </select>
                    <button type="submit" class="btn btn--primary">
                        Filter
                    </button>
                    <a href="{{ route('activity-logs.index') }}" class="btn btn--secondary">
                        Reset
                    </a>
                </form>
            </div>

            <div class="table-card">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Module</th>
                            <th>Action</th>
                            <th>Description</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->user->name ?? 'Unknown' }}</td>

                            {{-- class_basename "App\Models\Task" ko sirf "Task" bana deta hai --}}
                            <td>{{ class_basename($log->loggable_type) }}</td>

                            <td>
                                @if($log->action == 'created')
                                    <span class="badge badge--success">Created</span>
                                @elseif($log->action == 'updated')
                                    <span class="badge badge--info">Updated</span>
                                @elseif($log->action == 'deleted')
                                    <span class="badge badge--danger">Deleted</span>
                                @else
                                    <span class="badge badge--warning">Status Changed</span>
                                @endif
                            </td>

                            <td>{{ $log->description }}</td>
                            <td>{{ $log->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="empty-row">
                                No activity yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                @if($logs->hasPages())
                <div class="table-footer">
                    {{ $logs->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>