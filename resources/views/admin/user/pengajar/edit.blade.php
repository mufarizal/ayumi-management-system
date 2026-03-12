@extends('layouts.app')
@section('title', 'Edit Pengajar')

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
                        <h1 class="text-2xl font-bold text-gray-800">Edit Pengajar</h1>
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


            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

                <div class="px-6 py-4"
                    style="background: linear-gradient(to right, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                    <h2 class="text-xl font-bold text-white">Form Edit Pengajar</h2>
                </div>

                <div class="p-6">

                    <form action="{{ route('admin.pengajar.update', $pengajar->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6">

                        @csrf
                        @method('PUT')

                        {{-- ========================= --}}
                        {{-- DATA USER (READ ONLY) --}}
                        {{-- ========================= --}}

                        <div class="grid grid-cols-2 gap-5">

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Nama Pengajar
                                </label>

                                <input type="text" value="{{ $pengajar->user->name }}" readonly
                                    class="w-full px-4 py-3 rounded-xl text-sm border border-gray-200 bg-gray-100 cursor-not-allowed">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Email
                                </label>

                                <input type="email" value="{{ $pengajar->user->email }}" readonly
                                    class="w-full px-4 py-3 rounded-xl text-sm border border-gray-200 bg-gray-100 cursor-not-allowed">
                            </div>

                        </div>


                        {{-- SECTION --}}
                        <div class="flex items-center">
                            <h1 class="w-36 font-semibold text-gray-700">Data Pengajar</h1>
                            <div class="w-full bg-gray-200 rounded-2xl h-0.5"></div>
                        </div>


                        {{-- ========================= --}}
                        {{-- DATA PENGAJAR --}}
                        {{-- ========================= --}}

                        <div class="grid grid-cols-2 gap-5">

                            {{-- TELEPON --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Nomor Telepon
                                </label>

                                <input type="number" name="no_telp" value="{{ old('no_telp', $pengajar->no_telp) }}"
                                    class="w-full px-4 py-3 rounded-xl text-sm border border-gray-200 focus:outline-none focus:border-[#87010e]"
                                    required>
                            </div>
                            {{-- BANK --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Nama Bank
                                </label>
                                <input type="text" name="nama_bank" value="{{ old('nama_bank', $pengajar->nama_bank) }}"
                                    class="w-full px-4 py-3 rounded-xl text-sm border border-gray-200 focus:outline-none focus:border-[#87010e]"
                                    required>
                            </div>
                            {{-- REKENING --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Nomor Rekening
                                </label>

                                <input type="number" name="no_rekening"
                                    value="{{ old('no_rekening', $pengajar->no_rekening) }}"
                                    class="w-full px-4 py-3 rounded-xl text-sm border border-gray-200 focus:outline-none focus:border-[#87010e]"
                                    required>
                            </div>
                            {{-- SERTIFIKAT --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Upload Sertifikat Baru
                                </label>
                                <input type="file" name="sertifikat"
                                    class="w-full px-4 py-3 rounded-xl text-sm border border-gray-200">
                                @if ($pengajar->sertifikat)
                                    <a href="{{ Storage::url($pengajar->sertifikat) }}" target="_blank"
                                        class="text-sm text-blue-600 mt-2 inline-block">
                                        Lihat sertifikat saat ini
                                    </a>
                                @endif
                            </div>
                            {{-- ALAMAT --}}
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Alamat
                                </label>

                                <textarea name="alamat" rows="3"
                                    class="w-full px-4 py-3 rounded-xl text-sm border border-gray-200 focus:outline-none focus:border-[#87010e]">{{ old('alamat', $pengajar->alamat) }}</textarea>
                            </div>
                            {{-- STATUS --}}
                            <div class="">
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Status Aktif
                                </label>
                                {{-- value dikirim ke controller --}}
                                <input type="hidden" name="is_active" value="{{ $pengajar->is_active }}">
                                {{-- hanya untuk tampilan --}}
                                <input type="text" value="{{ $pengajar->user->is_active ? 'Aktif' : 'Non Aktif' }}" readonly
                                    class="w-full px-4 py-3 rounded-xl text-sm border border-gray-200 bg-gray-100 cursor-not-allowed">
                            </div>

                            {{-- Level Bahasa --}}
                            <div class="">
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Level Bahasa</label>
                                <select name="level_bahasa"
                                    class="w-full px-4 py-3 rounded-xl text-sm border border-gray-200 focus:outline-none focus:border-[#87010e] bg-white transition-colors">
                                    <option value="">Pilih Level Bahasa</option>
                                    <option value="N1" {{ old('level_bahasa', $pengajar->level_bahasa) == 'N1' ? 'selected' : '' }}>N1</option>
                                    <option value="N2" {{ old('level_bahasa', $pengajar->level_bahasa) == 'N2' ? 'selected' : '' }}>N2</option>
                                    <option value="N3" {{ old('level_bahasa', $pengajar->level_bahasa) == 'N3' ? 'selected' : '' }}>N3</option>
                                    <option value="N4" {{ old('level_bahasa', $pengajar->level_bahasa) == 'N4' ? 'selected' : '' }}>N4</option>
                                    <option value="N5" {{ old('level_bahasa', $pengajar->level_bahasa) == 'N5' ? 'selected' : '' }}>N5</option>
                                </select>
                            </div>
                        </div>
                        {{-- BUTTON --}}
                        <div class="flex justify-end gap-3 pt-4">
                            <a href="{{ route('admin.pengajar.index') }}"
                                class="px-6 py-3 rounded-xl text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200">
                                Batal
                            </a>
                            <button type="submit"
                                class="flex items-center gap-2 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl font-semibold"
                                style="background: linear-gradient(to right, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                                <i data-lucide="save" class="w-4 h-4"></i>
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
