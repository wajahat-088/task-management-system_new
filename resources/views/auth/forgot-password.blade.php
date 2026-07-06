<x-guest-layout>
    <p style="font-size: 13px; color: var(--color-text-muted); margin: 0 0 20px; line-height: 1.5;">
        Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
    </p>

    {{-- Session Status --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        {{-- Email --}}
        <div class="form-group form-group--last">
            <label for="email" class="form-label">Email *</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   required autofocus
                   class="form-control @error('email') form-control--error @enderror">
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-actions" style="justify-content: flex-end; margin-top: 24px;">
            <button type="submit" class="btn btn--primary">
                Email Password Reset Link
            </button>
        </div>
    </form>
</x-guest-layout>