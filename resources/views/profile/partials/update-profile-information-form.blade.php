<section>
    <header style="margin-bottom: 20px;">
        <h3 class="section-label" style="margin: 0 0 4px;">Profile Information</h3>
        <p style="font-size: 13px; color: var(--color-text-muted); margin: 0;">
            Update your account's profile information and email address.
        </p>
    </header>

    {{-- hidden form jo sirf verification email resend karne k liye hai --}}
    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        {{-- Name --}}
        <div class="form-group">
            <label class="form-label">Name *</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                   required autofocus autocomplete="name"
                   class="form-control @error('name') form-control--error @enderror">
            @error('name')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div class="form-group form-group--last">
            <label class="form-label">Email *</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                   required autocomplete="username"
                   class="form-control @error('email') form-control--error @enderror">
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror

            {{-- agar email verify nahi hui to yeh block dikhega --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <p style="font-size: 12px; color: var(--color-text-muted); margin-top: 8px;">
                    Your email address is unverified.
                    <button form="send-verification"
                            style="text-decoration: underline; background: none; border: none; cursor: pointer; color: inherit; padding: 0;">
                        Click here to re-send the verification email.
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p style="font-size: 12px; color: #067647; font-weight: 500; margin-top: 6px;">
                        A new verification link has been sent to your email address.
                    </p>
                @endif
            @endif
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn--primary">
                Save
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   style="font-size: 13px; color: var(--color-text-muted); align-self: center; margin: 0;">
                    Saved.
                </p>
            @endif
        </div>
    </form>
</section>