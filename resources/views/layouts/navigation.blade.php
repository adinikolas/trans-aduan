<nav
    x-data="{ open: false }"
    class="relative z-50 border-b border-slate-200 bg-white/95 backdrop-blur transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900/95"
>
    {{-- =====================================================
         DESKTOP NAVIGATION
    ====================================================== --}}
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="flex h-16 items-center justify-between">

            {{-- =================================================
                 LEFT SIDE
            ================================================== --}}
            <div class="flex items-center">

                {{-- LOGO --}}
                <a
                    href="{{ route('dashboard') }}"
                    class="flex h-10 w-10 shrink-0 items-center justify-center"
                >
                    <x-application-logo
                        class="h-9 w-9 object-contain"
                    />
                </a>


                {{-- NAVIGATION --}}
                <div class="hidden h-16 sm:ms-10 sm:flex sm:items-center">

                    <a
                        href="{{ route('complaints.index') }}"
                        class="inline-flex h-16 items-center border-b-2 border-[#C8102E] px-1 text-sm font-medium text-slate-800 transition-colors duration-200 dark:text-white"
                    >
                        Aduan Saya
                    </a>

                </div>

            </div>


            {{-- =================================================
                 RIGHT SIDE DESKTOP
            ================================================== --}}
            <div class="hidden items-center gap-3 sm:flex">

                {{-- THEME TOGGLE --}}
                <x-theme-toggle />


                {{-- USER DROPDOWN --}}
                <x-dropdown
                    align="right"
                    width="48"
                >

                    <x-slot name="trigger">

                        <button
                            type="button"
                            class="inline-flex items-center gap-2 rounded-xl border border-transparent px-3 py-2 text-sm font-medium text-slate-700 transition duration-200 hover:bg-slate-100 hover:text-slate-900 focus:outline-none dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white"
                        >

                            <span>
                                {{ Auth::user()->name }}
                            </span>

                            <svg
                                class="h-4 w-4"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m6 9 6 6 6-6"
                                />
                            </svg>

                        </button>

                    </x-slot>


                    {{-- USER MENU --}}
                    <x-slot name="content">

                        {{-- PROFILE --}}
                        <x-dropdown-link
                            :href="route('profile.edit')"
                        >
                            {{ __('Profile') }}
                        </x-dropdown-link>


                        {{-- LOGOUT --}}
                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                        >
                            @csrf

                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                            >
                                {{ __('Log Out') }}
                            </x-dropdown-link>

                        </form>

                    </x-slot>

                </x-dropdown>

            </div>


            {{-- =================================================
                 MOBILE CONTROLS
            ================================================== --}}
            <div class="flex items-center sm:hidden">

                {{-- THEME TOGGLE --}}
                <div class="me-2">
                    <x-theme-toggle />
                </div>


                {{-- MENU BUTTON --}}
                <button
                    type="button"
                    @click="open = !open"
                    class="inline-flex items-center justify-center rounded-xl p-2 text-slate-700 transition duration-200 hover:bg-slate-100 hover:text-slate-900 focus:outline-none dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white"
                    aria-label="Toggle navigation"
                >

                    {{-- HAMBURGER --}}
                    <svg
                        x-show="!open"
                        x-cloak
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                    </svg>


                    {{-- CLOSE --}}
                    <svg
                        x-show="open"
                        x-cloak
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>

                </button>

            </div>

        </div>
    </div>


    {{-- =====================================================
         MOBILE NAVIGATION
    ====================================================== --}}
    <div
        x-show="open"
        x-cloak
        x-transition
        class="border-t border-slate-200 bg-white/95 transition-colors duration-300 sm:hidden dark:border-slate-800 dark:bg-slate-900/95"
    >

        <div class="space-y-1 px-4 py-4">

            {{-- USER INFO --}}
            <div class="mb-4 border-b border-slate-200 px-2 pb-4 dark:border-slate-800">

                <div class="text-sm font-semibold text-slate-900 dark:text-white">
                    {{ Auth::user()->name }}
                </div>

                <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                    {{ Auth::user()->email }}
                </div>

            </div>


            {{-- ADUAN --}}
            <a
                href="{{ route('complaints.index') }}"
                @click="open = false"
                class="block rounded-xl bg-slate-100 px-4 py-3 text-sm font-medium text-slate-900 transition hover:bg-slate-200 dark:bg-slate-800 dark:text-white dark:hover:bg-slate-700"
            >
                Aduan Saya
            </a>


            {{-- PROFILE --}}
            <a
                href="{{ route('profile.edit') }}"
                @click="open = false"
                class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white"
            >
                Profile
            </a>


            {{-- LOGOUT --}}
            <form
                method="POST"
                action="{{ route('logout') }}"
            >
                @csrf

                <button
                    type="submit"
                    class="block w-full rounded-xl px-4 py-3 text-left text-sm font-medium text-slate-700 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white"
                >
                    Log Out
                </button>

            </form>

        </div>

    </div>

</nav>
