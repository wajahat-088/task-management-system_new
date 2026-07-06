<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">Manage Roles</h2>
    </x-slot>

    <div class="page-content">
        <div class="page-container">

            <div class="table-card">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Role</th>
                            <th>Permissions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                        <tr>
                            <td>
                                <span class="role-badge">{{ $role->name }}</span>
                            </td>
                            <td style="color: var(--color-text-muted); max-width: 480px;">
                                {{ $role->permissions->pluck('name')->implode(', ') ?: '—' }}
                            </td>
                            <td>
                                <div class="row-actions">
                                    <a href="{{ route('roles.edit', $role) }}" class="btn-sm btn-sm--edit">
                                        Edit Permissions
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="empty-row">
                                No roles found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>