<div
    x-data="{
        theme: localStorage.getItem('theme') || 'system',
        open: false,

        init() {
            this.applyTheme();

            window.matchMedia('(prefers-color-scheme: dark)')
                .addEventListener('change', () => {
                    if (this.theme === 'system') {
                        this.applyTheme();
                    }
                });
        },

        applyTheme() {
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            const isDark = this.theme === 'dark'
                || (this.theme === 'system' && systemDark);

            document.documentElement.classList.toggle('dark', isDark);
        },

        setTheme(value) {
            this.theme = value;
            localStorage.setItem('theme', value);
            this.applyTheme();
            this.open = false;
        },

        themeLabel() {
            if (this.theme === 'light') return 'Terang';
            if (this.theme === 'dark') return 'Gelap';
            return 'Sistem';
        }
    }"
    x-init="init()"
    class="relative"
>
    {{-- TOGGLE BUTTON --}}
    <button
        type="button"
        @click="open = !open"
        class="flex h-10 items-center gap-2 rounded-xl border border-slate-300 bg-white px-3 text-sm font-medium text-slate-700 shadow-sm transition duration-200 hover:border-[#C8102E]/50 hover:bg-[#C8102E]/10 hover:text-[#C8102E] focus:outline-none focus:ring-2 focus:ring-[#C8102E]/30 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:border-[#E21D3F]/50 dark:hover:bg-[#C8102E]/10 dark:hover:text-[#E21D3F]"
        aria-label="Pilih tema"
    >
        {{-- SYSTEM ICON --}}
        <svg
            x-show="theme === 'system'"
            x-cloak
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.8"
            stroke="currentColor"
            class="h-5 w-5"
        >
            <rect
                width="14"
                height="10"
                x="5"
                y="3"
                rx="1"
            />
            <path
                stroke-linecap="round"
                d="M8 21h8M12 17v4"
            />
        </svg>

        {{-- LIGHT ICON --}}
        <svg
            x-show="theme === 'light'"
            x-cloak
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.8"
            stroke="currentColor"
            class="h-5 w-5"
        >
            <circle
                cx="12"
                cy="12"
                r="4"
            />

            <path
                stroke-linecap="round"
                d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"
            />
        </svg>

        {{-- DARK ICON --}}
        <svg
            x-show="theme === 'dark'"
            x-cloak
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.8"
            stroke="currentColor"
            class="h-5 w-5"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M21 12.79A9 9 0 1 1 11.21 3A7 7 0 0 0 21 12.79Z"
            />
        </svg>

        <span
            x-text="themeLabel()"
            class="hidden sm:inline"
        ></span>

        {{-- CHEVRON --}}
        <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="2"
            stroke="currentColor"
            class="h-4 w-4 transition-transform duration-200"
            :class="{ 'rotate-180': open }"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="m6 9 6 6 6-6"
            />
        </svg>
    </button>

    {{-- DROPDOWN --}}
    <div
        x-show="open"
        x-cloak
        x-transition.origin.top.right
        @click.outside="open = false"
        class="absolute right-0 z-50 mt-2 w-44 overflow-hidden rounded-xl border border-slate-200 bg-white p-1.5 shadow-xl dark:border-slate-700 dark:bg-slate-900"
    >
        {{-- SYSTEM --}}
        <button
            type="button"
            @click="setTheme('system')"
            class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left text-sm transition duration-150 hover:bg-[#C8102E]/10 hover:text-[#C8102E]"
            :class="theme === 'system'
                ? 'bg-[#C8102E]/10 text-[#C8102E]'
                : 'text-slate-700 dark:text-slate-300'"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
                class="h-5 w-5 shrink-0"
            >
                <rect
                    width="14"
                    height="10"
                    x="5"
                    y="3"
                    rx="1"
                />
                <path
                    stroke-linecap="round"
                    d="M8 21h8M12 17v4"
                />
            </svg>

            <span class="flex-1">
                Sistem
            </span>

            <span
                x-show="theme === 'system'"
                class="text-[#C8102E]"
            >
                ✓
            </span>
        </button>

        {{-- LIGHT --}}
        <button
            type="button"
            @click="setTheme('light')"
            class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left text-sm transition duration-150 hover:bg-[#C8102E]/10 hover:text-[#C8102E]"
            :class="theme === 'light'
                ? 'bg-[#C8102E]/10 text-[#C8102E]'
                : 'text-slate-700 dark:text-slate-300'"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
                class="h-5 w-5 shrink-0"
            >
                <circle
                    cx="12"
                    cy="12"
                    r="4"
                />

                <path
                    stroke-linecap="round"
                    d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"
                />
            </svg>

            <span class="flex-1">
                Terang
            </span>

            <span
                x-show="theme === 'light'"
                class="text-[#C8102E]"
            >
                ✓
            </span>
        </button>

        {{-- DARK --}}
        <button
            type="button"
            @click="setTheme('dark')"
            class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left text-sm transition duration-150 hover:bg-[#C8102E]/10 hover:text-[#C8102E]"
            :class="theme === 'dark'
                ? 'bg-[#C8102E]/10 text-[#C8102E]'
                : 'text-slate-700 dark:text-slate-300'"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
                class="h-5 w-5 shrink-0"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M21 12.79A9 9 0 1 1 11.21 3A7 7 0 0 0 21 12.79Z"
                />
            </svg>

            <span class="flex-1">
                Gelap
            </span>

            <span
                x-show="theme === 'dark'"
                class="text-[#C8102E]"
            >
                ✓
            </span>
        </button>
    </div>
</div>
