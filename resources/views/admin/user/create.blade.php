@extends('layouts.app')

{{-- Judul otomatis sesuai $role dari URL /admin/users/create/pengajar --}}
@section('title', 'Tambah ' . ucfirst($role))

@section('content')
    <div class="min-h-screen" style="background: linear-gradient(135deg, #fdf2f4, #f8fafc);">
        @include('components.sidebar')
        @include('components.alert')

        <div class="md:ml-64 p-8">

            {{-- HEADER --}}
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-[#111111] mb-2">
                    Tambah {{ ucfirst($role) }}
                </h1>
                <p class="text-gray-600">
                    Password default: <span class="font-medium text-[#87010e]">password123</span>
                    — user wajib ganti saat login pertama
                </p>
            </div>

            {{-- FORM CARD --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden ">

                <div class="px-6 py-4"
                    style="background: linear-gradient(to right, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                    <h2 class="text-xl font-bold text-white">Form Tambah {{ ucfirst($role) }}</h2>
                </div>

                <div class="p-6">
                    {{--
                    action → POST ke admin.users.store → controller store()
                    Controller store() butuh 'role' dari hidden input
                    untuk assign role ke user baru
                --}}
                    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
                        @csrf

                        {{--
                        Hidden input role — wajib ada
                        Ini yang dibaca controller store() untuk assign role
                    --}}
                        <input type="hidden" name="role" value="{{ $role }}">

                        {{-- Nama --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Nama Lengkap
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full px-4 py-3 rounded-xl text-sm border border-gray-200 focus:outline-none focus:border-[#87010e] bg-white transition-colors"
                                placeholder="Masukkan nama lengkap">
                            @error('name')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Email
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full px-4 py-3 rounded-xl text-sm border border-gray-200 focus:outline-none focus:border-[#87010e] bg-white transition-colors"
                                placeholder="Masukkan email">
                            @error('email')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tombol --}}
                        <div class="flex items-center justify-end gap-3 pt-2">
                            <a href="{{ route('admin.users.' . $role) }}"
                                class="px-6 py-3 rounded-xl text-sm font-semibold text-gray-600 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 transition-all duration-200">
                                Batal
                            </a>
                            <button type="submit"
                                class="flex items-center space-x-2 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 font-semibold"
                                style="background: linear-gradient(to right, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                                Simpan
                            </button>

                            {{--
                            Batal → balik ke list sesuai role
                            Contoh: $role = pengajar → route('admin.users.pengajar')
                        --}}
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
