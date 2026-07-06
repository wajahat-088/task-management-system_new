<section>
    <header style="margin-bottom: 20px;">
        <h3 class="section-label" style="margin: 0 0 4px;">Delete Account</h3>
        <p style="font-size: 13px; color: var(--color-text-muted); margin: 0;">
            Once your account is deleted, all of its resources and data will be permanently deleted.
            Before deleting your account, please download any data or information that you wish to retain.
        </p>
    </header>

    <button
        type="button"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="btn-sm btn-sm--delete"
        style="padding: 8px 16px; font-size: 14px;">
        Delete Account
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="POST" action="{{ route('profile.destroy') }}" style="padding: 24px;">
            @csrf
            @method('delete')

            <h3 class="section-label" style="margin: 0 0 8px;">
                Are you sure you want to delete your account?
            </h3>

            <p style="font-size: 13px; color: var(--color-text-muted); margin: 0 0 16px;">
                Once your account is deleted, all of its resources and data will be permanently deleted.
                Please enter your password to confirm you would like to permanently delete your account.
            </p>

            <div class="form-group form-group--last">
                <input type="password" name="password" placeholder="Password"
                       class="form-control @error('password', 'userDeletion') form-control--error @enderror">
                @error('password', 'userDeletion')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-actions" style="justify-content: flex-end;">
                <a href="#" x-on:click.prevent="$dispatch('close')" class="btn btn--secondary">
                    Cancel
                </a>
                <button type="submit" class="btn-sm btn-sm--delete" style="padding: 8px 16px; font-size: 14px;">
                    Delete Account
                </button>
            </div>
        </form>
    </x-modal>
</section>