<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">Manage Users</h2>
    </x-slot>

    <div class="page-content">
        <div class="page-container">

            <div class="table-card">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Current Role</th>
                            <th>Change Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td style="color: var(--color-text-muted);">{{ $user->email }}</td>

                            {{-- Current role — id diya taake AJAX se text update kar sakein --}}
                            <td id="current-role-{{ $user->id }}">
                                <span class="role-badge">
                                    {{ $user->getRoleNames()->first() ?? '—' }}
                                </span>
                            </td>

                            <td>
                                @php
                                    $currentRole = $user->getRoleNames()->first();
                                    $roleModifier = match($currentRole) {
                                        'admin'   => 'status-select--completed',
                                        'manager' => 'status-select--progress',
                                        default   => 'status-select--pending',
                                    };
                                @endphp
                                <select
                                    class="status-select role-select {{ $roleModifier }}"
                                    data-user-id="{{ $user->id }}"
                                    data-url="{{ route('users.updateRole', $user) }}">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}"
                                            @selected($user->hasRole($role->name))>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="empty-row">
                                No users found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                @if($users->hasPages())
                <div class="table-footer">
                    {{ $users->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>

    {{-- Toast --}}
    <div id="toast" class="toast"></div>

    <script>
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.className = 'toast toast--show ' + (type === 'success' ? 'toast--success' : 'toast--error');
            setTimeout(() => {
                toast.classList.remove('toast--show');
            }, 3000);
        }

        document.querySelectorAll('.role-select').forEach(select => {
            select.addEventListener('change', function () {
                const url    = this.dataset.url;
                const userId = this.dataset.userId;

                fetch(url, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ role: this.value }),
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // "Current Role" column ka badge turant update kar dein
                        const roleCell = document.getElementById(`current-role-${userId}`);
                        roleCell.innerHTML = `<span class="role-badge">${data.role}</span>`;

                        showToast(data.message, 'success');
                    } else {
                        showToast('Failed to update role.', 'error');
                    }
                })
                .catch(() => showToast('Something went wrong.', 'error'));
            });
        });
    </script>
</x-app-layout>