<section>
    <header>
        <h2 class="text-lg font-bold text-white tracking-wide">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 vg-desc">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="vg-label">{{ __('Current Password') }}</label>
            <input 
                id="update_password_current_password" 
                name="current_password" 
                type="password" 
                class="vg-input mt-1" 
                autocomplete="current-password" 
                placeholder="Password Saat Ini"
            />
            @if ($errors->updatePassword->has('current_password'))
                @foreach ($errors->updatePassword->get('current_password') as $msg)
                    <div class="vg-error">{{ $msg }}</div>
                @endforeach
            @endif
        </div>

        <div>
            <label for="update_password_password" class="vg-label">{{ __('New Password') }}</label>
            <input 
                id="update_password_password" 
                name="password" 
                type="password" 
                class="vg-input mt-1" 
                autocomplete="new-password" 
                placeholder="Buat Password Baru (min. 8 karakter)"
            />
            @if ($errors->updatePassword->has('password'))
                @foreach ($errors->updatePassword->get('password') as $msg)
                    <div class="vg-error">{{ $msg }}</div>
                @endforeach
            @endif
        </div>

        <div>
            <label for="update_password_password_confirmation" class="vg-label">{{ __('Confirm Password') }}</label>
            <input 
                id="update_password_password_confirmation" 
                name="password_confirmation" 
                type="password" 
                class="vg-input mt-1" 
                autocomplete="new-password" 
                placeholder="Ulangi Password Baru"
            />
            @if ($errors->updatePassword->has('password_confirmation'))
                @foreach ($errors->updatePassword->get('password_confirmation') as $msg)
                    <div class="vg-error">{{ $msg }}</div>
                @endforeach
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="vg-btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-emerald-400 font-semibold"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
