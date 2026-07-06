<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">Edit Product</h2>
    </x-slot>

    <div class="form-page">
        <div class="form-container">
            <div class="form-card">

                <form method="POST" action="{{ route('products.update', $product) }}">
                    @csrf
                    @method('PUT')

                    {{-- Title --}}
                    <div class="form-group">
                        <label class="form-label">Title *</label>
                        <input type="text" name="title"
                               value="{{ old('title', $product->title) }}"
                               class="form-control @error('title') form-control--error @enderror">
                        @error('title')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="4" class="form-control">{{ old('description', $product->description) }}</textarea>
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label class="form-label">Status *</label>
                        <select name="status" class="form-control">
                            <option value="pending"     {{ old('status', $product->status) == 'pending'     ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ old('status', $product->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed"   {{ old('status', $product->status) == 'completed'   ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    {{-- Priority --}}
                    <div class="form-group">
                        <label class="form-label">Priority *</label>
                        <select name="priority" class="form-control">
                            <option value="low"    {{ old('priority', $product->priority) == 'low'    ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority', $product->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high"   {{ old('priority', $product->priority) == 'high'   ? 'selected' : '' }}>High</option>
                        </select>
                    </div>

                    {{-- Due Date --}}
                    <div class="form-group">
                        <label class="form-label">Due Date *</label>
                        <input type="date" name="due_date"
                               value="{{ old('due_date', $product->due_date) }}"
                               class="form-control">
                    </div>

                    {{-- Category --}}
                    <div class="form-group form-group--last">
                        <label class="form-label">Category *</label>
                        <select name="category_id" class="form-control @error('category_id') form-control--error @enderror">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="form-actions">
                        <button type="submit" class="btn btn--primary">
                            Update Product
                        </button>
                        <a href="{{ route('products.index') }}" class="btn btn--secondary">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>