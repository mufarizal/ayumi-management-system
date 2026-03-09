@extends('layouts.app')

{{-- Judul otomatis sesuai $role dari controller edit() --}}
@section('title', 'Edit ' . ucfirst($role))

@section('content')
    <div class="min-h-screen" style="background: linear-gradient(135deg, #fdf2f4, #f8fafc);">
        @include('components.sidebar')
        @include('components.alert')
        <div class="md:ml-64 p-8">

            {{-- HEADER --}}
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-[#111111] mb-2">
                    Edit {{ ucfirst($role) }}
                </h1>
                <p class="text-gray-600">Perubahan akan langsung tersimpan ke database</p>
            </div>

            {{-- FORM CARD --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

                <div class="px-6 py-4"
                    style="background: linear-gradient(to right, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                    <h2 class="text-xl font-bold text-white">Form Edit {{ ucfirst($role) }}</h2>
                </div>

                <div class="p-6">
                    {{--
                    action → PUT ke admin.users.update dengan $user
                    @method('PUT') karena HTML form tidak support PUT
                --}}
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        {{--
                        Hidden role — dibaca controller update()
                        untuk redirect ke halaman list role yang sesuai setelah update
                    --}}
                        <input type="hidden" name="role" value="{{ $role }}">

                        {{-- Nama --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Nama Lengkap
                            </label>
                            {{--
                            old('name', $user->name)
                            → kalau ada error validasi, pakai nilai yang tadi diketik
                            → kalau tidak ada error, pakai nilai dari database
                        --}}
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="w-full px-4 py-3 rounded-xl text-sm border border-gray-200 focus:outline-none focus:border-[#87010e] bg-white transition-colors">
                            @error('name')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Email
                            </label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="w-full px-4 py-3 rounded-xl text-sm border border-gray-200 focus:outline-none focus:border-[#87010e] bg-white transition-colors">
                            @error('email')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Status aktif --}}
                        <div class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 border border-gray-200">
                            <input type="checkbox" name="is_active" id="is_active" {{ $user->is_active ? 'checked' : '' }}
                                class="w-4 h-4 rounded accent-[#87010e] cursor-pointer">
                            <label for="is_active" class="text-sm font-medium text-gray-700 cursor-pointer">
                                User aktif
                            </label>
                        </div>

                        {{-- Tombol --}}
                        <div class="flex items-center gap-3 pt-2">
                            <button type="submit"
                                class="flex items-center space-x-2 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 font-semibold"
                                style="background: linear-gradient(to right, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                                Update
                            </button>

                            {{-- Batal → balik ke list sesuai role --}}
                            <a href="{{ route('admin.users.' . $role) }}"
                                class="px-6 py-3 rounded-xl text-sm font-semibold text-gray-600 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 transition-all duration-200">
                                Batal
                            </a>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
