<section class="mb-4">
    <h2 class="h5">
        <i class="fas fa-user text-muted"></i> {{ __('Profile Information') }}
    </h2>

    <p class="text-muted small">
        {{ __("Update your account's profile information and email address.") }}
    </p>

    <!-- Hidden form for resending verification -->
    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="POST" action="{{ route('profile.update') }}" class="mt-3">
        @csrf
        @method('PATCH')

        <!-- Name -->
        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
                class="form-control @error('name') is-invalid @enderror" required autofocus autocomplete="name">

            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
                class="form-control @error('email') is-invalid @enderror" required autocomplete="username">

            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="small text-danger mb-1">
                        {{ __('Your email address is unverified.') }}
                    </p>

                    <button type="submit" form="send-verification" class="btn btn-link p-0 small">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="small text-success mt-1">
                            <i class="fas fa-check-circle"></i>
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Save Button -->
        <div class="form-group d-flex align-items-center">
            <button type="submit" class="btn btn-primary">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <span class="ml-3 text-success small">
                    <i class="fas fa-check-circle"></i> {{ __('Saved.') }}
                </span>
            @endif
        </div>
    </form>
</section>
