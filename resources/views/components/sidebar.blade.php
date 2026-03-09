@php

    $isAdmin = auth()->check() && auth()->user()->hasRole('admin');
    $isPengajar = auth()->check() && auth()->user()->hasRole('pengajar');
    $isStaff = auth()->check() && auth()->user()->hasRole('staff');
    $isSiswa = auth()->check() && auth()->user()->hasRole('siswa');

    $roleLabel = match (true) {
        $isAdmin => 'Administrator',
        $isPengajar => 'Pengajar',
        $isStaff => 'Staff',
        $isSiswa => 'Siswa',
        default => 'User',
    };
    $userMenus = [
        ['label' => 'Admin', 'route' => 'admin.users.admin', 'active' => 'admin.users.admin', 'icon' => 'shield-check'],
        [
            'label' => 'Pengajar',
            'route' => 'admin.users.pengajar',
            'active' => 'admin.users.pengajar',
            'icon' => 'graduation-cap',
        ],
        ['label' => 'Staff', 'route' => 'admin.users.staff', 'active' => 'admin.users.staff', 'icon' => 'briefcase'],
        ['label' => 'Siswa', 'route' => 'admin.users.siswa', 'active' => 'admin.users.siswa', 'icon' => 'book-open'],
    ];
    $academicMenus = [
        ['label' => 'Kelas', 'route' => 'admin.classes.index', 'active' => 'admin.classes.*', 'icon' => 'school'],
        [
            'label' => 'Pendaftaran',
            'route' => 'admin.enrollments.index',
            'active' => 'admin.enrollments.*',
            'icon' => 'user-plus',
        ],
        [
            'label' => 'Jadwal',
            'route' => 'admin.schedules.index',
            'active' => 'admin.schedules.*',
            'icon' => 'calendar',
        ],
        [
            'label' => 'Presensi',
            'route' => 'admin.attendances.index',
            'active' => 'admin.attendances.*',
            'icon' => 'check-circle',
        ],
        [
            'label' => 'Presensi Siswa',
            'route' => 'admin.student-attendances.index',
            'active' => 'admin.student-attendances.*',
            'icon' => 'users',
        ],
    ];

    $contractPayrollMenus = [
        ['label' => 'SPK', 'route' => 'admin.spk.index', 'active' => 'admin.spk.*', 'icon' => 'file-text'],
        [
            'label' => 'Periode Gaji',
            'route' => 'admin.payroll-periods.index',
            'active' => 'admin.payroll-periods.*',
            'icon' => 'calendar-days',
        ],
        ['label' => 'Gaji', 'route' => 'admin.payroll.index', 'active' => 'admin.payroll.*', 'icon' => 'wallet'],
        [
            'label' => 'Detail Gaji',
            'route' => 'admin.payroll-details.index',
            'active' => 'admin.payroll-details.*',
            'icon' => 'list',
        ],
    ];

    // Menu admin - laporan
    $reportMenus = [
        [
            'label' => 'Laporan Kehadiran',
            'route' => 'admin.reports.attendance',
            'active' => 'admin.reports.attendance',
            'icon' => 'clipboard-check',
        ],
        [
            'label' => 'Laporan Penggajian',
            'route' => 'admin.reports.payroll',
            'active' => 'admin.reports.payroll',
            'icon' => 'line-chart',
        ],
    ];

    $pengajarMenus = [
        ['label' => 'Kelas', 'route' => '#', 'active' => 'my-classes.*', 'icon' => 'building-2'],
        ['label' => 'Jadwal', 'route' => '#', 'active' => 'my-schedule.*', 'icon' => 'calendar'],
        ['label' => 'Presensi', 'route' => '#', 'active' => 'my-attendances.*', 'icon' => 'check-circle'],
        ['label' => 'Riwayat Gaji', 'route' => '#', 'active' => 'payroll-history.*', 'icon' => 'wallet'],
    ];
@endphp

