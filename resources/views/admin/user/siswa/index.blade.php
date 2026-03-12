@extends('layouts.app')
@section('title', 'Data Siswa')
@section('content')
    <div class="min-h-screen" style="background: linear-gradient(135deg, #fdf2f4, #f8fafc);">
        @include('components.sidebar')
        @include('components.alert')
        <div class="md:ml-64 p-4 md:p-8">

            {{-- Header --}}
            <div class="">
                <div class="relative flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    {{-- Title Group --}}
                    <div class="flex items-center gap-3 ">
                        {{-- Pulse indicator --}}
                        <div
                            class="relative flex items-center justify-center w-12 h-12  outline outline-gray-400 rounded-2xl">
                            <i data-lucide="book-open" class="w-5 h-5 text-gray-800"></i>
                        </div>

                        {{-- Title & breadcrumb --}}
                        <div>
                            <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-0.5">Manajemen Pengguna
                            </p>
                            <h1 class="text-2xl font-bold text-gray-800 leading-tight">
                                Data Siswa
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
                        <a href="{{ route('admin.siswa.create') }}"
                            class="group relative inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-semibold overflow-hidden shadow-md transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 active:shadow-sm w-full sm:w-auto justify-center"
                            style="background: linear-gradient(135deg, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">


                            {{-- Icon with subtle spin on hover --}}
                            <i data-lucide="plus"
                                class="w-4 h-4 transition-transform duration-300 group-hover:rotate-90"></i>
                            <span>Tambah Siswa</span>
                        </a>
                    </div>
                </div>
            </div>
            {{-- Header --}}

            <hr class="my-5 border-gray-200">

            {{-- Content --}}
            <div class="mb-5 flex justify-between items-center p-5 bg-white rounded-2xl shadow-lg border border-gray-200">
                {{-- Search --}}
                <div class="w-1/3">
                    <input type="text" id="search-input" placeholder="Cari nama atau email..."
                        class="w-full px-5 pr-4 py-3 rounded-full text-sm border border-gray-200  bg-white shadow-sm transition-colors">
                </div>
                {{-- Export Button --}}
                <div>
                    <a href=""
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-full text-sm font-semibold border border-gray-300 text-gray-700  transition-colors">
                        <i data-lucide="file-text" class="w-4 h-4"></i>
                        Export Data
                    </a>
                </div>
            </div>
            {{-- Content --}}

            {{-- TABEL --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

                <div class="px-6 py-4"
                    style="background: linear-gradient(to right, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                    <h2 class="text-xl font-bold text-white">
                        Daftar siswa
                    </h2>
                    {{-- <span class="text-gray-200 text-sm" id="total-count">Total: </span> --}}
                    {{-- Loading indicator — muncul saat Ajax sedang berjalan --}}
                    <p id="search-status" class="text-white/70 text-sm mt-0.5 hidden">Mencari...</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full" style="min-width: 920px;">
                        <thead style="background: linear-gradient(to right, #6b0f1a, #8f1d2c);">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">#</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Nama</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Email</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">No Telp</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Institusi</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($siswa as $index => $siswa)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-800">
                                        {{ $siswa->user->name }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $siswa->user->email }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $siswa->no_telp ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $siswa->nama_institusi ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($siswa->user->is_active)
                                            <span
                                                class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                                Aktif
                                            </span>
                                        @else
                                            <span
                                                class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 flex items-center gap-2">
                                        {{-- VIEW --}}
                                        {{-- <a href="{{ route('admin.siswa.show', encrypt($siswa->id)) }}"
                                            class="p-2 rounded-lg text-gray-500 hover:text-white hover:bg-blue-500 transition-all duration-200"
                                            title="Lihat">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a> --}}
                                        {{-- EDIT --}}
                                        <a href="{{ route('admin.siswa.edit', encrypt($siswa->id)) }}"
                                            class="p-2 rounded-lg text-gray-500 hover:text-white hover:bg-green-500 transition-all duration-200"
                                            title="Edit">
                                            <i data-lucide="edit" class="w-4 h-4"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada data siswa.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination — disembunyikan saat mode search aktif --}}
                <div id="pagination-wrapper" class="px-3 md:px-6 py-4 border-t border-gray-200 overflow-x-auto">
                    {{-- {{ $users->links() }} --}}
                </div>

            </div>
            {{-- End: Table --}}
        </div>
    </div>
@endsection
