@extends('layouts.app')
@section('title', 'Data Pendaftaran')

@section('content')
    <div class="min-h-screen" style="background: linear-gradient(135deg, #fdf2f4, #f8fafc);">
        @include('components.sidebar')
        @include('components.alert')

        <div class="md:ml-64 p-4 md:p-8">

            {{-- HEADER --}}
            <div class="relative flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-3">
                    <div class="relative flex items-center justify-center w-12 h-12 outline outline-gray-400 rounded-2xl">
                        <i data-lucide="user-plus" class="w-5 h-5 text-gray-800"></i>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-0.5">Manajemen Akademik</p>
                        <h1 class="text-2xl font-bold text-gray-800 leading-tight">Data Pendaftaran</h1>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="text-right">
                        <p id="current-time" class="text-sm font-medium text-gray-400"></p>
                        <p id="current-date" class="text-sm font-medium text-gray-400 -mt-0.5"></p>
                    </div>

                    <div class="w-0.5 h-6 bg-gray-300 mx-4 hidden sm:block"></div>

                    <a href="{{ route('admin.pendaftaran.create') }}"
                        class="group relative inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-semibold overflow-hidden shadow-md transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 active:shadow-sm w-full sm:w-auto justify-center"
                        style="background: linear-gradient(135deg, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                        <i data-lucide="plus" class="w-4 h-4 transition-transform duration-300 group-hover:rotate-90"></i>
                        <span>Tambah Pendaftaran</span>
                    </a>
                </div>
            </div>

            <hr class="my-5 border-gray-200">

            {{-- PENCARIAN --}}
            <form method="GET" action="{{ route('admin.pendaftaran.index') }}"
                class="flex mb-5 flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                <div class="flex w-full flex-col gap-3 sm:flex-row sm:items-center">
                    <div class="relative w-full sm:max-w-md">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama atau email pendaftar..."
                            class="w-full px-5 pr-4 py-3 rounded-xl text-sm border border-gray-200 focus:outline-none focus:border-[#87010e] bg-white shadow-sm transition-colors">
                    </div>

                    <button type="submit"
                        class="flex items-center justify-center space-x-2 text-white px-5 py-3 rounded-xl shadow-md hover:shadow-lg transition-all duration-200"
                        style="background: linear-gradient(to right, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                        <i data-lucide="search" class="w-4 h-4"></i>
                        <span class="font-medium text-sm">Cari</span>
                    </button>

                    @if (request('search'))
                        <a href="{{ route('admin.pendaftaran.index') }}"
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
                    <h2 class="text-xl font-bold text-white">Daftar Pendaftaran</h2>
                    <span class="text-gray-200 text-sm">Total: {{ $pendaftarans->count() }}</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full" style="min-width: 1000px;">
                        <thead style="background: linear-gradient(to right, #6b0f1a, #8f1d2c);">
                            <tr>
                                <th class="px-3 md:px-6 py-4 text-left text-sm font-semibold text-white">#</th>
                                <th class="px-3 md:px-6 py-4 text-left text-sm font-semibold text-white">Nama</th>
                                <th class="px-3 md:px-6 py-4 text-left text-sm font-semibold text-white">Email</th>
                                <th class="px-3 md:px-6 py-4 text-left text-sm font-semibold text-white">No. Telp</th>
                                <th class="px-3 md:px-6 py-4 text-left text-sm font-semibold text-white">Institusi</th>
                                <th class="px-3 md:px-6 py-4 text-left text-sm font-semibold text-white">Program</th>
                                <th class="px-3 md:px-6 py-4 text-left text-sm font-semibold text-white">Kelas</th>
                                <th class="px-3 md:px-6 py-4 text-left text-sm font-semibold text-white">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($pendaftarans as $i => $p)
                                <tr class="hover:bg-gray-50 transition-all duration-300">
                                    <td class="px-3 md:px-6 py-4 text-gray-500 font-medium whitespace-nowrap">
                                        {{ $i + 1 }}
                                    </td>
                                    <td class="px-3 md:px-6 py-4" style="min-width: 180px;">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold text-white shrink-0"
                                                style="background: linear-gradient(135deg, #87010e, #eb255d);">
                                                {{ strtoupper(substr($p->nama, 0, 1)) }}
                                            </div>
                                            <span class="font-semibold text-gray-900">{{ $p->nama }}</span>
                                        </div>
                                    </td>
                                    <td class="px-3 md:px-6 py-4 text-gray-600 whitespace-nowrap">{{ $p->email }}</td>
                                    <td class="px-3 md:px-6 py-4 text-gray-600 whitespace-nowrap">{{ $p->no_telp }}</td>
                                    <td class="px-3 md:px-6 py-4 text-gray-600 whitespace-nowrap">{{ $p->institusi }}</td>
                                    <td class="px-3 md:px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium text-white"
                                            style="background: linear-gradient(to right, #87010e, #eb255d);">
                                            <i data-lucide="layers" class="w-3 h-3"></i>
                                            {{ $p->program->nama_program ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-3 md:px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                            <i data-lucide="school" class="w-3 h-3"></i>
                                            {{ $p->kelas->nama_kelas ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-3 md:px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.pendaftaran.edit', $p->id) }}"
                                                class="p-2 rounded-lg text-gray-500 hover:text-white hover:bg-green-500 transition-all duration-200"
                                                title="Edit">
                                                <i data-lucide="edit" class="w-4 h-4"></i>
                                            </a>
                                            <form action="{{ route('admin.pendaftaran.destroy', $p->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus pendaftaran {{ addslashes($p->nama) }}?')">
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
                                    <td colspan="8" class="px-3 md:px-6 py-12 text-center text-gray-400">
                                        @if (request('search'))
                                            Tidak ada pendaftaran yang cocok
                                        @else
                                            Tidak ada data pendaftaran
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- tidak ada pagination karena controller pakai ->get() --}}

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
