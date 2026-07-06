<x-guest-layout>
    {{-- Session Status --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="form-group">
            <label for="email" class="form-label">Email *</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   required autofocus autocomplete="username"
                   class="form-control @error('email') form-control--error @enderror">
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="form-group form-group--last">
            <label for="password" class="form-label">Password *</label>
            <input id="password" type="password" name="password"
                   required autocomplete="current-password"
                   class="form-control @error('password') form-control--error @enderror">
            @error('password')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember Me --}}
        <div class="auth-checkbox-row">
            <input id="remember_me" type="checkbox" name="remember">
            <label for="remember_me">Remember me</label>
        </div>

        <div class="form-actions" style="justify-content: space-between; align-items: center; margin-top: 24px;">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-link">
                    Forgot your password?
                </a>
            @endif

            <button type="submit" class="btn btn--primary">
                Log in
            </button>
        </div>
    </form>
</x-guest-layout>