<div x-data="{ open: false }" class="sidebar-wrapper">

    {{-- ====================================================
         MOBILE HAMBURGER BUTTON
    ==================================================== --}}
    <button @click="open = !open"
        class="fixed top-4 left-4 z-50 lg:hidden flex items-center justify-center w-10 h-10 rounded-xl text-white/80 hover:text-white transition-all duration-300"
        style="background: rgba(148,0,0,0.984); border: 1px solid rgba(139,92,246,0.25); backdrop-filter: blur(10px);"
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
        class="fixed inset-0 bg-black/50 z-30 lg:hidden" style="display:none; backdrop-filter: blur(4px);">
    </div>

    {{-- ====================================================
         SIDEBAR MAIN
    ==================================================== --}}
    <aside :class="open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="sidebar-container fixed top-0 left-0 h-screen z-40 w-64 flex flex-col transition-transform duration-300 ease-in-out sidebar-main">

        {{-- ------------------------------------------------
             BRAND / LOGO — sama semua role
        ------------------------------------------------ --}}
        <div class="flex items-center gap-3 px-5 py-4 shrink-0"
            style="border-bottom: 1px solid rgba(251,251,251,0.15);">
            <div class="w-9 h-9 rounded-xl shrink-0 flex items-center justify-center"
                style="background: linear-gradient(135deg, #87010e, #eb255d); box-shadow: 0 0 18px #eb255d;">
                <i data-lucide="graduation-cap" class="w-5 h-5 text-white"></i>
            </div>
            <div>
                <p class="text-[13px] font-bold tracking-wide">Ayumi Nihonggo Gakkou</p>
                <p class="text-xs opacity-70">Sistem Informasi Internal</p>
            </div>
        </div>
        <div class="mx-3 mt-4 mb-1 p-3 rounded-2xl flex items-center gap-3 shrink-0"
            style="background: rgba(233,233,233,0.07); border: 1px solid rgba(139,92,246,0.14);">
            <div class="w-8 h-8 rounded-full shrink-0 flex items-center justify-center text-xs font-bold text-white"
                style="background: linear-gradient(135deg, #87010e, #eb255d);">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-[12px] font-semibold truncate">{{ auth()->user()->name ?? 'User' }}</p>
                <p class="text-[11px] opacity-60 truncate">{{ $roleLabel }}</p>
            </div>
            <span class="w-2 h-2 rounded-full shrink-0"
                style="background: #34d399; box-shadow: 0 0 6px #34d399;"></span>
        </div>

        <nav class="flex-1 overflow-y-auto px-3 py-3 space-y-0.5 sidebar-scroll">

            {{-- ============================================
                 ADMIN
            ============================================ --}}
            @if ($isAdmin)

                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}"
                    class="sidebar-nav-item sub text-sm {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                    <span>Dashboard</span>
                </a>

                {{-- Manajemen Pengguna --}}
                <div>
                    <button
                        class="sidebar-group-label w-full flex items-center justify-between px-3 py-2 rounded-xl transition-all duration-200">
                        <div class="flex items-center gap-2 text-xs font-semibold uppercase">
                            <i data-lucide="contact-round" class="w-4 h-4"></i>
                            Manajemen Pengguna
                        </div>
                    </button>
                    <div class="ml-5 pl-3 mt-0.5 space-y-0.5 border-l border-gray-500">
                        @foreach ($userMenus as $menu)
                            <a href="{{ route($menu['route']) }}"
                                class="sidebar-nav-item sub {{ request()->routeIs($menu['active']) ? 'active' : '' }}">
                                <span class="nav-icon">
                                    <i data-lucide="{{ $menu['icon'] }}" class="w-4 h-4"></i>
                                </span>
                                {{ $menu['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Manajemen Akademik --}}
                <div>
                    <button
                        class="sidebar-group-label w-full flex items-center justify-between px-3 py-2 rounded-xl transition-all duration-200">
                        <div class="flex items-center gap-2 text-xs font-semibold uppercase">
                            <i data-lucide="university" class="w-4 h-4"></i>
                            Manajemen Akademik
                        </div>
                    </button>
                    <div class="ml-5 pl-3 mt-0.5 space-y-0.5 border-l border-gray-500">
                        @foreach ($academicMenus as $menu)
                            <a href="{{ route($menu['route']) }}"
                                class="sidebar-nav-item sub {{ request()->routeIs($menu['active']) ? 'active' : '' }}">
                                <span class="nav-icon">
                                    <i data-lucide="{{ $menu['icon'] }}" class="w-4 h-4"></i>
                                </span>
                                {{ $menu['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Kontrak & Gaji --}}
                <div>
                    <button
                        class="sidebar-group-label w-full flex items-center justify-between px-3 py-2 rounded-xl transition-all duration-200">
                        <div class="flex items-center gap-2 text-xs font-semibold uppercase">
                            <i data-lucide="wallet" class="w-4 h-4"></i>
                            Kontrak &amp; Gaji
                        </div>
                    </button>
                    <div class="ml-5 pl-3 mt-0.5 space-y-0.5 border-l border-gray-500">
                        @foreach ($contractPayrollMenus as $menu)
                            <a href="{{ route($menu['route']) }}"
                                class="sidebar-nav-item sub {{ request()->routeIs($menu['active']) ? 'active' : '' }}">
                                <span class="nav-icon">
                                    <i data-lucide="{{ $menu['icon'] }}" class="w-4 h-4"></i>
                                </span>
                                {{ $menu['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Laporan --}}
                <div>
                    <button
                        class="sidebar-group-label w-full flex items-center justify-between px-3 py-2 rounded-xl transition-all duration-200">
                        <div class="flex items-center gap-2 text-xs font-semibold uppercase">
                            <i data-lucide="clipboard-list" class="w-4 h-4"></i>
                            Laporan
                        </div>
                    </button>
                    <div class="ml-5 pl-3 mt-0.5 space-y-0.5 border-l border-gray-500">
                        @foreach ($reportMenus as $menu)
                            <a href="{{ route($menu['route']) }}"
                                class="sidebar-nav-item sub {{ request()->routeIs($menu['active']) ? 'active' : '' }}">
                                <span class="nav-icon">
                                    <i data-lucide="{{ $menu['icon'] }}" class="w-4 h-4"></i>
                                </span>
                                {{ $menu['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- ============================================
                 PENGAJAR
            ============================================ --}}
            @elseif($isPengajar)
                <a href="{{ route('pengajar.dashboard') }}"
                    class="sidebar-nav-item sub text-sm {{ request()->routeIs('pengajar.dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                    <span>Dashboard</span>
                </a>

                @foreach ($pengajarMenus as $menu)
                    <a href="{{ $menu['route'] }}"
                        class="sidebar-nav-item {{ request()->routeIs($menu['active']) ? 'active' : '' }}">
                        <span class="nav-icon">
                            <i data-lucide="{{ $menu['icon'] }}" class="w-4 h-4"></i>
                        </span>
                        <span>{{ $menu['label'] }}</span>
                    </a>
                @endforeach

                {{-- ============================================
                 STAFF
            ============================================ --}}
            @elseif($isStaff)
                <a href="{{ route('staff.dashboard') }}"
                    class="sidebar-nav-item sub text-sm {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                    <span>Dashboard</span>
                </a>
                {{-- Tambah menu staff di sini kalau sudah ada --}}

                {{-- ============================================
                 SISWA
            ============================================ --}}
            @elseif($isSiswa)
                <a href="{{ route('siswa.dashboard') }}"
                    class="sidebar-nav-item sub text-sm {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                    <span>Dashboard</span>
                </a>

            @endif

        </nav>

        {{-- ------------------------------------------------
             FOOTER / LOGOUT — sama semua role
        ------------------------------------------------ --}}
        <div class="px-3 pb-4 pt-3 shrink-0" style="border-top: 1px solid rgba(139,92,246,0.12);">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="sidebar-logout-btn w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all duration-200">
                    <i data-lucide="log-out" class="w-4 h-4 shrink-0"></i>
                    Keluar
                </button>
            </form>
        </div>

    </aside>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') lucide.createIcons();
    });
</script>
