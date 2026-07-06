<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">Add New Task</h2>
    </x-slot>

    <div class="form-page">
        <div class="form-container">
            <div class="form-card">

                <form method="POST" action="{{ route('tasks.store') }}">
                    @csrf

                    {{-- Title --}}
                    <div class="form-group">
                        <label class="form-label">Title *</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               class="form-control @error('title') form-control--error @enderror">
                        @error('title')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label class="form-label">Status *</label>
                        <select name="status" class="form-control @error('status') form-control--error @enderror">
                            <option value="">Select Status</option>
                            <option value="pending"     {{ old('status') == 'pending'     ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed"   {{ old('status') == 'completed'   ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Priority --}}
                    <div class="form-group">
                        <label class="form-label">Priority *</label>
                        <select name="priority" class="form-control @error('priority') form-control--error @enderror">
                            <option value="">Select Priority</option>
                            <option value="low"    {{ old('priority') == 'low'    ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high"   {{ old('priority') == 'high'   ? 'selected' : '' }}>High</option>
                        </select>
                        @error('priority')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Due Date --}}
                    <div class="form-group form-group--last">
                        <label class="form-label">Due Date *</label>
                        <input type="date" name="due_date" value="{{ old('due_date') }}"
                               min="{{ date('Y-m-d') }}"
                               class="form-control @error('due_date') form-control--error @enderror">
                        @error('due_date')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="form-actions">
                        <button type="submit" class="btn btn--primary">
                            Create Task
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