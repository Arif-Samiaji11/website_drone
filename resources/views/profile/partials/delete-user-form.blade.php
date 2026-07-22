<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-white tracking-wide">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 vg-desc">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="vg-btn-danger"
    >
        {{ __('Delete Account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-[#1a2035] border border-white/10 rounded-lg text-white">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-white">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-2 text-sm text-white/70">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">{{ __('Password') }}</label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    class="vg-input mt-1 block w-full sm:w-3/4"
                    placeholder="{{ __('Password') }}"
                    required
                />

                @if ($errors->userDeletion->has('password'))
                    @foreach ($errors->userDeletion->get('password') as $msg)
                        <div class="vg-error">{{ $msg }}</div>
                    @endforeach
                @endif
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="vg-btn-secondary">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="vg-btn-danger">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
