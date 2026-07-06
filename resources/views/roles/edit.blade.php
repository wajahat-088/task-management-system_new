<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">
            Edit Permissions
            <span class="role-badge" style="margin-left: 8px; vertical-align: middle;">
                {{ $role->name }}
            </span>
        </h2>
    </x-slot>

    <div class="form-page">
        <div class="form-container" style="max-width: 800px;">
            <div class="form-card">

                <form method="POST" action="{{ route('roles.update', $role) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group form-group--last">
                        <label class="form-label">Assign Permissions</label>

                        <div class="permissions-grid">
                            @foreach($allPermissions as $permission)
                                <label class="permission-item">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                        @checked($role->permissions->contains('name', $permission->name))>
                                    <span>{{ str_replace('-', ' ', $permission->name) }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn--primary">
                            Save Permissions
                        </button>
                        <a href="{{ route('roles.index') }}" class="btn btn--secondary">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>