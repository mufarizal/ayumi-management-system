@extends('layouts.app')
@section('title', 'Detail Staff')

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
                        <h1 class="text-2xl font-bold text-gray-800">Detail Staff</h1>
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
                        <a href="{{ route('admin.staff.index') }}" class="text-gray-500 hover:text-gray-700"></a>
                        <svg class="w-3 h-3 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </li>
                    <li class="flex items-center">
                        <span class="text-gray-500">Detail staff</span>
                    </li>
                </ol>
            </nav>

            {{-- CARD DETAIL --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

                <div class="px-6 py-4"
                    style="background: linear-gradient(to right, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                    <h2 class="text-xl font-bold text-white">Informasi staff</h2>
                </div>


                <div class="p-6 grid md:grid-cols-2 gap-6">


                    {{-- NAMA --}}
                    <div>
                        <p class="text-sm text-gray-400 mb-1">Nama</p>
                        <p class="font-semibold text-gray-800">
                            {{ $staff->user->name }}
                        </p>
                    </div>


                    {{-- EMAIL --}}
                    <div>
                        <p class="text-sm text-gray-400 mb-1">Email</p>
                        <p class="font-semibold text-gray-800">
                            {{ $staff->user->email }}
                        </p>
                    </div>


                    {{-- Jabatan --}}
                    <div>
                        <p class="text-sm text-gray-400 mb-1">Jabatan</p>
                        <p class="font-semibold text-gray-800">
                            {{ $staff->jabatan ?? '-' }}
                        </p>
                    </div>

                    {{-- Departemen --}}
                    <div>
                        <p class="text-sm text-gray-400 mb-1">Departemen</p>
                        <p class="font-semibold text-gray-800">
                            {{ $staff->departemen ?? '-' }}
                        </p>
                    </div>


                    {{-- Tanggal Bergabung --}}
                    <div>
                        <p class="text-sm text-gray-400 mb-1">Tanggal Bergabung</p>
                        <p class="font-semibold text-gray-800">
                            {{ $staff->tanggal_bergabung ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>


            {{-- ACTION BUTTON --}}
            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.staff.index') }}"
                    class="px-6 py-3 rounded-xl text-sm font-semibold text-gray-700 border border-gray-300 hover:bg-gray-100 transition">
                    Kembali
                </a>

                <a href="{{ route('admin.staff.edit', encrypt($staff->id)) }}"
                    class="px-6 py-3 rounded-xl text-sm font-semibold text-white shadow-md hover:shadow-lg transition"
                    style="background: linear-gradient(135deg,var(--color-accent-gradient-1),var(--color-accent-gradient-2));">

                    Edit Data

                </a>

            </div>


        </div>
    </div>

@endsection
