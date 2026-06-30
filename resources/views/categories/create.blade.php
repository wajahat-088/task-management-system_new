<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add New Category</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">

                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-medium mb-1">Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                                class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                            Create Category
                        </button>
                        <a href="{{ route('categories.index') }}"
                           class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>