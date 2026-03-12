@extends('layouts.app')
@section('title', 'Tambah Staff')

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
                        <h1 class="text-2xl font-bold text-gray-800">Tambah Staff</h1>
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
                        <a href="{{ route('admin.staff.index') }}" class="text-gray-500 hover:text-gray-700">Staff</a>
                        <svg class="w-3 h-3 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </li>
                    <li class="flex items-center">
                        <span class="text-gray-500">Tambah Staff</span>
                    </li>
                </ol>
            </nav>

            <div class="">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4"
                        style="background: linear-gradient(to right, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                        <h2 class="text-xl font-bold text-white">Form Tambah Staff</h2>
                    </div>

                    <div class="p-6">
                        <form action="{{ route('admin.staff.store') }}" method="POST" enctype="multipart/form-data"
                            class="space-y-5">
                            @csrf

                            <div class="grid grid-cols-2 gap-5">
                                {{-- Nama --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Nama Staff
                                    </label>
                                    <select name="user_id" id="userSelect"
                                        class="w-full px-4 py-3 rounded-xl text-sm border border-gray-200 focus:outline-none focus:border-[#87010e]">
                                        <option value="" disabled selected>Pilih Staff</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" data-email="{{ $user->email }}">
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Email --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Email
                                    </label>
                                    <input type="email" id="emailField" readonly
                                        class="w-full px-4 py-3 rounded-xl text-sm border border-gray-200 bg-gray-50 cursor-not-allowed"
                                        readonly>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <h1 class="w-36  font-semibold text-gray-700">Data Staff</h1>
                                <div class="w-full bg-gray-200 rounded-2xl h-0.5"></div>
                            </div>
                            <div class="grid grid-cols-2 gap-5">
                                {{-- Jabatan --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jabatan</label>
                                    <input type="text" name="jabatan" value="{{ old('jabatan') }}" required
                                        class="w-full px-4 py-3 rounded-xl text-sm border border-gray-200 focus:outline-none focus:border-[#87010e] bg-white transition-colors"
                                        placeholder="Masukkan jabatan">
                                </div>

                                {{-- Departemen --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Departemen</label>
                                    <input type="text" name="departemen" value="{{ old('departemen') }}"
                                        class="w-full px-4 py-3 rounded-xl text-sm border border-gray-200 focus:outline-none focus:border-[#87010e] bg-white transition-colors"
                                        placeholder="Masukkan departemen" required>
                                </div>

                                {{-- Tanggal Bergabung --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Bergabung</label>
                                    <input type="date" name="tgl_bergabung" value="{{ old('tgl_bergabung') }}"
                                        class="w-full px-4 py-3 rounded-xl text-sm border border-gray-200 focus:outline-none focus:border-[#87010e] bg-white transition-colors"
                                        placeholder="Masukkan tanggal bergabung" required>
                                </div>

                                {{-- Is Active --}}
                                <div class="">
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>
                                    <select name="is_active"
                                        class="w-full px-4 py-3 rounded-xl text-sm border border-gray-200 focus:outline-none focus:border-[#87010e] bg-white transition-colors">
                                        <option value="1" {{ old('is_active') == 1 ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Non-Aktif
                                        </option>
                                    </select>
                                </div>

                            </div>

                            <div>
                                {{-- Tombol --}}
                                <div class="flex items-center justify-end gap-3 pt-2">
                                    <a href="{{ route('admin.pengajar.index') }}"
                                        class="px-6 py-3 rounded-xl text-sm font-semibold text-gray-600 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 transition-all duration-200">
                                        Batal
                                    </a>
                                    <button type="submit"
                                        class="flex items-center gap-2 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 font-semibold"
                                        style="background: linear-gradient(to right, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                                        <i data-lucide="save" class="w-4 h-4"></i>
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const userSelect = document.getElementById("userSelect")
        const emailField = document.getElementById("emailField")
        userSelect.addEventListener("change", function() {
            const selectedOption = this.options[this.selectedIndex]
            const email = selectedOption.getAttribute("data-email")
            emailField.value = email ?? ""
        })
    })
</script>
