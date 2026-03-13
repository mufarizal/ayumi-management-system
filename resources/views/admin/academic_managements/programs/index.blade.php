@extends('layouts.app')
@section('title', 'Data Program')

@section('content')
    <div class="min-h-screen" style="background: linear-gradient(135deg, #fdf2f4, #f8fafc);">
        @include('components.sidebar')
        @include('components.alert')

        <div class="md:ml-64 p-4 md:p-8">

            {{-- HEADER --}}
            <div class="relative flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                {{-- Title Group --}}
                <div class="flex items-center gap-3">
                    <div class="relative flex items-center justify-center w-12 h-12 outline outline-gray-400 rounded-2xl">
                        <i data-lucide="layers" class="w-5 h-5 text-gray-800"></i>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-0.5">Manajemen Akademik</p>
                        <h1 class="text-2xl font-bold text-gray-800 leading-tight">Data Program</h1>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="text-right">
                        <p id="current-time" class="text-sm font-medium text-gray-400"></p>
                        <p id="current-date" class="text-sm font-medium text-gray-400 -mt-0.5"></p>
                    </div>

                    <div class="w-0.5 h-6 bg-gray-300 mx-4 hidden sm:block"></div>

                    <a href="{{ route('admin.program.create') }}"
                        class="group relative inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-semibold overflow-hidden shadow-md transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 active:shadow-sm w-full sm:w-auto justify-center"
                        style="background: linear-gradient(135deg, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                        <i data-lucide="plus" class="w-4 h-4 transition-transform duration-300 group-hover:rotate-90"></i>
                        <span>Tambah Program</span>
                    </a>
                </div>
            </div>

            <hr class="my-5 border-gray-200">

            {{-- PENCARIAN --}}
            <form method="GET" action="{{ route('admin.program.index') }}"
                class="flex mb-5 flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                <div class="flex w-full flex-col gap-3 sm:flex-row sm:items-center">
                    <div class="relative w-full sm:max-w-md">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama atau deskripsi program..."
                            class="w-full px-5 pr-4 py-3 rounded-xl text-sm border border-gray-200 focus:outline-none focus:border-[#87010e] bg-white shadow-sm transition-colors">
                    </div>

                    <select name="status"
                        class="px-4 py-3 rounded-xl text-sm border border-gray-200 focus:outline-none focus:border-[#87010e] bg-white shadow-sm transition-colors text-gray-600 min-w-[150px]">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>

                    <button type="submit"
                        class="flex items-center justify-center space-x-2 text-white px-5 py-3 rounded-xl shadow-md hover:shadow-lg transition-all duration-200"
                        style="background: linear-gradient(to right, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                        <i data-lucide="search" class="w-4 h-4"></i>
                        <span class="font-medium text-sm">Cari</span>
                    </button>

                    @if (request('search') || request('status'))
                        <a href="{{ route('admin.program.index') }}"
                            class="flex items-center justify-center space-x-2 px-5 py-3 rounded-xl text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 transition-all duration-200">
                            <i data-lucide="x" class="w-4 h-4"></i>
                            <span>Reset</span>
                        </a>
                    @endif
                </div>
            </form>

            {{-- TABEL --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

                <div class="px-6 py-4"
                    style="background: linear-gradient(to right, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                    <h2 class="text-xl font-bold text-white">Daftar Program</h2>
                    <span class="text-gray-200 text-sm">Total: {{ $programs->total() }}</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full" style="min-width: 800px;">
                        <thead style="background: linear-gradient(to right, #6b0f1a, #8f1d2c);">
                            <tr>
                                <th class="px-3 md:px-6 py-4 text-left text-sm font-semibold text-white">#</th>
                                <th class="px-3 md:px-6 py-4 text-left text-sm font-semibold text-white">Nama Program</th>
                                <th class="px-3 md:px-6 py-4 text-left text-sm font-semibold text-white">Harga</th>
                                <th class="px-3 md:px-6 py-4 text-left text-sm font-semibold text-white">Deskripsi</th>
                                <th class="px-3 md:px-6 py-4 text-left text-sm font-semibold text-white">Status</th>
                                <th class="px-3 md:px-6 py-4 text-left text-sm font-semibold text-white">Kelas</th>
                                <th class="px-3 md:px-6 py-4 text-left text-sm font-semibold text-white">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($programs as $i => $program)
                                <tr class="hover:bg-gray-50 transition-all duration-300">
                                    <td class="px-3 md:px-6 py-4 text-gray-500 font-medium whitespace-nowrap">
                                        {{ $programs->firstItem() + $i }}
                                    </td>
                                    <td class="px-3 md:px-6 py-4" style="min-width: 200px;">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0"
                                                style="background: linear-gradient(135deg, #87010e20, #eb255d20);">
                                                <i data-lucide="layers" class="w-4 h-4" style="color:#87010e"></i>
                                            </div>
                                            <span class="font-semibold text-gray-900">{{ $program->nama_program }}</span>
                                        </div>
                                    </td>
                                    <td class="px-3 md:px-6 py-4 text-gray-700 font-semibold whitespace-nowrap">
                                        Rp {{ number_format($program->harga, 0, ',', '.') }}
                                    </td>
                                    <td class="px-3 md:px-6 py-4 text-gray-500 max-w-xs">
                                        <span class="line-clamp-2">{{ $program->deskripsi ?? '-' }}</span>
                                    </td>
                                    <td class="px-3 md:px-6 py-4 whitespace-nowrap">
                                        @if ($program->status === 'aktif')
                                            <div class="flex items-center space-x-2">
                                                <div class="w-2.5 h-2.5 bg-green-400 rounded-full animate-pulse"></div>
                                                <span class="text-sm font-medium text-green-600">Aktif</span>
                                            </div>
                                        @else
                                            <div class="flex items-center space-x-2">
                                                <div class="w-2.5 h-2.5 bg-red-300 rounded-full"></div>
                                                <span class="text-sm font-medium text-red-500">Nonaktif</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-3 md:px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 text-gray-600">
                                            <i data-lucide="school" class="w-3 h-3"></i>
                                            {{ $program->kelas->count() }} kelas
                                        </span>
                                    </td>
                                    <td class="px-3 md:px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.program.edit', $program) }}"
                                                class="p-2 rounded-lg text-gray-500 hover:text-white hover:bg-green-500 transition-all duration-200"
                                                title="Edit">
                                                <i data-lucide="edit" class="w-4 h-4"></i>
                                            </a>
                                            <form action="{{ route('admin.program.destroy', $program) }}" method="POST"
                                                onsubmit="return confirm('Hapus program {{ addslashes($program->nama_program) }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 rounded-lg text-gray-500 hover:text-white hover:bg-red-500 transition-all duration-200"
                                                    title="Hapus">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-3 md:px-6 py-12 text-center text-gray-400">
                                        @if (request('search') || request('status'))
                                            Tidak ada program yang cocok
                                        @else
                                            Tidak ada data program
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-3 md:px-6 py-4 border-t border-gray-200 overflow-x-auto">
                    {{ $programs->links() }}
                </div>

            </div>
        </div>
    </div>

    <script>
        (function clock() {
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

            function tick() {
                const now = new Date();
                const hh = String(now.getHours()).padStart(2, '0');
                const mm = String(now.getMinutes()).padStart(2, '0');
                const ss = String(now.getSeconds()).padStart(2, '0');
                document.getElementById('current-time').textContent = `${hh}:${mm}:${ss}`;
                document.getElementById('current-date').textContent =
                    `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
            }
            tick();
            setInterval(tick, 1000);
        })();

        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    </script>
@endsection
