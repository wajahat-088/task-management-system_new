<x-app-layout>
    <x-slot name="header">
        <div class="header-row">
            <h2 class="header-title">Categories</h2>

            {{-- Only visible to users with create-category permission --}}
            @can('create-category')
                <a href="{{ route('categories.create') }}" class="btn btn--primary">
                    + Add Category
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="page-content">
        <div class="page-container page-container--narrow">

            {{-- Categories Table --}}
            <div class="table-card">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Products Count</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>

                            {{-- Number of products linked to this category --}}
                            <td>{{ $category->products_count }}</td>

                            {{-- Action buttons — shown based on user permissions --}}
                            <td>
                                <div class="row-actions">

                                    {{-- Edit button: visible to users with edit-category permission --}}
                                    @can('edit-category')
                                        <a href="{{ route('categories.edit', $category) }}" class="btn-sm btn-sm--edit">
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
                                            <button type="submit" class="btn-sm btn-sm--delete">
                                                Delete
                                            </button>
                                        </form>
                                    @endcan

                                    {{-- Show dash if user has neither edit nor delete permission --}}
                                    @cannot('edit-category')
                                        @cannot('delete-category')
                                            <span class="no-action">&mdash;</span>
                                        @endcannot
                                    @endcannot

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="empty-row">
                                No categories found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination links --}}
                @if($categories->hasPages())
                <div class="table-footer">
                    {{ $categories->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>