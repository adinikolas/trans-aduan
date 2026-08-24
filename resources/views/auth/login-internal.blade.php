<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
            Login Internal
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            CC Room dan Manager
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('internal.login.store') }}">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />

            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
            />

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            />

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"
            />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input
                    id="remember_me"
                    type="checkbox"
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-red-600 shadow-sm focus:ring-red-500"
                    name="remember"
                >

                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Remember me') }}
                </span>
            </label>
        </div>

        <!-- Submit -->
        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100"
                    href="{{ route('password.request') }}"
                >
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Role Information -->
    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
        <p class="text-xs text-center text-gray-500 dark:text-gray-400 mb-3">
            Login ini digunakan oleh:
        </p>

        <div class="grid grid-cols-1 gap-2">
            <div class="rounded-lg bg-gray-50 dark:bg-gray-800 p-3 text-center">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    CC Room
                </span>
            </div>

            <div class="rounded-lg bg-gray-50 dark:bg-gray-800 p-3 text-center">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    Manager Keuangan
                </span>
            </div>

            <div class="rounded-lg bg-gray-50 dark:bg-gray-800 p-3 text-center">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    Manager Operasional
                </span>
            </div>
        </div>
    </div>

    <!-- Public Login -->
    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Anda pengguna umum?
        </p>

        <a
            href="{{ route('login') }}"
            class="inline-block mt-2 text-sm font-semibold text-red-700 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
        >
            Login Pengguna Umum →
        </a>
    </div>

    <!-- Back to Home -->
    <div class="mt-4 text-center">
        <a
            href="{{ url('/') }}"
            class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
        >
            ← Kembali ke halaman utama
        </a>
    </div>
</x-guest-layout>
