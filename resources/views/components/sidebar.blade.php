{{-- Array of menus --}}
@php
    $userMenus = [
        [
            'label' => 'Pengguna',
            'route' => 'users.*',
            'icon' => 'users',
        ],
        [
            'label' => 'Pengajar',
            'route' => 'teachers.*',
            'icon' => 'graduation-cap',
        ],
        [
            'label' => 'Siswa',
            'route' => 'students.*',
            'icon' => 'book-open',
        ],
    ];

    $academicMenus = [
        [
            'label' => 'Kelas',
            'route' => 'classes.*',
            'icon' => 'school',
        ],
        [
            'label' => 'Pendaftaran',
            'route' => 'enrollments.*',
            'icon' => 'user-plus',
        ],
        [
            'label' => 'Jadwal',
            'route' => 'schedules.*',
            'icon' => 'calendar',
        ],
        [
            'label' => 'Presensi',
            'route' => 'attendances.*',
            'icon' => 'check-circle',
        ],
        [
            'label' => 'Presensi Siswa',
            'route' => 'student-attendances.*',
            'icon' => 'users',
        ],
    ];

    $contractPayrollMenus = [
        [
            'label' => 'SPK',
            'route' => 'spk.*',
            'icon' => 'file-text',
        ],
        [
            'label' => 'Periode Gaji',
            'route' => 'payroll-periods.*',
            'icon' => 'calendar-days',
        ],
        [
            'label' => 'Gaji',
            'route' => 'payroll.*',
            'icon' => 'wallet',
        ],
        [
            'label' => 'Detail Gaji',
            'route' => 'payroll-details.*',
            'icon' => 'list',
        ],
    ];

    $reportMenus = [
        [
            'label' => 'Laporan Kehadiran',
            'route' => 'reports.attendance',
            'icon' => 'clipboard-check',
        ],
        [
            'label' => 'Laporan Penggajian',
            'route' => 'reports.payroll',
            'icon' => 'line-chart',
        ],
    ];
@endphp
{{-- Array of menus --}}


