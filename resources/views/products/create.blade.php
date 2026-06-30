<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add New Product</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">

                <form method="POST" action="{{ route('products.store') }}">
                    @csrf

                    {{-- Title --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-1">Title *</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               class="w-full border rounded px-3 py-2 @error('title') border-red-500 @enderror">
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-1">Description</label>
                        <textarea name="description" rows="4"
                                  class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
                    </div>

                    {{-- Status --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-1">Status *</label>
                        <select name="status"
                                class="w-full border rounded px-3 py-2 @error('status') border-red-500 @enderror">
                            <option value="">Select Status</option>
                            <option value="pending"     {{ old('status') == 'pending'     ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed"   {{ old('status') == 'completed'   ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Priority --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-1">Priority *</label>
                        <select name="priority"
                                class="w-full border rounded px-3 py-2 @error('priority') border-red-500 @enderror">
                            <option value="">Select Priority</option>
                            <option value="low"    {{ old('priority') == 'low'    ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high"   {{ old('priority') == 'high'   ? 'selected' : '' }}>High</option>
                        </select>
                        @error('priority')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Due Date --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-1">Due Date *</label>
                        <input type="date" name="due_date" value="{{ old('due_date') }}"
                               min="{{ date('Y-m-d') }}"
                               class="w-full border rounded px-3 py-2 @error('due_date') border-red-500 @enderror">
                        @error('due_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Category --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-medium mb-1">Category *</label>
                        <select name="category_id"
                                class="w-full border rounded px-3 py-2 @error('category_id') border-red-500 @enderror">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-3">
                        <button type="submit"
                                class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                            Create Product
                        </button>
                        <a href="{{ route('products.index') }}"
                           class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>