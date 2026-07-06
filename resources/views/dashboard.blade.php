<x-app-layout>
    <x-slot name="header">
        <h2 style="font-weight:600; font-size:20px; color:#1F2937; line-height:1.3;">Dashboard</h2>
    </x-slot>

    <div class="dash-scope">
        <div class="page-container">

            {{-- Page heading + Live status badge (signature element) --}}
            <div class="overview-header">
                <div>
                    <h1 class="page-title">Overview</h1>
                    <p class="page-subtitle">Everything moving through your team, at a glance.</p>
                </div>
                <div class="status-badge">
                    <span class="pulse-dot"></span>
                    <span class="status-badge__label">Live &middot; updated just now</span>
                </div>
            </div>

            {{-- ============ TASKS SECTION ============ --}}
            <h2 class="section-label">Tasks</h2>
            <div class="stats-grid">

                {{-- Total Tasks card --}}
                <div tabindex="0" class="stat-card stat-card--neutral">
                    <div class="stat-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <p class="stat-number">{{ $stats_tasks['total'] }}</p>
                        <p class="stat-label">Total tasks</p>
                    </div>
                </div>

                {{-- Pending card --}}
                <div tabindex="0" class="stat-card stat-card--pending">
                    <div class="stat-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="stat-number">{{ $stats_tasks['pending'] }}</p>
                        <p class="stat-label">Pending</p>
                    </div>
                </div>

                {{-- In Progress card --}}
                <div tabindex="0" class="stat-card stat-card--progress">
                    <div class="stat-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="stat-number">{{ $stats_tasks['in_progress'] }}</p>
                        <p class="stat-label">In progress</p>
                    </div>
                </div>

                {{-- Completed card --}}
                <div tabindex="0" class="stat-card stat-card--completed">
                    <div class="stat-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="stat-number">{{ $stats_tasks['completed'] }}</p>
                        <p class="stat-label">Completed</p>
                    </div>
                </div>
            </div>

            {{-- ============ PRODUCTS SECTION ============ --}}
            <h2 class="section-label">Products</h2>
            <div class="stats-grid">

                <div tabindex="0" class="stat-card stat-card--neutral">
                    <div class="stat-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <p class="stat-number">{{ $stats_products['total'] }}</p>
                        <p class="stat-label">Total products</p>
                    </div>
                </div>

                <div tabindex="0" class="stat-card stat-card--pending">
                    <div class="stat-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="stat-number">{{ $stats_products['pending'] }}</p>
                        <p class="stat-label">Pending</p>
                    </div>
                </div>

                <div tabindex="0" class="stat-card stat-card--progress">
                    <div class="stat-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="stat-number">{{ $stats_products['in_progress'] }}</p>
                        <p class="stat-label">In progress</p>
                    </div>
                </div>

                <div tabindex="0" class="stat-card stat-card--completed">
                    <div class="stat-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="stat-number">{{ $stats_products['completed'] }}</p>
                        <p class="stat-label">Completed</p>
                    </div>
                </div>
            </div>

            {{-- ============ QUICK ACTIONS ============ --}}
            <h2 class="section-label">Quick actions</h2>
            <div class="actions-grid">

                @can('view-task')
                    <a href="{{ route('tasks.index') }}" class="action-tile">
                        <span class="action-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                        </span>
                        <span class="action-label">All tasks</span>
                    </a>
                @endcan

                @can('create-task')
                    <a href="{{ route('tasks.create') }}" class="action-tile action-tile--primary">
                        <span class="action-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                        </span>
                        <span class="action-label">New task</span>
                    </a>
                @endcan

                @can('view-category')
                    <a href="{{ route('categories.index') }}" class="action-tile">
                        <span class="action-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                        </span>
                        <span class="action-label">Categories</span>
                    </a>
                @endcan

                @can('view-product')
                    <a href="{{ route('products.index') }}" class="action-tile">
                        <span class="action-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                        </span>
                        <span class="action-label">All products</span>
                    </a>
                @endcan

                @can('create-product')
                    <a href="{{ route('products.create') }}" class="action-tile action-tile--primary">
                        <span class="action-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                        </span>
                        <span class="action-label">New product</span>
                    </a>
                @endcan

                @can('view-activity-logs')
                    <a href="{{ route('activity-logs.index') }}" class="action-tile">
                        <span class="action-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 12h6m-6 4h6m-7-8h.01" /></svg>
                        </span>
                        <span class="action-label">Activity log</span>
                    </a>
                @endcan

                <a href="{{ route('profile.edit') }}" class="action-tile">
                    <span class="action-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </span>
                    <span class="action-label">Your profile</span>
                </a>
            </div>

            {{-- ============ ADMINISTRATION (Admin only) ============ --}}
            @can('manage-roles')
                <h2 class="section-label">Administration</h2>
                <div class="admin-grid">
                    <a href="{{ route('roles.index') }}" class="action-tile action-tile--admin">
                        <span class="action-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 10-8 0v2" /></svg>
                        </span>
                        <span class="action-label">Roles and permissions</span>
                    </a>

                    @can('manage-users')
                        <a href="{{ route('users.index') }}" class="action-tile action-tile--admin">
                            <span class="action-icon">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 100-8 4 4 0 000 8zm6 1.13a4 4 0 010 7.75" /></svg>
                            </span>
                            <span class="action-label">Manage users</span>
                        </a>
                    @endcan
                </div>
            @endcan

        </div>
    </div>
</x-app-layout>