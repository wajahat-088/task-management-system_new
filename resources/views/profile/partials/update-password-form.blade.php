<section>
    <header style="margin-bottom: 20px;">
        <h3 class="section-label" style="margin: 0 0 4px;">Update Password</h3>
        <p style="font-size: 13px; color: var(--color-text-muted); margin: 0;">
            Ensure your account is using a long, random password to stay secure.
        </p>
    </header>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        {{-- Current Password --}}
        <div class="form-group">
            <label class="form-label">Current Password *</label>
            <input type="password" name="current_password" autocomplete="current-password"
                   class="form-control @error('current_password', 'updatePassword') form-control--error @enderror">
            @error('current_password', 'updatePassword')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- New Password --}}
        <div class="form-group">
            <label class="form-label">New Password *</label>
            <input type="password" name="password" autocomplete="new-password"
                   class="form-control @error('password', 'updatePassword') form-control--error @enderror">
            @error('password', 'updatePassword')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="form-group form-group--last">
            <label class="form-label">Confirm Password *</label>
            <input type="password" name="password_confirmation" autocomplete="new-password"
                   class="form-control @error('password_confirmation', 'updatePassword') form-control--error @enderror">
            @error('password_confirmation', 'updatePassword')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn--primary">
                Save
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   style="font-size: 13px; color: var(--color-text-muted); align-self: center; margin: 0;">
                    Saved.
                </p>
            @endif
        </div>
    </form>
</section>