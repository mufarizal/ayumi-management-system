@extends('layouts.app')
@section('title', 'Edit Pendaftaran')

@section('content')
    <div class="min-h-screen" style="background: linear-gradient(135deg, #fdf2f4, #f8fafc);">
        @include('components.sidebar')
        @include('components.alert')

        <div class="md:ml-64 p-4 md:p-8">

            {{-- HEADER --}}
            <div class="relative flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.pendaftaran.index') }}"
                        class="flex items-center justify-center w-12 h-12 outline outline-gray-400 rounded-2xl text-gray-600 hover:text-[#87010e] hover:outline-[#87010e] transition-all duration-200">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </a>
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-0.5">Manajemen Akademik</p>
                        <h1 class="text-2xl font-bold text-gray-800 leading-tight">Edit Pendaftaran</h1>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="text-right">
                        <p id="current-time" class="text-sm font-medium text-gray-400"></p>
                        <p id="current-date" class="text-sm font-medium text-gray-400 -mt-0.5"></p>
                    </div>
                </div>
            </div>

            <hr class="my-5 border-gray-200">

            {{-- FORM CARD --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

                <div class="px-6 py-4"
                    style="background: linear-gradient(to right, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                    <h2 class="text-xl font-bold text-white">Edit Pendaftaran</h2>
                    <span class="text-gray-200 text-sm">ID #{{ $pendaftaran->id }} &nbsp;·&nbsp; Semua field bertanda * wajib diisi</span>
                </div>

                <form action="{{ route('admin.pendaftaran.update', $pendaftaran->id) }}" method="POST" class="p-6 md:p-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Nama --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama"
                                value="{{ old('nama', $pendaftaran->nama) }}"
                                placeholder="Nama lengkap pendaftar"
                                class="w-full px-5 py-3 rounded-xl text-sm border @error('nama') border-red-400 bg-red-50 @else border-gray-200 @enderror focus:outline-none focus:border-[#87010e] bg-white shadow-sm transition-colors">
                            @error('nama')
                                <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                    <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email"
                                value="{{ old('email', $pendaftaran->email) }}"
                                placeholder="contoh@email.com"
                                class="w-full px-5 py-3 rounded-xl text-sm border @error('email') border-red-400 bg-red-50 @else border-gray-200 @enderror focus:outline-none focus:border-[#87010e] bg-white shadow-sm transition-colors">
                            @error('email')
                                <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                    <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- No Telp --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                No. Telepon <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="no_telp"
                                value="{{ old('no_telp', $pendaftaran->no_telp) }}"
                                placeholder="08xxxxxxxxxx"
                                class="w-full px-5 py-3 rounded-xl text-sm border @error('no_telp') border-red-400 bg-red-50 @else border-gray-200 @enderror focus:outline-none focus:border-[#87010e] bg-white shadow-sm transition-colors">
                            @error('no_telp')
                                <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                    <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Institusi --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Institusi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="institusi"
                                value="{{ old('institusi', $pendaftaran->institusi) }}"
                                placeholder="Asal sekolah / universitas / perusahaan"
                                class="w-full px-5 py-3 rounded-xl text-sm border @error('institusi') border-red-400 bg-red-50 @else border-gray-200 @enderror focus:outline-none focus:border-[#87010e] bg-white shadow-sm transition-colors">
                            @error('institusi')
                                <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                    <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Program --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Program <span class="text-red-500">*</span>
                            </label>
                            <select name="program_id" id="program_id"
                                class="w-full px-5 py-3 rounded-xl text-sm border @error('program_id') border-red-400 bg-red-50 @else border-gray-200 @enderror focus:outline-none focus:border-[#87010e] bg-white shadow-sm transition-colors">
                                <option value="">-- Pilih Program --</option>
                                @foreach ($programs as $program)
                                    <option value="{{ $program->id }}"
                                        {{ old('program_id', $pendaftaran->program_id) == $program->id ? 'selected' : '' }}>
                                        {{ $program->nama_program }}
                                    </option>
                                @endforeach
                            </select>
                            @error('program_id')
                                <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                    <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Kelas --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Kelas <span class="text-red-500">*</span>
                            </label>
                            <select name="kelas_id" id="kelas_id"
                                class="w-full px-5 py-3 rounded-xl text-sm border @error('kelas_id') border-red-400 bg-red-50 @else border-gray-200 @enderror focus:outline-none focus:border-[#87010e] bg-white shadow-sm transition-colors">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}" data-program="{{ $k->program_id }}"
                                        {{ old('kelas_id', $pendaftaran->kelas_id) == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kelas_id')
                                <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                    <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-100">
                        <button type="submit"
                            class="group inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white text-sm font-semibold shadow-md transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5"
                            style="background: linear-gradient(135deg, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            Perbarui Pendaftaran
                        </button>
                        <a href="{{ route('admin.pendaftaran.index') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-gray-600 text-sm font-semibold bg-gray-100 hover:bg-gray-200 transition-all duration-200">
                            <i data-lucide="x" class="w-4 h-4"></i>
                            Batal
                        </a>
                    </div>

                </form>
            </div>

        </div>
    </div>

    <script>
        (function clock() {
            const days   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
            const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
            function tick() {
                const now = new Date();
                const hh  = String(now.getHours()).padStart(2,'0');
                const mm  = String(now.getMinutes()).padStart(2,'0');
                const ss  = String(now.getSeconds()).padStart(2,'0');
                document.getElementById('current-time').textContent = `${hh}:${mm}:${ss}`;
                document.getElementById('current-date').textContent =
                    `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
            }
            tick(); setInterval(tick, 1000);
        })();

        // Filter kelas berdasarkan program
        const programSelect  = document.getElementById('program_id');
        const kelasSelect    = document.getElementById('kelas_id');
        const allKelasOptions = Array.from(kelasSelect.options);
        const savedKelas     = "{{ old('kelas_id', $pendaftaran->kelas_id) }}";

        function filterKelas(selectedProgram, restoreValue = null) {
            kelasSelect.innerHTML = '<option value="">-- Pilih Kelas --</option>';
            allKelasOptions.forEach(opt => {
                if (opt.value === '') return;
                if (!selectedProgram || opt.dataset.program === selectedProgram) {
                    kelasSelect.appendChild(opt.cloneNode(true));
                }
            });
            if (restoreValue) kelasSelect.value = restoreValue;
        }

        // Init: filter kelas sesuai program yang sudah terpilih
        filterKelas(programSelect.value, savedKelas);

        programSelect.addEventListener('change', function () {
            filterKelas(this.value);
        });

        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    </script>
@endsection