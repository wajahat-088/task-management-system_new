<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Name --}}
        <div class="form-group">
            <label for="name" class="form-label">Name *</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}"
                   required autofocus autocomplete="name"
                   class="form-control @error('name') form-control--error @enderror">
            @error('name')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div class="form-group">
            <label for="email" class="form-label">Email *</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   required autocomplete="username"
                   class="form-control @error('email') form-control--error @enderror">
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="form-group">
            <label for="password" class="form-label">Password *</label>
            <input id="password" type="password" name="password"
                   required autocomplete="new-password"
                   class="form-control @error('password') form-control--error @enderror">
            @error('password')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="form-group form-group--last">
            <label for="password_confirmation" class="form-label">Confirm Password *</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   required autocomplete="new-password"
                   class="form-control @error('password_confirmation') form-control--error @enderror">
            @error('password_confirmation')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-actions" style="justify-content: space-between; align-items: center; margin-top: 24px;">
            <a href="{{ route('login') }}" class="auth-link">
                Already registered?
            </a>

            <button type="submit" class="btn btn--primary">
                Register
            </button>
        </div>
    </form>
</x-guest-layout>