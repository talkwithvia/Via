<section class="mb-4">
    <h2 class="h5">
        <i class="fas fa-key text-muted"></i> {{ __('Update Password') }}
    </h2>

    <p class="text-muted small">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </p>

    <form method="POST" action="{{ route('password.update') }}" class="mt-3">
        @csrf
        @method('PUT')

        <!-- Current Password -->
        <div class="form-group">
            <label for="update_password_current_password">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password"
                class="form-control @error('current_password') is-invalid @enderror" autocomplete="current-password">

            @error('current_password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- New Password -->
        <div class="form-group">
            <label for="update_password_password">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password"
                class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">

            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="update_password_password_confirmation">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="form-control @error('password_confirmation') is-invalid @enderror" autocomplete="new-password">

            @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit -->
        <div class="form-group d-flex align-items-center">
            <button type="submit" class="btn btn-primary">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
                <span class="ml-3 text-success small">
                    <i class="fas fa-check-circle"></i> {{ __('Saved.') }}
                </span>
            @endif
        </div>
    </form>
</section>
