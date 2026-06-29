<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

                {{-- Total --}}
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-gray-500 text-sm">Total Tasks</p>
                    <p class="text-4xl font-bold text-gray-800 mt-2">{{ $stats['total'] }}</p>
                </div>

                {{-- Pending --}}
                <div class="bg-yellow-50 rounded-lg shadow p-6 text-center">
                    <p class="text-yellow-600 text-sm">Pending</p>
                    <p class="text-4xl font-bold text-yellow-700 mt-2">{{ $stats['pending'] }}</p>
                </div>

                {{-- In Progress --}}
                <div class="bg-blue-50 rounded-lg shadow p-6 text-center">
                    <p class="text-blue-600 text-sm">In Progress</p>
                    <p class="text-4xl font-bold text-blue-700 mt-2">{{ $stats['in_progress'] }}</p>
                </div>

                {{-- Completed --}}
                <div class="bg-green-50 rounded-lg shadow p-6 text-center">
                    <p class="text-green-600 text-sm">Completed</p>
                    <p class="text-4xl font-bold text-green-700 mt-2">{{ $stats['completed'] }}</p>
                </div>

            </div>

            {{-- Quick Link --}}
            <div class="text-center">
                <a href="{{ route('tasks.index') }}"
                   class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">
                    View All Tasks
                </a>
                <a href="{{ route('tasks.create') }}"
                   class="ml-4 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700">
                    Add New Task
                </a>
            </div>

        </div>
    </div>
</x-app-layout>