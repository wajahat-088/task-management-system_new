<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Permissions — {{ ucfirst($role->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">
                <form method="POST" action="{{ route('roles.update', $role) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-2 gap-3">
                        @foreach($allPermissions as $permission)
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                    @checked($role->permissions->contains('name', $permission->name))>
                                <span class="text-sm">{{ $permission->name }}</span>
                            </label>
                        @endforeach
                    </div>

                    <button type="submit"
                            class="mt-6 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Save Permissions
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>