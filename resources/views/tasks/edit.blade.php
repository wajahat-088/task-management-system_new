<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Task</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">

                <form method="POST" action="{{ route('tasks.update', $task) }}">
                    @csrf
                    @method('PUT')

                    {{-- Title --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-1">Title *</label>
                        <input type="text" name="title"
                               value="{{ old('title', $task->title) }}"
                               class="w-full border rounded px-3 py-2 @error('title') border-red-500 @enderror">
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-1">Description</label>
                        <textarea name="description" rows="4"
                                  class="w-full border rounded px-3 py-2">{{ old('description', $task->description) }}</textarea>
                    </div>

                    {{-- Status --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-1">Status *</label>
                        <select name="status" class="w-full border rounded px-3 py-2">
                            <option value="pending"     {{ old('status', $task->status) == 'pending'     ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed"   {{ old('status', $task->status) == 'completed'   ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    {{-- Priority --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-1">Priority *</label>
                        <select name="priority" class="w-full border rounded px-3 py-2">
                            <option value="low"    {{ old('priority', $task->priority) == 'low'    ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high"   {{ old('priority', $task->priority) == 'high'   ? 'selected' : '' }}>High</option>
                        </select>
                    </div>

                    {{-- Due Date --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-medium mb-1">Due Date *</label>
                        <input type="date" name="due_date"
                               value="{{ old('due_date', $task->due_date) }}"
                               class="w-full border rounded px-3 py-2">
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-3">
                        <button type="submit"
                                class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                            Update Task
                        </button>
                        <a href="{{ route('tasks.index') }}"
                           class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>