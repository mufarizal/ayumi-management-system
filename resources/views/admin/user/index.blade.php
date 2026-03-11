@extends('layouts.app')
@section('title', $role ? 'Data ' . ucfirst($role) : 'Semua User')

@section('content')
    <div class="min-h-screen" style="background: linear-gradient(135deg, #fdf2f4, #f8fafc);">
        @include('components.sidebar')
        @include('components.alert')

        <div class="md:ml-64 p-4 md:p-8">

            {{-- HEADER --}}
            <div class="">
                <div class="relative flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    {{-- Title Group --}}
                    <div class="flex items-center gap-3 ">
                        {{-- Pulse indicator --}}
                        <div
                            class="relative flex items-center justify-center w-12 h-12  outline outline-gray-400 rounded-2xl">
                            @php
                                $roleIcons = [
                                    'admin' => 'shield-check',
                                    'pengajar' => 'graduation-cap',
                                    'staff' => 'briefcase',
                                    'siswa' => 'book-open',
                                ];

                                $icon = $roleIcons[$role] ?? 'users';
                            @endphp

                            <i data-lucide="{{ $icon }}" class="w-5 h-5 text-gray-800"></i>
                        </div>

                        {{-- Title & breadcrumb --}}
                        <div>
                            <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-0.5">Manajemen Pengguna
                            </p>
                            <h1 class="text-2xl font-bold text-gray-800 leading-tight">
                                {{ $role ? 'Data ' . ucfirst($role) : 'Semua User' }}
                            </h1>
                        </div>
                    </div>

                    <div class="flex items-center gap--2">
                        <div class="text-right">
                            <p id="greeting" class="text-sm font-medium text-gray-600 mb-0.5 hidden">Selamat Datang</p>
                            <p id="current-time" class="text-sm font-medium text-gray-400"></p>
                            <p id="current-date" class="text-sm font-medium text-gray-400 -mt-0.5"></p>
                            {{-- <span class="text-black font-semibold" id="total-count">{{ $users->total() }}</span> --}}

                        </div>

                        <div class="w-0.5 h-6 bg-gray-300 mx-4 hidden sm:block">

                        </div>

                        {{-- Action Button --}}
                        @if ($role)
                            <a href="{{ route('admin.users.create', $role) }}"
                                class="group relative inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-semibold overflow-hidden shadow-md transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 active:shadow-sm w-full sm:w-auto justify-center"
                                style="background: linear-gradient(135deg, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">


                                {{-- Icon with subtle spin on hover --}}
                                <i data-lucide="plus"
                                    class="w-4 h-4 transition-transform duration-300 group-hover:rotate-90"></i>
                                <span>Tambah Data</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <hr class="my-5 border-gray-200">

            {{-- PENCARIAN --}}
            <div class="flex mb-5 flex-col gap-4 xl:flex-row xl:items-center xl:justify-between ">
                <div class="flex w-full flex-col gap-3 sm:flex-row sm:items-center">
                    <div class="relative w-full sm:max-w-md">
                        {{-- <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i> --}}
                        <input type="text" id="search-input" placeholder="Cari nama atau email..."
                            class="w-full px-5 pr-4 py-3 rounded-xl text-sm border border-gray-200 focus:outline-none focus:border-[#87010e] bg-white shadow-sm transition-colors">
                    </div>

                    <button id="search-btn"
                        class="flex items-center justify-center space-x-2 text-white px-5 py-3 rounded-xl shadow-md hover:shadow-lg transition-all duration-200"
                        style="background: linear-gradient(to right, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                        <i data-lucide="search" class="w-4 h-4"></i>
                        <span class="font-medium text-sm">Cari</span>
                    </button>

                    {{-- Tombol reset / clear search --}}
                    <button id="clear-btn"
                        class="hidden items-center justify-center space-x-2 px-5 py-3 rounded-xl text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 transition-all duration-200">
                        <i data-lucide="x" class="w-4 h-4"></i>
                        <span>Reset</span>
                    </button>
                </div>
            </div>

            {{-- TABEL --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

                <div class="px-6 py-4"
                    style="background: linear-gradient(to right, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                    <h2 class="text-xl font-bold text-white">
                        {{ $role ? 'Daftar ' . ucfirst($role) : 'Semua User' }}
                    </h2>
                    <span class="text-gray-200 text-sm" id="total-count">Total: {{ $users->total() }}</span>
                    {{-- Loading indicator — muncul saat Ajax sedang berjalan --}}
                    <p id="search-status" class="text-white/70 text-sm mt-0.5 hidden">Mencari...</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full" style="min-width: 920px;">
                        <thead style="background: linear-gradient(to right, #6b0f1a, #8f1d2c);">
                            <tr>
                                <th class="px-3 md:px-6 py-4 text-left text-sm font-semibold text-white">#</th>
                                <th class="px-3 md:px-6 py-4 text-left text-sm font-semibold text-white">Nama</th>
                                <th class="px-3 md:px-6 py-4 text-left text-sm font-semibold text-white">Email</th>
                                <th class="px-3 md:px-6 py-4 text-left text-sm font-semibold text-white">Role</th>
                                <th class="px-3 md:px-6 py-4 text-left text-sm font-semibold text-white">Status</th>
                                {{-- <th class="px-3 md:px-6 py-4 text-left text-sm font-semibold text-white">Created At</th> --}}
                                <th class="px-3 md:px-6 py-4 text-left text-sm font-semibold text-white">Dibuat oleh</th>
                                <th class="px-3 md:px-6 py-4 text-left text-sm font-semibold text-white">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="user-table-body" class="divide-y divide-gray-200">
                            @forelse($users as $i => $user)
                                <tr class="hover:bg-gray-50 transition-all duration-300">
                                    <td class="px-3 md:px-6 py-4 text-gray-500 font-medium whitespace-nowrap">
                                        {{ $users->firstItem() + $i }}
                                    </td>
                                    <td class="px-3 md:px-6 py-4" style="min-width: 200px;">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold text-white shrink-0"
                                                style="background: linear-gradient(135deg, #87010e, #eb255d);">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <span class="font-semibold text-gray-900">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-3 md:px-6 py-4 text-gray-600 whitespace-nowrap">{{ $user->email }}</td>
                                    <td class="px-3 md:px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($user->roles as $r)
                                                <span
                                                    class="flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium text-white"
                                                    style="background: linear-gradient(to right, #87010e, #eb255d);">
                                                    {{ ucfirst($r->name) }}
                                                    @if ($user->default_role === $r->name)
                                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-300 shrink-0"
                                                            title="Default"></span>
                                                    @endif
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-3 md:px-6 py-4 whitespace-nowrap">
                                        @if ($user->is_active)
                                            <div class="flex items-center space-x-2">
                                                <div class="w-2.5 h-2.5 bg-green-400 rounded-full animate-pulse"></div>
                                                <span class="text-sm font-medium text-green-600">Aktif</span>
                                            </div>
                                        @else
                                            <div class="flex items-center space-x-2">
                                                <div class="w-2.5 h-2.5 bg-gray-300 rounded-full"></div>
                                                <span class="text-sm font-medium text-gray-400">Nonaktif</span>
                                            </div>
                                        @endif
                                    </td>
                                    {{-- <td class="px-3 md:px-6 py-4 text-gray-600 whitespace-nowrap">
                                        {{ optional($user->created_at)->format('d M Y H:i') ?? '-' }}
                                    </td> --}}
                                    <td class="px-3 md:px-6 py-4 text-gray-600 whitespace-nowrap">
                                        {{ $user->creator?->name ?? '-' }}
                                    </td>
                                    <td class="px-3 md:px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                                class="p-2 rounded-lg text-gray-500 hover:text-white hover:bg-green-500 transition-all duration-200"
                                                title="Edit">
                                                <i data-lucide="edit" class="w-4 h-4"></i>
                                            </a>
                                            <form action="{{ route('admin.users.reset', $user) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="p-2 rounded-lg text-gray-500 hover:text-white hover:bg-blue-500 transition-all duration-200"
                                                    title="Reset Password">
                                                    <i data-lucide="key-round" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                            @if ($user->is_active)
                                                <form action="{{ route('admin.users.delete', $user) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2 rounded-lg text-gray-500 hover:text-white hover:bg-red-500 transition-all duration-200"
                                                        title="Nonaktifkan">
                                                        <i data-lucide="user-minus" class="w-4 h-4"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-3 md:px-6 py-12 text-center text-gray-400">
                                        Tidak ada data
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination — disembunyikan saat mode search aktif --}}
                <div id="pagination-wrapper" class="px-3 md:px-6 py-4 border-t border-gray-200 overflow-x-auto">
                    {{ $users->links() }}
                </div>

            </div>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('search-input');
        const searchBtn = document.getElementById('search-btn');
        const clearBtn = document.getElementById('clear-btn');
        const tableBody = document.getElementById('user-table-body');
        const searchStatus = document.getElementById('search-status');
        const totalCount = document.getElementById('total-count');
        const paginationWrapper = document.getElementById('pagination-wrapper');

        const currentRole = "{{ $role ?? '' }}";

        const searchUrl = "{{ route('admin.users.search') }}";
        const csrfToken = "{{ csrf_token() }}";

        let debounceTimer = null;

        function doSearch(keyword) {
            searchStatus.classList.remove('hidden');

            const params = new URLSearchParams({
                q: keyword,
                role: currentRole
            });

            fetch(`${searchUrl}?${params}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken,
                    }
                })
                .then(res => res.json())
                .then(data => {
                    searchStatus.classList.add('hidden');
                    totalCount.textContent = `Total: ${data.users.length}`;

                    paginationWrapper.style.display = keyword ? 'none' : 'block';

                    renderTable(data.users);
                })
                .catch(() => {
                    searchStatus.classList.add('hidden');
                });
        }

        // Clock & Greeting Functions
        function updateGreeting() {
            const hour = new Date().getHours();
            let greeting = '';

            if (hour >= 5 && hour < 12) greeting = 'Selamat Pagi';
            else if (hour >= 12 && hour < 15) greeting = 'Selamat Siang';
            else if (hour >= 15 && hour < 18) greeting = 'Selamat Sore';
            else greeting = 'Selamat Malam';

            document.getElementById('greeting').textContent = greeting;
        }

        function updateClock() {
            const now = new Date();

            // Time
            const timeStr = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('current-time').textContent = timeStr;

            // Date
            const dateStr = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
            document.getElementById('current-date').textContent = dateStr;
        }

        // Initialize Clock
        updateGreeting();
        updateClock();
        setInterval(updateClock, 1000);
        setInterval(updateGreeting, 60000);

        function renderTable(users) {
            if (users.length === 0) {
                tableBody.innerHTML = `
                <tr>
                    <td colspan="8" class="px-3 md:px-6 py-12 text-center text-gray-400">
                        Tidak ada data yang cocok
                    </td>
                </tr>`;
                return;
            }

            tableBody.innerHTML = users.map((user, i) => `
            <tr class="hover:bg-gray-50 transition-all duration-300">
                <td class="px-3 md:px-6 py-4 text-gray-900 font-medium whitespace-nowrap">${i + 1}</td>
                <td class="px-3 md:px-6 py-4" style="min-width: 200px;">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold text-white shrink-0"
                            style="background: linear-gradient(135deg, #87010e, #eb255d);">
                            ${user.name.charAt(0).toUpperCase()}
                        </div>
                        <span class="font-semibold text-gray-900">${user.name}</span>
                    </div>
                </td>
                <td class="px-3 md:px-6 py-4 text-gray-600 whitespace-nowrap">${user.email}</td>
                <td class="px-3 md:px-6 py-4">
                    <span class="px-3 py-1 rounded-full text-xs font-medium text-white"
                        style="background: linear-gradient(to right, #87010e, #eb255d);">
                        ${user.roles}
                    </span>
                </td>
                <td class="px-3 md:px-6 py-4 whitespace-nowrap">
                    ${user.is_active
                        ? `<div class="flex items-center space-x-2">
                                                                                                                <div class="w-2.5 h-2.5 bg-green-400 rounded-full animate-pulse"></div>
                                                                                                                <span class="text-sm font-medium text-green-600">Aktif</span>
                                                                                                            </div>`
                        : `<div class="flex items-center space-x-2">
                                                                                                                <div class="w-2.5 h-2.5 bg-gray-300 rounded-full"></div>
                                                                                                                <span class="text-sm font-medium text-gray-400">Nonaktif</span>
                                                                                                            </div>`
                    }
                </td>
                <td class="px-3 md:px-6 py-4 text-gray-600 whitespace-nowrap">${user.created_at ?? '-'}</td>
                <td class="px-3 md:px-6 py-4 text-gray-600 whitespace-nowrap">${user.created_by ?? '-'}</td>
                <td class="px-3 md:px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center space-x-2">
                        <a href="${user.edit_url}"
                            class="p-2 rounded-lg text-gray-500 hover:text-white hover:bg-[#87010e] transition-all duration-200" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                        <form action="${user.reset_url}" method="POST">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <button type="submit"
                                class="p-2 rounded-lg text-gray-500 hover:text-white hover:bg-blue-500 transition-all duration-200" title="Reset Password">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                            </button>
                        </form>
                        ${user.is_active ? `
                                                                                                            <form action="${user.delete_url}" method="POST">
                                                                                                                <input type="hidden" name="_token" value="${csrfToken}">
                                                                                                                <input type="hidden" name="_method" value="DELETE">
                                                                                                                <button type="submit"
                                                                                                                    class="p-2 rounded-lg text-gray-500 hover:text-white hover:bg-red-500 transition-all duration-200" title="Nonaktifkan">
                                                                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                                                                            d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6" />
                                                                                                                    </svg>
                                                                                                                </button>
                                                                                                            </form>` : ''
                        }
                    </div>
                </td>
            </tr>
        `).join('');
        }
        searchInput.addEventListener('input', function() {
            const keyword = this.value.trim();

            clearBtn.classList.toggle('hidden', keyword === '');
            clearBtn.classList.toggle('flex', keyword !== '');

            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                doSearch(keyword);
            }, 300);
        });

        searchBtn.addEventListener('click', function() {
            clearTimeout(debounceTimer);
            doSearch(searchInput.value.trim());
        });

        clearBtn.addEventListener('click', function() {
            searchInput.value = '';
            clearBtn.classList.add('hidden');
            clearBtn.classList.remove('flex');
            doSearch('');
        });
    </script>
@endsection
