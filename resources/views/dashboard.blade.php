<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Task statistics cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-gray-500 text-sm">Total Tasks</p>
                    <p class="text-4xl font-bold text-gray-800 mt-2">{{ $stats_tasks['total'] }}</p>
                </div>
                <div class="bg-yellow-50 rounded-lg shadow p-6 text-center">
                    <p class="text-yellow-600 text-sm">Pending</p>
                    <p class="text-4xl font-bold text-yellow-700 mt-2">{{ $stats_tasks['pending'] }}</p>
                </div>
                <div class="bg-blue-50 rounded-lg shadow p-6 text-center">
                    <p class="text-blue-600 text-sm">In Progress</p>
                    <p class="text-4xl font-bold text-blue-700 mt-2">{{ $stats_tasks['in_progress'] }}</p>
                </div>
                <div class="bg-green-50 rounded-lg shadow p-6 text-center">
                    <p class="text-green-600 text-sm">Completed</p>
                    <p class="text-4xl font-bold text-green-700 mt-2">{{ $stats_tasks['completed'] }}</p>
                </div>
            </div>

            {{-- Product statistics cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-gray-500 text-sm">Total Products</p>
                    <p class="text-4xl font-bold text-gray-800 mt-2">{{ $stats_products['total'] }}</p>
                </div>
                <div class="bg-yellow-50 rounded-lg shadow p-6 text-center">
                    <p class="text-yellow-600 text-sm">Pending</p>
                    <p class="text-4xl font-bold text-yellow-700 mt-2">{{ $stats_products['pending'] }}</p>
                </div>
                <div class="bg-blue-50 rounded-lg shadow p-6 text-center">
                    <p class="text-blue-600 text-sm">In Progress</p>
                    <p class="text-4xl font-bold text-blue-700 mt-2">{{ $stats_products['in_progress'] }}</p>
                </div>
                <div class="bg-green-50 rounded-lg shadow p-6 text-center">
                    <p class="text-green-600 text-sm">Completed</p>
                    <p class="text-4xl font-bold text-green-700 mt-2">{{ $stats_products['completed'] }}</p>
                </div>
            </div>

            {{-- Task quick links — shown based on user permissions --}}
            <div class="text-center">
                @can('view-task')
                    <a href="{{ route('tasks.index') }}"
                       class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">
                        View All Tasks
                    </a>
                @endcan

                @can('create-task')
                    <a href="{{ route('tasks.create') }}"
                       class="ml-4 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700">
                        Add New Task
                    </a>
                @endcan
            </div>

            {{-- Category quick links — shown based on user permissions --}}
            <div class="text-center mt-8">
                @can('view-category')
                    <a href="{{ route('categories.index') }}"
                       class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">
                        View All Categories
                    </a>
                @endcan

                @can('create-category')
                    <a href="{{ route('categories.create') }}"
                       class="ml-4 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700">
                        Add New Category
                    </a>
                @endcan
            </div>

            {{-- Product quick links — shown based on user permissions --}}
            <div class="text-center mt-8">
                @can('view-product')
                    <a href="{{ route('products.index') }}"
                       class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">
                        View All Products
                    </a>
                @endcan

                @can('create-product')
                    <a href="{{ route('products.create') }}"
                       class="ml-4 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700">
                        Add New Product
                    </a>
                @endcan
            </div>

            {{-- Activity logs link — only visible to users with view-activity-logs permission --}}
            @can('view-activity-logs')
                <div class="text-center mt-8">
                    <a href="{{ route('activity-logs.index') }}"
                       class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">
                        View Activity Logs
                    </a>
                </div>
            @endcan

        </div>
    </div>
</x-app-layout>