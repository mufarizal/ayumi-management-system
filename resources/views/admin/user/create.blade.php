@extends('layouts.app')
@section('title', 'Tambah ' . ucfirst($role))

@section('content')
    <div class="min-h-screen" style="background: linear-gradient(135deg, #fdf2f4, #f8fafc);">
        @include('components.sidebar')
        @include('components.alert')

        <div class="md:ml-64 p-8">
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-[#111111] mb-2">Tambah {{ ucfirst($role) }}</h1>
                <p class="text-gray-600">
                    Password default: <span class="font-medium text-[#87010e]">password123</span>
                    — user wajib ganti saat login pertama
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="px-6 py-4"
                    style="background: linear-gradient(to right, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                    <h2 class="text-xl font-bold text-white">Form Tambah {{ ucfirst($role) }}</h2>
                </div>

                <div class="p-6">
                    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
                        @csrf

                        {{-- Nama --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full px-4 py-3 rounded-xl text-sm border border-gray-200 focus:outline-none focus:border-[#87010e] bg-white transition-colors"
                                placeholder="Masukkan nama lengkap">
                            @error('name')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full px-4 py-3 rounded-xl text-sm border border-gray-200 focus:outline-none focus:border-[#87010e] bg-white transition-colors"
                                placeholder="Masukkan email">
                            @error('email')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Roles (multi-checkbox) --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Role
                                <span class="text-gray-400 font-normal">(bisa pilih lebih dari 1)</span>
                            </label>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach ($allRoles as $r)
                                    <label
                                        class="flex items-center gap-2.5 p-3 rounded-xl border cursor-pointer transition-all duration-200
                                        {{ in_array($r->name, old('roles', [$role])) ? 'border-[#87010e] bg-red-50' : 'border-gray-200 hover:bg-gray-50' }}">
                                        <input type="checkbox" name="roles[]" value="{{ $r->name }}"
                                            {{ in_array($r->name, old('roles', [$role])) ? 'checked' : '' }}
                                            class="w-4 h-4 accent-[#87010e]"
                                            onchange="updateDefaultOptions(); highlightCard(this)">
                                        @php
                                            $icon = match ($r->name) {
                                                'admin' => 'shield-check',
                                                'pengajar' => 'graduation-cap',
                                                'staff' => 'briefcase',
                                                'siswa' => 'book-open',
                                                default => 'user',
                                            };
                                        @endphp
                                        <i data-lucide="{{ $icon }}" class="w-4 h-4 text-gray-500"></i>
                                        <span class="text-sm font-medium text-gray-700">{{ ucfirst($r->name) }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('roles')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Default Role --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Default Role
                                <span class="text-gray-400 font-normal text-xs">(halaman pertama saat login)</span>
                            </label>
                            <select name="default_role" id="default_role"
                                class="w-full px-4 py-3 rounded-xl text-sm border border-gray-200 focus:outline-none focus:border-[#87010e] bg-white transition-colors">
                                <option value="">-- Pilih default role --</option>
                                @foreach ($allRoles as $r)
                                    <option value="{{ $r->name }}"
                                        {{ old('default_role', $role) === $r->name ? 'selected' : '' }}>
                                        {{ ucfirst($r->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('default_role')
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
                                class="flex items-center gap-2 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 font-semibold"
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

    <script>
        function updateDefaultOptions() {
            const checked = [...document.querySelectorAll('input[name="roles[]"]:checked')].map(el => el.value);
            const select = document.getElementById('default_role');
            const current = select.value;

            [...select.options].forEach(opt => {
                if (opt.value === '') return;
                opt.hidden = !checked.includes(opt.value);
                opt.disabled = !checked.includes(opt.value);
            });

            if (!checked.includes(current)) select.value = '';

            // Auto-select kalau cuma 1 role yang dipilih
            if (checked.length === 1) select.value = checked[0];
        }

        function highlightCard(checkbox) {
            const label = checkbox.closest('label');
            if (checkbox.checked) {
                label.classList.add('border-[#87010e]', 'bg-red-50');
                label.classList.remove('border-gray-200');
            } else {
                label.classList.remove('border-[#87010e]', 'bg-red-50');
                label.classList.add('border-gray-200');
            }
        }

        // Inisialisasi saat halaman load
        updateDefaultOptions();
    </script>
@endsection
