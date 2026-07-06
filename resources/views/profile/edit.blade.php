<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">Profile</h2>
    </x-slot>

    <div class="form-page">
        <div class="form-container">

            {{-- Profile Information --}}
            <div class="form-card" style="margin-bottom: 24px;">
                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- Update Password --}}
            <div class="form-card" style="margin-bottom: 24px;">
                @include('profile.partials.update-password-form')
            </div>

            {{-- Delete Account --}}
            <div class="form-card">
                @include('profile.partials.delete-user-form')
            </div>

        </div>
    </div>
</x-app-layout>