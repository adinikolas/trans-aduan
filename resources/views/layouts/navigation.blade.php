
<nav
    x-data="{ open: false }"
    class="relative z-50 border-b border-slate-200 bg-white/95 backdrop-blur transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900/95"
>
    @php
        $role = Auth::user()->role;

        if ($role === 'manager_operasional') {
            $dashboardRoute = route('manager.operasional');
        } elseif ($role === 'manager_keuangan') {
            $dashboardRoute = route('manager.keuangan');
        } else {
            $dashboardRoute = route('dashboard');
        }

        $internalRoles = [
            'cc_room',
            'manager_keuangan',
            'manager_operasional',
        ];
    @endphp

    {{-- DESKTOP NAVIGATION --}}
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            {{-- LOGO DAN MENU --}}
            <div class="flex items-center">
                <a
                    href="{{ $dashboardRoute }}"
                    class="flex h-10 w-10 shrink-0 items-center justify-center"
                >
                    <x-application-logo class="h-9 w-9 object-contain" />
                </a>

                <div class="hidden h-16 sm:ms-10 sm:flex sm:items-center sm:gap-8">

                    {{-- MANAGER OPERASIONAL --}}
                    @if($role === 'manager_operasional')
                        <a
                            href="{{ route('manager.operasional') }}"
                            class="inline-flex h-16 items-center border-b-2 px-1 text-sm font-medium transition-colors duration-200
                            {{ request()->routeIs('manager.operasional')
                                ? 'border-[#C8102E] text-slate-900 dark:text-white'
                                : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 dark:text-slate-400 dark:hover:border-slate-600 dark:hover:text-slate-200'
                            }}"
                        >
                            Dashboard
                        </a>

                        <a
                            href="{{ route('manager.operasional.aduan') }}"
                            class="inline-flex h-16 items-center border-b-2 px-1 text-sm font-medium transition-colors duration-200
                            {{ request()->routeIs('manager.operasional.aduan')
                                ? 'border-[#C8102E] text-slate-900 dark:text-white'
                                : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 dark:text-slate-400 dark:hover:border-slate-600 dark:hover:text-slate-200'
                            }}"
                        >
                            Aduan Saya
                        </a>

                    {{-- MANAGER KEUANGAN --}}
                    @elseif($role === 'manager_keuangan')
                        <a
                            href="{{ route('manager.keuangan') }}"
                            class="inline-flex h-16 items-center border-b-2 px-1 text-sm font-medium transition-colors duration-200
                            {{ request()->routeIs('manager.keuangan')
                                ? 'border-[#C8102E] text-slate-900 dark:text-white'
                                : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 dark:text-slate-400 dark:hover:border-slate-600 dark:hover:text-slate-200'
                            }}"
                        >
                            Dashboard
                        </a>

                        <a
                            href="{{ route('manager.keuangan.aduan') }}"
                            class="inline-flex h-16 items-center border-b-2 px-1 text-sm font-medium transition-colors duration-200
                            {{ request()->routeIs('manager.keuangan.aduan')
                                ? 'border-[#C8102E] text-slate-900 dark:text-white'
                                : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 dark:text-slate-400 dark:hover:border-slate-600 dark:hover:text-slate-200'
                            }}"
                        >
                            Aduan Saya
                        </a>

                    {{-- CC ROOM --}}
                    @elseif($role === 'cc_room')
                        <a
                            href="{{ route('dashboard') }}"
                            class="inline-flex h-16 items-center border-b-2 px-1 text-sm font-medium transition-colors duration-200
                            {{ request()->routeIs('dashboard')
                                ? 'border-[#C8102E] text-slate-900 dark:text-white'
                                : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 dark:text-slate-400 dark:hover:border-slate-600 dark:hover:text-slate-200'
                            }}"
                        >
                            Dashboard
                        </a>

                    {{-- PENGGUNA --}}
                    @else
                        <a
                            href="{{ route('complaints.index') }}"
                            class="inline-flex h-16 items-center border-b-2 px-1 text-sm font-medium transition-colors duration-200
                            {{ request()->routeIs('complaints.index')
                                ? 'border-[#C8102E] text-slate-900 dark:text-white'
                                : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 dark:text-slate-400 dark:hover:border-slate-600 dark:hover:text-slate-200'
                            }}"
                        >
                            Aduan Saya
                        </a>
                    @endif

                    {{-- MENU ULASAN PENGGUNA UNTUK INTERNAL --}}
                    @if(in_array($role, $internalRoles, true))
                        <a
                            href="{{ route('feedback.index') }}"
                            class="inline-flex h-16 items-center border-b-2 px-1 text-sm font-medium transition-colors duration-200
                            {{ request()->routeIs('feedback.index')
                                ? 'border-[#C8102E] text-slate-900 dark:text-white'
                                : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 dark:text-slate-400 dark:hover:border-slate-600 dark:hover:text-slate-200'
                            }}"
                        >
                            Ulasan Pengguna
                        </a>
                    @endif
                </div>
            </div>

            {{-- KONTROL DESKTOP --}}
            <div class="hidden items-center gap-3 sm:flex">
                <x-theme-toggle />

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            type="button"
                            class="inline-flex items-center gap-2 rounded-xl border border-transparent px-3 py-2 text-sm font-medium text-slate-700 transition duration-200 hover:bg-slate-100 hover:text-slate-900 focus:outline-none dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white"
                        >
                            <span>{{ Auth::user()->name }}</span>

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

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
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

            {{-- KONTROL MOBILE --}}
            <div class="flex items-center sm:hidden">
                <div class="me-2">
                    <x-theme-toggle />
                </div>

                <button
                    type="button"
                    @click="open = !open"
                    class="inline-flex items-center justify-center rounded-xl p-2 text-slate-700 transition duration-200 hover:bg-slate-100 hover:text-slate-900 focus:outline-none dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white"
                    aria-label="Toggle navigation"
                >
                    {{-- IKON HAMBURGER --}}
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

                    {{-- IKON CLOSE --}}
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

    {{-- MOBILE NAVIGATION --}}
    <div
        x-show="open"
        x-cloak
        x-transition
        class="border-t border-slate-200 bg-white/95 transition-colors duration-300 sm:hidden dark:border-slate-800 dark:bg-slate-900/95"
    >
        <div class="space-y-1 px-4 py-4">

            {{-- INFORMASI PENGGUNA --}}
            <div class="mb-4 border-b border-slate-200 px-2 pb-4 dark:border-slate-800">
                <div class="text-sm font-semibold text-slate-900 dark:text-white">
                    {{ Auth::user()->name }}
                </div>

                <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                    {{ Auth::user()->email }}
                </div>
            </div>

            {{-- MENU MANAGER OPERASIONAL --}}
            @if($role === 'manager_operasional')
                <a
                    href="{{ route('manager.operasional') }}"
                    @click="open = false"
                    class="block rounded-xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('manager.operasional')
                        ? 'bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-white'
                        : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white'
                    }}"
                >
                    Dashboard
                </a>

                <a
                    href="{{ route('manager.operasional.aduan') }}"
                    @click="open = false"
                    class="block rounded-xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('manager.operasional.aduan')
                        ? 'bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-white'
                        : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white'
                    }}"
                >
                    Aduan Saya
                </a>

            {{-- MENU MANAGER KEUANGAN --}}
            @elseif($role === 'manager_keuangan')
                <a
                    href="{{ route('manager.keuangan') }}"
                    @click="open = false"
                    class="block rounded-xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('manager.keuangan')
                        ? 'bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-white'
                        : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white'
                    }}"
                >
                    Dashboard
                </a>

                <a
                    href="{{ route('manager.keuangan.aduan') }}"
                    @click="open = false"
                    class="block rounded-xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('manager.keuangan.aduan')
                        ? 'bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-white'
                        : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white'
                    }}"
                >
                    Aduan Saya
                </a>

            {{-- MENU CC ROOM --}}
            @elseif($role === 'cc_room')
                <a
                    href="{{ route('dashboard') }}"
                    @click="open = false"
                    class="block rounded-xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('dashboard')
                        ? 'bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-white'
                        : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white'
                    }}"
                >
                    Dashboard
                </a>

            {{-- MENU PENGGUNA --}}
            @else
                <a
                    href="{{ route('complaints.index') }}"
                    @click="open = false"
                    class="block rounded-xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('complaints.index')
                        ? 'bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-white'
                        : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white'
                    }}"
                >
                    Aduan Saya
                </a>
            @endif

            {{-- MENU ULASAN PENGGUNA UNTUK INTERNAL --}}
            @if(in_array($role, $internalRoles, true))
                <a
                    href="{{ route('feedback.index') }}"
                    @click="open = false"
                    class="block rounded-xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('feedback.index')
                        ? 'bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-white'
                        : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white'
                    }}"
                >
                    Ulasan Pengguna
                </a>
            @endif

            {{-- PROFILE --}}
            <a
                href="{{ route('profile.edit') }}"
                @click="open = false"
                class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white"
            >
                Profile
            </a>

            {{-- LOGOUT --}}
            <form method="POST" action="{{ route('logout') }}">
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
