<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">Add New Category</h2>
    </x-slot>

    <div class="form-page">
        <div class="form-container form-container--narrow">
            <div class="form-card">

                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf

                    <div class="form-group form-group--last">
                        <label class="form-label">Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="form-control @error('name') form-control--error @enderror">
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn--primary">
                            Create Category
                        </button>
                        <a href="{{ route('categories.index') }}" class="btn btn--secondary">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>