<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Users</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3 text-left">Name</th>
                            <th class="px-6 py-3 text-left">Email</th>
                            <th class="px-6 py-3 text-left">Current Role</th>
                            <th class="px-6 py-3 text-left">Change Role</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($users as $user)
                        <tr>
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>

                            {{-- Current role — id diya taake AJAX se text update kar sakein --}}
                            <td class="px-6 py-4 capitalize" id="current-role-{{ $user->id }}">
                                {{ $user->getRoleNames()->first() ?? '—' }}
                            </td>

                            <td class="px-6 py-4">
                                {{-- Ab koi <form> nahi — status-select jaisa direct AJAX dropdown --}}
                                <select
                                    class="role-select border rounded px-6 py-1 text-xs"
                                    data-user-id="{{ $user->id }}"
                                    data-url="{{ route('users.updateRole', $user) }}">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}"
                                            @selected($user->hasRole($role->name))>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($users->hasPages())
                <div class="px-6 py-4 border-t">
                    {{ $users->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
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
                        // "Current Role" column ka text bhi turant update kar dein
                        const roleCell = document.getElementById(`current-role-${userId}`);
                        roleCell.textContent = data.role;

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