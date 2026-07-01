<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Categories</h2>

            {{-- Only visible to users with create-category permission --}}
            @can('create-category')
                <a href="{{ route('categories.create') }}"
                   class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    + Add Category
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Categories Table --}}
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3 text-left">Name</th>
                            <th class="px-6 py-3 text-left">Products Count</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($categories as $category)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium">{{ $category->name }}</td>

                            {{-- Number of products linked to this category --}}
                            <td class="px-6 py-4">{{ $category->products_count }}</td>

                            {{-- Action buttons — shown based on user permissions --}}
                            <td class="px-6 py-4">
                                <div class="flex gap-2">

                                    {{-- Edit button: visible to users with edit-category permission --}}
                                    @can('edit-category')
                                        <a href="{{ route('categories.edit', $category) }}"
                                           class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600">
                                            Edit
                                        </a>
                                    @endcan

                                    {{-- Delete button: visible to users with delete-category permission --}}
                                    @can('delete-category')
                                        <form method="POST"
                                              action="{{ route('categories.destroy', $category) }}"
                                              onsubmit="return confirm('Delete this category?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600">
                                                Delete
                                            </button>
                                        </form>
                                    @endcan

                                    {{-- Show dash if user has neither edit nor delete permission --}}
                                    @cannot('edit-category')
                                        @cannot('delete-category')
                                            <span class="text-gray-400 text-xs">—</span>
                                        @endcannot
                                    @endcannot

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-400">
                                No categories found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination links --}}
                @if($categories->hasPages())
                <div class="px-6 py-4 border-t">
                    {{ $categories->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>