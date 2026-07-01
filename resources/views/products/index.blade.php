<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">All Products</h2>

            {{-- Only visible to users with create-product permission --}}
            @can('create-product')
                <a href="{{ route('products.create') }}"
                   class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    + Add Product
                </a>
            @endcan
        </div>

        {{-- Only visible to users with view-activity-logs permission --}}
        @can('view-activity-logs')
            <div class="flex justify-end mt-3">
                <a href="{{ route('activity-logs.index') }}"
                   class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    View Activity Logs
                </a>
            </div>
        @endcan
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Search and Filter Form --}}
            <div class="bg-white rounded-lg shadow p-4 mb-6">
                <form method="GET" action="{{ route('products.index') }}"
                      class="flex flex-wrap gap-3">

                    {{-- Search by title --}}
                    <input type="text" name="search" placeholder="Search by title..."
                           value="{{ request('search') }}"
                           class="border rounded px-3 py-2 flex-1 min-w-[200px]">

                    {{-- Filter by status --}}
                    <select name="status" class="border rounded px-8 py-2">
                        <option value="">All Status</option>
                        <option value="pending"     {{ request('status') == 'pending'     ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed"   {{ request('status') == 'completed'   ? 'selected' : '' }}>Completed</option>
                    </select>

                    {{-- Filter by priority --}}
                    <select name="priority" class="border rounded px-8 py-2">
                        <option value="">All Priority</option>
                        <option value="low"    {{ request('priority') == 'low'    ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high"   {{ request('priority') == 'high'   ? 'selected' : '' }}>High</option>
                    </select>

                    <button type="submit"
                            class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Filter
                    </button>

                    {{-- Reset all filters --}}
                    <a href="{{ route('products.index') }}"
                       class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                        Reset
                    </a>
                </form>
            </div>

            {{-- Products Table --}}
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            {{-- Sortable column headers --}}
                            @php
                                $columns = [
                                    'title'    => 'Title',
                                    'priority' => 'Priority',
                                    'status'   => 'Status',
                                    'due_date' => 'Due Date',
                                ];
                            @endphp

                            @foreach($columns as $column => $label)
                                <th class="px-6 py-3 text-left">
                                    <a href="{{ route('products.index', array_merge(request()->query(), [
                                            'sort'      => $column,
                                            'direction' => ($sortColumn === $column && $sortDirection === 'asc') ? 'desc' : 'asc',
                                        ])) }}"
                                       class="flex items-center gap-1 hover:text-gray-900">
                                        {{ $label }}
                                        {{-- Show sort direction arrow for the active column --}}
                                        @if($sortColumn === $column)
                                            @if($sortDirection === 'asc')
                                                <span>↑</span>
                                            @else
                                                <span>↓</span>
                                            @endif
                                        @endif
                                    </a>
                                </th>
                            @endforeach

                            <th class="px-6 py-3 text-left">Category</th>
                            <th class="px-6 py-3 text-left">Created By</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium">{{ $product->title }}</td>

                            {{-- Priority badge with color coding --}}
                            <td class="px-6 py-4">
                                @if($product->priority == 'high')
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">High</span>
                                @elseif($product->priority == 'medium')
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">Medium</span>
                                @else
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Low</span>
                                @endif
                            </td>

                            {{-- Status: show editable dropdown for users with edit permission,
                                 otherwise show a read-only colored badge --}}
                            <td class="px-6 py-4">
                                @can('edit-product')
                                    <select
                                        class="status-select text-xs border rounded px-6 py-1 cursor-pointer
                                            @if($product->status == 'completed') bg-green-100 text-green-700
                                            @elseif($product->status == 'in_progress') bg-blue-100 text-blue-700
                                            @else bg-yellow-100 text-yellow-700 @endif"
                                        data-product-id="{{ $product->id }}"
                                        data-url="{{ route('products.updateStatus', $product) }}">
                                        <option value="pending"     {{ $product->status == 'pending'     ? 'selected' : '' }}>Pending</option>
                                        <option value="in_progress" {{ $product->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed"   {{ $product->status == 'completed'   ? 'selected' : '' }}>Completed</option>
                                    </select>
                                @else
                                    <span class="text-xs px-2 py-1 rounded
                                        @if($product->status == 'completed') bg-green-100 text-green-700
                                        @elseif($product->status == 'in_progress') bg-blue-100 text-blue-700
                                        @else bg-yellow-100 text-yellow-700 @endif">
                                        {{ ucfirst(str_replace('_', ' ', $product->status)) }}
                                    </span>
                                @endcan
                            </td>

                            <td class="px-6 py-4">{{ $product->due_date }}</td>

                            {{-- Show category name or dash if not assigned --}}
                            <td class="px-6 py-4">{{ $product->category->name ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $product->creator->name }}</td>

                            {{-- Action buttons — shown based on user permissions --}}
                            <td class="px-6 py-4">
                                <div class="flex gap-2">

                                    {{-- Edit button: visible to users with edit-product permission --}}
                                    @can('edit-product')
                                        <a href="{{ route('products.edit', $product) }}"
                                           class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600">
                                            Edit
                                        </a>
                                    @endcan

                                    {{-- Delete button: visible to users with delete-product permission --}}
                                    @can('delete-product')
                                        <form method="POST"
                                              action="{{ route('products.destroy', $product) }}"
                                              onsubmit="return confirm('Delete this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600">
                                                Delete
                                            </button>
                                        </form>
                                    @endcan

                                    {{-- Show dash if user has neither edit nor delete permission --}}
                                    @cannot('edit-product')
                                        @cannot('delete-product')
                                            <span class="text-gray-400 text-xs">—</span>
                                        @endcannot
                                    @endcannot

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-400">
                                No products found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination links --}}
                @if($products->hasPages())
                <div class="px-6 py-4 border-t">
                    {{ $products->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>

    {{-- Toast notification container --}}
    <div id="toast"
         class="fixed top-5 right-5 hidden px-4 py-3 rounded shadow-lg text-white text-sm z-50">
    </div>

    <script>
        // Show success toast if redirected with a session flash message
        @if(session('success'))
            document.addEventListener('DOMContentLoaded', () => {
                showToast(@json(session('success')), 'success');
            });
        @endif

        // Display a toast notification for 3 seconds
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.className = `fixed top-5 right-5 px-4 py-3 rounded shadow-lg text-white text-sm z-50
                ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
            toast.classList.remove('hidden');
            setTimeout(() => toast.classList.add('hidden'), 3000);
        }

        // Handle AJAX status update from dropdown without page reload
        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function () {
                fetch(this.dataset.url, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ status: this.value }),
                })
                .then(res => res.json())
                .then(data => {
                    showToast(
                        data.success ? data.message : 'Failed to update status.',
                        data.success ? 'success' : 'error'
                    );
                })
                .catch(() => showToast('Something went wrong.', 'error'));
            });
        });
    </script>
</x-app-layout>