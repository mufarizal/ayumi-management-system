@extends('layouts.app')
@section('title', $role ? 'Data ' . ucfirst($role) : 'Semua User')

@section('content')
    <div class="min-h-screen" style="background: linear-gradient(135deg, #fdf2f4, #f8fafc);">
        @include('components.sidebar')

        <div class="md:ml-64 p-8">

            {{-- HEADER --}}
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-[#111111] mb-2">
                            {{ $role ? 'Data ' . ucfirst($role) : 'Semua User' }}
                        </h1>
                        <p class="text-gray-600" id="total-count">
                            Total: {{ $users->total() }} pengguna
                        </p>
                    </div>

                    @if ($role)
                        <a href="{{ route('admin.users.create', $role) }}"
                            class="flex items-center space-x-2 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                            style="background: linear-gradient(to right, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="font-semibold">Tambah {{ ucfirst($role) }}</span>
                        </a>
                    @endif
                </div>
            </div>

            @if (session('success'))
                <div
                    class="mb-6 px-4 py-3 rounded-xl text-sm font-medium text-green-800 bg-green-100 border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex items-center gap-3 mb-6">
                <div class="relative flex-1 max-w-md">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" id="search-input" placeholder="Cari nama atau email..."
                        class="w-full pl-10 pr-4 py-3 rounded-xl text-sm border border-gray-200 focus:outline-none focus:border-[#87010e] bg-white shadow-sm transition-colors">
                </div>

                <button id="search-btn"
                    class="flex items-center space-x-2 text-white px-5 py-3 rounded-xl shadow-md hover:shadow-lg transition-all duration-200"
                    style="background: linear-gradient(to right, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span class="font-medium text-sm">Cari</span>
                </button>

                {{-- Tombol reset / clear search --}}
                <button id="clear-btn"
                    class="hidden items-center space-x-2 px-5 py-3 rounded-xl text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>Reset</span>
                </button>
            </div>

            {{-- TABEL --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

                <div class="px-6 py-4"
                    style="background: linear-gradient(to right, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                    <h2 class="text-xl font-bold text-white">
                        {{ $role ? 'Daftar ' . ucfirst($role) : 'Semua User' }}
                    </h2>
                    {{-- Loading indicator — muncul saat Ajax sedang berjalan --}}
                    <p id="search-status" class="text-white/70 text-sm mt-0.5 hidden">Mencari...</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead style="background: linear-gradient(to right, #6b0f1a, #8f1d2c);">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">#</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Nama</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Email</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Role</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="user-table-body" class="divide-y divide-gray-200">
                            @forelse($users as $i => $user)
                                <tr class="hover:bg-gray-50 transition-all duration-300">
                                    <td class="px-6 py-4 text-gray-900 font-medium">
                                        {{ $users->firstItem() + $i }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold text-white shrink-0"
                                                style="background: linear-gradient(135deg, #87010e, #eb255d);">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <span class="font-semibold text-gray-900">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium text-white"
                                            style="background: linear-gradient(to right, #87010e, #eb255d);">
                                            {{ ucfirst($user->roles->first()->name ?? '-') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
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
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                                class="p-2 rounded-lg text-gray-500 hover:text-white hover:bg-[#87010e] transition-all duration-200"
                                                title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.users.reset', $user) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="p-2 rounded-lg text-gray-500 hover:text-white hover:bg-blue-500 transition-all duration-200"
                                                    title="Reset Password">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                                    </svg>
                                                </button>
                                            </form>
                                            @if ($user->is_active)
                                                <form action="{{ route('admin.users.delete', $user) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2 rounded-lg text-gray-500 hover:text-white hover:bg-red-500 transition-all duration-200"
                                                        title="Nonaktifkan">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                        Tidak ada data
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination — disembunyikan saat mode search aktif --}}
                <div id="pagination-wrapper" class="px-6 py-4 border-t border-gray-200">
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
                    totalCount.textContent = `Total: ${data.users.length} pengguna`;

                    paginationWrapper.style.display = keyword ? 'none' : 'block';

                    renderTable(data.users);
                })
                .catch(() => {
                    searchStatus.classList.add('hidden');
                });
        }

        function renderTable(users) {
            if (users.length === 0) {
                tableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                        Tidak ada data yang cocok
                    </td>
                </tr>`;
                return;
            }

            tableBody.innerHTML = users.map((user, i) => `
            <tr class="hover:bg-gray-50 transition-all duration-300">
                <td class="px-6 py-4 text-gray-900 font-medium">${i + 1}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold text-white shrink-0"
                            style="background: linear-gradient(135deg, #87010e, #eb255d);">
                            ${user.name.charAt(0).toUpperCase()}
                        </div>
                        <span class="font-semibold text-gray-900">${user.name}</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-gray-600">${user.email}</td>
                <td class="px-6 py-4">
                    <span class="px-3 py-1 rounded-full text-xs font-medium text-white"
                        style="background: linear-gradient(to right, #87010e, #eb255d);">
                        ${user.role}
                    </span>
                </td>
                <td class="px-6 py-4">
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
                <td class="px-6 py-4">
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
