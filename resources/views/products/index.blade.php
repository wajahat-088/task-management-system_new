<x-app-layout>
    <x-slot name="header">
        <div class="header-row">
            <h2 class="header-title">All Products</h2>

            {{-- Only visible to users with create-product permission --}}
            @can('create-product')
                <a href="{{ route('products.create') }}" class="btn btn--primary">
                    + Add Product
                </a>
            @endcan
        </div>

        {{-- Only visible to users with view-activity-logs permission --}}
        @can('view-activity-logs')
            <div class="header-actions-row">
                <a href="{{ route('activity-logs.index') }}" class="btn btn--primary">
                    View Activity Logs
                </a>
            </div>
        @endcan
    </x-slot>

    <div class="page-content">
        <div class="page-container">

            {{-- Search and Filter Form --}}
            <div class="filter-card">
                <form method="GET" action="{{ route('products.index') }}" class="filter-form">

                    {{-- Search by title --}}
                    <input type="text" name="search" placeholder="Search by title..."
                           value="{{ request('search') }}"
                           class="form-input form-input--grow">

                    {{-- Filter by status --}}
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending"     {{ request('status') == 'pending'     ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed"   {{ request('status') == 'completed'   ? 'selected' : '' }}>Completed</option>
                    </select>

                    {{-- Filter by priority --}}
                    <select name="priority" class="form-select">
                        <option value="">All Priority</option>
                        <option value="low"    {{ request('priority') == 'low'    ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high"   {{ request('priority') == 'high'   ? 'selected' : '' }}>High</option>
                    </select>

                    <button type="submit" class="btn btn--primary">
                        Filter
                    </button>

                    {{-- Reset all filters --}}
                    <a href="{{ route('products.index') }}" class="btn btn--secondary">
                        Reset
                    </a>
                </form>
            </div>

            {{-- Products Table --}}
            <div class="table-card">
                <table class="data-table">
                    <thead>
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
                                <th>
                                    <a href="{{ route('products.index', array_merge(request()->query(), [
                                            'sort'      => $column,
                                            'direction' => ($sortColumn === $column && $sortDirection === 'asc') ? 'desc' : 'asc',
                                        ])) }}"
                                       class="sort-link">
                                        {{ $label }}
                                        {{-- Show sort direction arrow for the active column --}}
                                        @if($sortColumn === $column)
                                            @if($sortDirection === 'asc')
                                                <span>&uarr;</span>
                                            @else
                                                <span>&darr;</span>
                                            @endif
                                        @endif
                                    </a>
                                </th>
                            @endforeach

                            <th>Category</th>
                            <th>Created By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>{{ $product->title }}</td>

                            {{-- Priority badge with color coding --}}
                            <td>
                                @if($product->priority == 'high')
                                    <span class="badge badge--danger">High</span>
                                @elseif($product->priority == 'medium')
                                    <span class="badge badge--warning">Medium</span>
                                @else
                                    <span class="badge badge--success">Low</span>
                                @endif
                            </td>

                            {{-- Status: show editable dropdown for users with edit permission,
                                 otherwise show a read-only colored badge --}}
                            <td>
                                @can('edit-product')
                                    @php
                                        $statusModifier = match($product->status) {
                                            'completed'   => 'status-select--completed',
                                            'in_progress' => 'status-select--progress',
                                            default       => 'status-select--pending',
                                        };
                                    @endphp
                                    <select
                                        class="status-select {{ $statusModifier }}"
                                        data-product-id="{{ $product->id }}"
                                        data-url="{{ route('products.updateStatus', $product) }}">
                                        <option value="pending"     {{ $product->status == 'pending'     ? 'selected' : '' }}>Pending</option>
                                        <option value="in_progress" {{ $product->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed"   {{ $product->status == 'completed'   ? 'selected' : '' }}>Completed</option>
                                    </select>
                                @else
                                    @if($product->status == 'completed')
                                        <span class="badge badge--success">{{ ucfirst(str_replace('_', ' ', $product->status)) }}</span>
                                    @elseif($product->status == 'in_progress')
                                        <span class="badge badge--info">{{ ucfirst(str_replace('_', ' ', $product->status)) }}</span>
                                    @else
                                        <span class="badge badge--warning">{{ ucfirst(str_replace('_', ' ', $product->status)) }}</span>
                                    @endif
                                @endcan
                            </td>

                            <td>{{ $product->due_date }}</td>

                            {{-- Show category name or dash if not assigned --}}
                            <td>{{ $product->category->name ?? '—' }}</td>
                            <td>{{ $product->creator->name }}</td>

                            {{-- Action buttons — shown based on user permissions --}}
                            <td>
                                <div class="row-actions">

                                    {{-- Edit button: visible to users with edit-product permission --}}
                                    @can('edit-product')
                                        <a href="{{ route('products.edit', $product) }}" class="btn-sm btn-sm--edit">
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
                                            <button type="submit" class="btn-sm btn-sm--delete">
                                                Delete
                                            </button>
                                        </form>
                                    @endcan

                                    {{-- Show dash if user has neither edit nor delete permission --}}
                                    @cannot('edit-product')
                                        @cannot('delete-product')
                                            <span class="no-action">&mdash;</span>
                                        @endcannot
                                    @endcannot

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="empty-row">
                                No products found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination links --}}
                @if($products->hasPages())
                <div class="table-footer">
                    {{ $products->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>

    {{-- Toast notification container --}}
    <div id="toast" class="toast"></div>

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
            toast.className = 'toast toast--show ' + (type === 'success' ? 'toast--success' : 'toast--error');
            setTimeout(() => {
                toast.classList.remove('toast--show');
            }, 3000);
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