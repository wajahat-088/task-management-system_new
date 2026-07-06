<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">Edit Task</h2>
    </x-slot>

    <div class="form-page">
        <div class="form-container">
            
            <div class="form-card">

                <form method="POST" action="{{ route('tasks.update', $task) }}">
                    @csrf
                    @method('PUT')

                    {{-- Title --}}
                    <div class="form-group">
                        <label class="form-label">Title *</label>
                        <input type="text" name="title"
                               value="{{ old('title', $task->title) }}"
                               class="form-control @error('title') form-control--error @enderror">
                        @error('title')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="4" class="form-control">{{ old('description', $task->description) }}</textarea>
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label class="form-label">Status *</label>
                        <select name="status" class="form-control">
                            <option value="pending"     {{ old('status', $task->status) == 'pending'     ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed"   {{ old('status', $task->status) == 'completed'   ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    {{-- Priority --}}
                    <div class="form-group">
                        <label class="form-label">Priority *</label>
                        <select name="priority" class="form-control">
                            <option value="low"    {{ old('priority', $task->priority) == 'low'    ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high"   {{ old('priority', $task->priority) == 'high'   ? 'selected' : '' }}>High</option>
                        </select>
                    </div>

                    {{-- Due Date --}}
                    <div class="form-group form-group--last">
                        <label class="form-label">Due Date *</label>
                        <input type="date" name="due_date"
                               value="{{ old('due_date', $task->due_date) }}"
                               class="form-control">
                    </div>

                    {{-- Buttons --}}
                    <div class="form-actions">
                        <button type="submit" class="btn btn--primary">
                            Update Task
                        </button>
                        <a href="{{ route('tasks.index') }}" class="btn btn--secondary">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>