<x-guest-layout>
  <div class="min-h-screen flex items-center justify-center bg-slate-900 text-white px-4">
    <div class="w-full max-w-md bg-slate-800/60 border border-slate-700 rounded-2xl p-6">
      <h1 class="text-2xl font-bold">Admin Login</h1>
      <p class="text-white/70 mt-1">Masuk ke panel admin.</p>

      <x-auth-session-status class="mt-4" :status="session('status')" />

      <form method="POST" action="{{ route('admin.login.store') }}" class="mt-4 space-y-4">
        @csrf

        <div>
          <x-input-label for="email" :value="'Email'" />
          <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
            :value="old('email')" required autofocus autocomplete="username" />
          <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
          <x-input-label for="password" :value="'Password'" />
          <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
            required autocomplete="current-password" />
          <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label class="inline-flex items-center gap-2">
          <input type="checkbox" name="remember" class="rounded border-slate-600 bg-slate-900">
          <span class="text-sm text-white/80">Ingat saya</span>
        </label>

        <div class="flex justify-end">
          <x-primary-button>Masuk</x-primary-button>
        </div>
      </form>
    </div>
  </div>
</x-guest-layout>