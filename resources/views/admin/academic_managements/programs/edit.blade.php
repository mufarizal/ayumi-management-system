@extends('layouts.app')
@section('title', 'Edit Program')

@section('content')
    <div class="min-h-screen" style="background: linear-gradient(135deg, #fdf2f4, #f8fafc);">
        @include('components.sidebar')
        @include('components.alert')

        <div class="md:ml-64 p-4 md:p-8">

            {{-- HEADER --}}
            <div class="relative flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.program.index') }}"
                        class="flex items-center justify-center w-12 h-12 outline outline-gray-400 rounded-2xl text-gray-600 hover:text-[#87010e] hover:outline-[#87010e] transition-all duration-200">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </a>
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-0.5">Manajemen Akademik</p>
                        <h1 class="text-2xl font-bold text-gray-800 leading-tight">Edit Program</h1>
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

                {{-- Card Header --}}
                <div class="px-6 py-4"
                    style="background: linear-gradient(to right, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                    <h2 class="text-xl font-bold text-white">Edit Program</h2>
                    <span class="text-gray-200 text-sm">ID #{{ $program->id }} &nbsp;·&nbsp; Semua field bertanda * wajib
                        diisi</span>
                </div>

                <form action="{{ route('admin.program.update', $program) }}" method="POST" class="p-6 md:p-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Nama Program --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Program <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_program"
                                value="{{ old('nama_program', $program->nama_program) }}"
                                placeholder="Contoh: Kursus Bahasa Jepang N5"
                                class="w-full px-5 py-3 rounded-xl text-sm border @error('nama_program') border-red-400 bg-red-50 @else border-gray-200 @enderror focus:outline-none focus:border-[#87010e] bg-white shadow-sm transition-colors">
                            @error('nama_program')
                                <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                    <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Harga --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Harga <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute left-5 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-400 pointer-events-none">Rp</span>
                                <input type="number" name="harga" value="{{ old('harga', $program->harga) }}"
                                    placeholder="0"
                                    class="w-full pl-10 pr-5 py-3 rounded-xl text-sm border @error('harga') border-red-400 bg-red-50 @else border-gray-200 @enderror focus:outline-none focus:border-[#87010e] bg-white shadow-sm transition-colors">
                            </div>
                            @error('harga')
                                <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                    <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status"
                                class="w-full px-5 py-3 rounded-xl text-sm border @error('status') border-red-400 bg-red-50 @else border-gray-200 @enderror focus:outline-none focus:border-[#87010e] bg-white shadow-sm transition-colors">
                                <option value="">-- Pilih Status --</option>
                                <option value="aktif"
                                    {{ old('status', $program->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif"
                                    {{ old('status', $program->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status')
                                <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                    <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Deskripsi
                            </label>
                            <textarea name="deskripsi" rows="5" placeholder="Tuliskan deskripsi program (opsional)..."
                                class="w-full px-5 py-3 rounded-xl text-sm border @error('deskripsi') border-red-400 bg-red-50 @else border-gray-200 @enderror focus:outline-none focus:border-[#87010e] bg-white shadow-sm transition-colors resize-none">{{ old('deskripsi', $program->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                    <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Info kelas --}}
                        @if ($program->kelas->count() > 0)
                            <div class="md:col-span-2 rounded-xl px-5 py-3 flex items-center gap-3"
                                style="background:#f0f9ff; border:1px solid #bae6fd;">
                                <i data-lucide="info" class="w-4 h-4 text-blue-500 shrink-0"></i>
                                <p class="text-sm text-blue-700">
                                    Program ini memiliki <strong>{{ $program->kelas->count() }} kelas</strong> terdaftar.
                                    Perubahan status dapat memengaruhi kelas yang sedang berjalan.
                                </p>
                            </div>
                        @endif

                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-100">
                        <button type="submit"
                            class="group inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white text-sm font-semibold shadow-md transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5"
                            style="background: linear-gradient(135deg, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            Perbarui Program
                        </button>
                        <a href="{{ route('admin.program.index') }}"
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
