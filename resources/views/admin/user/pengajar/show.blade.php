@extends('layouts.app')
@section('title', 'Detail Pengajar')

@section('content')

    <div class="min-h-screen" style="background: linear-gradient(135deg,#fdf2f4,#f8fafc);">

        @include('components.sidebar')
        @include('components.alert')

        <div class="md:ml-64 p-4 md:p-8">

            {{-- HEADER --}}
            <div class="flex items-center justify-between mb-6">

                <div class="flex items-center gap-3">

                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center border border-gray-300">
                        <i data-lucide="graduation-cap" class="w-5 h-5 text-gray-700"></i>
                    </div>

                    <div>
                        <p class="text-xs uppercase tracking-widest text-gray-400">Manajemen Pengguna</p>
                        <h1 class="text-2xl font-bold text-gray-800">Detail Pengajar</h1>
                    </div>
                </div>
                <div class="text-right">
                    <p id="greeting" class="text-sm font-medium text-gray-600 mb-0.5 hidden">Selamat Datang</p>
                    <p id="current-time" class="text-sm font-medium text-gray-400"></p>
                    <p id="current-date" class="text-sm font-medium text-gray-400 -mt-0.5"></p>
                    {{-- <span class="text-black font-semibold" id="total-count">{{ $users->total() }}</span> --}}

                </div>
            </div>

            <hr class="mb-6 border-gray-200">

            {{-- Crumbs --}}
            <nav class="text-sm mb-6" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex">
                    <li class="flex items-center">
                        <a href="{{ route('admin.pengajar.index') }}" class="text-gray-500 hover:text-gray-700">Pengajar</a>
                        <svg class="w-3 h-3 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </li>
                    <li class="flex items-center">
                        <span class="text-gray-500">Detail Pengajar</span>
                    </li>
                </ol>
            </nav>

            {{-- CARD DETAIL --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

                <div class="px-6 py-4"
                    style="background: linear-gradient(to right, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                    <h2 class="text-xl font-bold text-white">Informasi Pengajar</h2>
                </div>


                <div class="p-6 grid md:grid-cols-2 gap-6">


                    {{-- NAMA --}}
                    <div>
                        <p class="text-sm text-gray-400 mb-1">Nama</p>
                        <p class="font-semibold text-gray-800">
                            {{ $pengajar->user->name }}
                        </p>
                    </div>


                    {{-- EMAIL --}}
                    <div>
                        <p class="text-sm text-gray-400 mb-1">Email</p>
                        <p class="font-semibold text-gray-800">
                            {{ $pengajar->user->email }}
                        </p>
                    </div>


                    {{-- TELEPON --}}
                    <div>
                        <p class="text-sm text-gray-400 mb-1">Nomor Telepon</p>
                        <p class="font-semibold text-gray-800">
                            {{ $pengajar->no_telp ?? '-' }}
                        </p>
                    </div>


                    {{-- STATUS --}}
                    <div>
                        <p class="text-sm text-gray-400 mb-1">Status</p>

                        @if ($pengajar->is_active)
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                Aktif
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                Nonaktif
                            </span>
                        @endif

                    </div>


                    {{-- BANK --}}
                    <div>
                        <p class="text-sm text-gray-400 mb-1">Nama Bank</p>
                        <p class="font-semibold text-gray-800">
                            {{ $pengajar->nama_bank ?? '-' }}
                        </p>
                    </div>


                    {{-- REKENING --}}
                    <div>
                        <p class="text-sm text-gray-400 mb-1">Nomor Rekening</p>
                        <p class="font-semibold text-gray-800">
                            {{ $pengajar->no_rekening ?? '-' }}
                        </p>
                    </div>


                    {{-- ALAMAT --}}
                    <div class="">
                        <p class="text-sm text-gray-400 mb-1">Alamat</p>
                        <p class="font-semibold text-gray-800">
                            {{ $pengajar->alamat ?? '-' }}
                        </p>
                    </div>

                    {{-- Level Bahasa --}}
                    <div>
                        <p class="text-sm text-gray-400 mb-1">Level Bahasa</p>
                        <p class="font-semibold text-gray-800">
                            {{ $pengajar->level_bahasa ?? '-' }}
                        </p>
                    </div>

                    {{-- SERTIFIKAT --}}
                    <div class="">

                        <p class="text-sm text-gray-400 mb-2">Sertifikat</p>
                        {{-- <img src="{{ asset('storage/' . $pengajar->sertifikat) }}" alt="Sertifikat"
                            class="max-w-full h-auto rounded-lg shadow"> --}}
                        @if ($pengajar->sertifikat)
                            <a href="{{ asset('storage/' . $pengajar->sertifikat) }}" target="_blank"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-white shadow hover:shadow-md"
                                style="background: linear-gradient(135deg,var(--color-accent-gradient-1),var(--color-accent-gradient-2));">

                                <i data-lucide="file-text" class="w-4 h-4"></i>
                                Lihat Sertifikat

                            </a>
                        @else
                            <span class="text-gray-400 text-sm">
                                Tidak ada sertifikat
                            </span>
                        @endif

                    </div>


                </div>
            </div>


            {{-- ACTION BUTTON --}}
            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.pengajar.index') }}"
                    class="px-6 py-3 rounded-xl text-sm font-semibold text-gray-700 border border-gray-300 hover:bg-gray-100 transition">
                    Kembali
                </a>

                <a href="{{ route('admin.pengajar.edit', encrypt($pengajar->id)) }}"
                    class="px-6 py-3 rounded-xl text-sm font-semibold text-white shadow-md hover:shadow-lg transition"
                    style="background: linear-gradient(135deg,var(--color-accent-gradient-1),var(--color-accent-gradient-2));">

                    Edit Data

                </a>

            </div>


        </div>
    </div>

@endsection