<div x-data="{
    open: false,
    activeGroup: null,
    init() {
        this.activeGroup = this.$el.querySelector('[data-active-group]')?.dataset.activeGroup ?? null;
    },
    toggleGroup(name) {
        this.activeGroup = this.activeGroup === name ? null : name;
    }
}" class="sidebar-wrapper">
    {{-- ====================================================
         MOBILE HAMBURGER BUTTON
    ==================================================== --}}
    <button @click="open = !open"
        class="fixed top-4 left-4 z-50 lg:hidden flex items-center justify-center w-10 h-10 rounded-xl text-white/80 hover:text-white transition-all duration-300"
        style="background: rgba(148, 0, 0, 0.984); border: 1px solid rgba(139,92,246,0.25); backdrop-filter: blur(10px);"
        aria-label="Toggle Sidebar">
        <i data-lucide="menu" class="w-5 h-5" x-show="!open"></i>
        <i data-lucide="x" class="w-5 h-5" x-show="open"></i>
    </button>

    {{-- ====================================================
         MOBILE OVERLAY
    ==================================================== --}}
    <div x-show="open" x-transition:enter="transition-opacity duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="open = false"
        class="fixed inset-0 bg-black/50 z-30 lg:hidden" style="display:none; backdrop-filter: blur(4px);"></div>

    {{-- ====================================================
         SIDEBAR MAIN
    ==================================================== --}}
    <aside :class="open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="sidebar-container fixed top-0 left-0 h-screen z-40 w-65 flex flex-col transition-transform duration-300 ease-in-out sidebar-main" "">

        {{-- ------------------------------------------------
             BRAND / LOGO
        ------------------------------------------------ --}}
        <div class="flex items-center gap-3 px-5 py-4.5 -shrink-0"
            style="border-bottom: 1px solid rgba(251, 251, 251, 0.15);">
            <div class="w-9 h-9 rounded-xl shrink-0 flex items-center justify-center"
                style="background: linear-gradient(135deg, #87010e, #eb255d); box-shadow: 0 0 18px #eb255d;">
                <i data-lucide="graduation-cap" class="w-5 h-5 text-white"></i>
            </div>
            <div>
                <p class="text-[13px] font-bold tracking-wide">
                    Ayumi Nihonggo Gakkou</p>
                <p class="text-xs">Sistem Informasi Internal</p>
            </div>
        </div>

        {{-- ------------------------------------------------
             USER CHIP
        ------------------------------------------------ --}}
        <div class="mx-3 mt-4 mb-1 p-3 rounded-2xl flex items-center gap-3 -shrink-0"
            style="background: rgba(233, 233, 233, 0.07); border: 1px solid rgba(139,92,246,0.14);">
            <div class="w-8 h-8 rounded-full -shrink-0 flex items-center justify-center text-xs font-bold text-white"
                style="background: linear-gradient(135deg, #87010e, #eb255d);">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-[12px] font-semibold truncate">
                    {{ auth()->user()->name ?? 'User' }}
                </p>
                <p class="text-xs truncate">
                    @if (auth()->check() && auth()->user()->role === 'admin')
                        Administrator
                    @else
                        Guru
                    @endif
                </p>
            </div>
            <span class="w-2 h-2 rounded-full shrink-0"
                style="background: #34d399; box-shadow: 0 0 6px #34d399;"></span>
        </div>

        {{-- ------------------------------------------------
             SCROLLABLE NAV
        ------------------------------------------------ --}}
        <nav class="flex-1 overflow-y-auto px-3 py-3 space-y-0.5 sidebar-scroll">
            {{-- ============================================
                 ADMIN ROLE MENU
            ============================================ --}}
            @if (auth()->check() && auth()->user()->role === 'admin')
                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}"
                    class="sidebar-nav-item sub text-sm {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                    <span>Dashboard</span>
                </a>
                {{-- ------ GROUP: User Management ------ --}}
                <div>
                    <button
                        class="sidebar-group-label w-full flex items-center justify-between px-3 py-2 rounded-xl transition-all duration-200">
                        <div class="flex items-center gap-2 text-xs font-semibold uppercase ">
                            <i data-lucide="contact-round" class="w-4 h-4"></i>
                            Manajemen Pengguna
                        </div>

                    </button>
                    <div class="ml-5 pl-3 mt-0.5 space-y-0.5 border-l border-gray-500">
                        @foreach ($userMenus as $menu)
                            <a href="#"
                                class="sidebar-nav-item sub {{ request()->routeIs($menu['route']) ? 'active' : '' }}">

                                <span class="nav-icon">
                                    <i data-lucide="{{ $menu['icon'] }}" class="w-4 h-4"></i>
                                </span>

                                {{ $menu['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- ------ GROUP: Academic Management ------ --}}
                <div>
                    <button
                        class="sidebar-group-label w-full flex items-center justify-between px-3 py-2 rounded-xl transition-all duration-200">
                        <div class="flex items-center gap-2 text-xs font-semibold uppercase ">
                            <i data-lucide="university" class="w-4 h-4"></i>
                            Manajemen Akademik
                        </div>

                    </button>
                    <div class="ml-5 pl-3 mt-0.5 space-y-0.5 border-l border-gray-500">
                        @foreach ($academicMenus as $menu)
                            <a href="#"
                                class="sidebar-nav-item sub {{ request()->routeIs($menu['route']) ? 'active' : '' }}">

                                <span class="nav-icon">
                                    <i data-lucide="{{ $menu['icon'] }}" class="w-4 h-4"></i>
                                </span>

                                {{ $menu['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- ------ GROUP: Contract & Payroll ------ --}}
                <div>
                    <button
                        class="sidebar-group-label w-full flex items-center justify-between px-3 py-2 rounded-xl transition-all duration-200">
                        <div class="flex items-center gap-2 text-xs font-semibold uppercase ">
                            <i data-lucide="wallet" class="w-4 h-4"></i>
                            Kontrak &amp; Gaji
                        </div>

                    </button>
                    <div class="ml-5 pl-3 mt-0.5 space-y-0.5 border-l border-gray-500">
                        @foreach ($contractPayrollMenus as $menu)
                            <a href="#"
                                class="sidebar-nav-item sub {{ request()->routeIs($menu['route']) ? 'active' : '' }}">

                                <span class="nav-icon">
                                    <i data-lucide="{{ $menu['icon'] }}" class="w-4 h-4"></i>
                                </span>

                                {{ $menu['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- ------ GROUP: Reports ------ --}}
                @php
                    $reportGroupActive = request()->routeIs('reports.*');
                @endphp
                <div {{ $reportGroupActive ? 'data-active-group=reports' : '' }}>
                    <button @click="toggleGroup('reports')"
                        class="sidebar-group-label w-full flex items-center justify-between px-3 py-2 rounded-xl transition-all duration-200">
                        <div class="flex items-center gap-2 text-xs font-semibold uppercase ">
                            <i data-lucide="clipboard-list" class="w-4 h-4"></i>
                            Laporan
                        </div>
                    </button>
                    <div class="ml-5 pl-3 mt-0.5 space-y-0.5 border-l border-gray-500">
                        @foreach ($reportMenus as $menu)
                            <a href="#"
                                class="sidebar-nav-item sub {{ request()->routeIs($menu['route']) ? 'active' : '' }}">

                                <span class="nav-icon">
                                    <i data-lucide="{{ $menu['icon'] }}" class="w-4 h-4"></i>
                                </span>

                                {{ $menu['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- ============================================
                 GURU ROLE MENU
            ============================================ --}}
            @elseif(auth()->check() && auth()->user()->role === 'pengajar')
                <a href="{{ route('pengajar.dashboard') }}"
                    class="sidebar-nav-item sub text-sm {{ request()->routeIs('pengajar.dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                    <span>Dashboard</span>
                </a>

                <a href="#" class="sidebar-nav-item {{ request()->routeIs('my-classes.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </span>
                    <span>Kelas</span>
                </a>

                <a href="#" class="sidebar-nav-item {{ request()->routeIs('my-schedule.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <span>Jadwal</span>
                </a>

                <a href="#"
                    class="sidebar-nav-item {{ request()->routeIs('my-attendances.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <span>Presensi</span>
                </a>

                <a href="#"
                    class="sidebar-nav-item {{ request()->routeIs('payroll-history.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </span>
                    <span>Riwayat Gaji</span>
                </a>
            @endif

        </nav>

        {{-- ------------------------------------------------
             FOOTER / LOGOUT
        ------------------------------------------------ --}}
        <div class="px-3 pb-4 pt-3 -shrink-0" style="border-top: 1px solid rgba(139,92,246,0.12);">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="sidebar-logout-btn w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all duration-200">
                    <svg class="w-4 h-4 -shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Keluar
                </button>
            </form>
        </div>

    </aside>

</div>
