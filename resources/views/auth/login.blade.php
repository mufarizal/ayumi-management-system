@extends('layouts.app')
@section('content')
    @include('components.alert')
    <div class="min-h-screen flex items-center justify-center bg-[#f8f4f4] px-6">

        <div class="w-full max-w-6xl flex rounded-3xl overflow-hidden shadow-2xl">

            {{-- LEFT PANEL --}}
            <div class="hidden lg:flex w-1/2 relative overflow-hidden items-center px-16 py-20"
                style="background: linear-gradient(135deg,var(--color-accent-gradient-1),var(--color-accent-gradient-2));">

                {{-- ORBS --}}
                <div class="absolute -top-20 -left-20 w-96 h-96 rounded-full blur-[90px] opacity-40"
                    style="background:#c0132a"></div>

                <div class="absolute -bottom-20 -right-20 w-96 h-96 rounded-full blur-[90px] opacity-40"
                    style="background:#5a0009"></div>

                <div class="absolute top-1/2 left-[60%] w-56 h-56 rounded-full blur-[80px] opacity-20"
                    style="background:#ff4d6d"></div>

                <div class="relative z-10 text-white max-w-md">

                    {{-- LOGO --}}
                    <div class="flex  gap-3 mb-10">
                        <div
                            class="w-16 h-16 p-2 flex items-center justify-center rounded-xl backdrop-blur-md border border-white/30 bg-white/20">
                            <img src="/logo.png" alt="Ayumi Logo">
                        </div>

                        <div class="flex flex-col items-center ">
                            <span class="font-serif text-2xl font-semibold">
                                Ayumi Nihonggo Gakkou
                            </span>
                            {{-- TAG --}}
                            <div
                                class="inline-flex items-center gap-2 px-4 py-1 rounded-full bg-white/20 border border-white/30 backdrop-blur mb-6">
                                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                                <span class="text-xs uppercase tracking-wider">
                                    Sistem Manajemen Internal
                                </span>
                            </div>
                        </div>
                    </div>


                    {{-- HEADING --}}
                    <h1 class="text-3xl  mb-6">
                        Kelola Keuangan & Laporan <br>
                        <span class="italic text-white/70">Lebih Efisien</span>
                    </h1>

                    <p class="text-white/70 leading-relaxed mb-10">
                        Sistem manajemen Ayumi Nihonggo Gakkou membantu mengelola kelas,
                        pengajar, dan aktivitas pembelajaran dengan lebih terstruktur
                        dalam satu platform.
                    </p>

                    {{-- STATS --}}
                    <div class="flex items-center gap-8">

                        <div>
                            <p class="text-3xl font-bold">500+</p>
                            <span class="text-white/60 text-sm">Siswa Aktif</span>
                        </div>

                        <div class="w-px h-8 bg-white/20"></div>

                        <div>
                            <p class="text-3xl font-bold">30+</p>
                            <span class="text-white/60 text-sm">Kelas Berjalan</span>
                        </div>

                        <div class="w-px h-8 bg-white/20"></div>

                        <div>
                            <p class="text-3xl font-bold">10+</p>
                            <span class="text-white/60 text-sm">Pengajar</span>
                        </div>

                    </div>

                </div>
            </div>


            {{-- RIGHT PANEL --}}
            <div class="flex flex-1 items-center justify-center p-12 bg-white">

                <div class="w-full max-w-md">

                    <div class="mb-8">

                        <p class="uppercase text-xs tracking-widest mb-3" style="color:var(--color-primary)">
                            いらっしゃいませ
                        </p>

                        <h2 class="text-3xl font-bold text-gray-700 mb-2">
                            Welcome Back
                        </h2>

                        <p class="text-sm text-gray-500">
                            Silakan login untuk mengakses fitur dan data Anda.
                        </p>

                    </div>


                    <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Email
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200
                               focus:border-[#111111] focus:ring-2 focus:ring-[#111111]/20
                               transition duration-300 outline-none"
                                placeholder="Masukkan email Anda">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Password
                            </label>
                            <input type="password" name="password" required
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200
                               focus:border-[#111111] focus:ring-2 focus:ring-[#111111]/20
                               transition duration-300 outline-none"
                                placeholder="*********">
                        </div>

                        {{-- Remember + Forgot --}}
                        <div class="flex items-center justify-between text-sm">
                            <label class="flex items-center space-x-2 text-gray-600">
                                <input type="checkbox" name="remember"
                                    class="w-4 h-4 text-[#7c0000] border-gray-300 rounded
                                      focus:ring-[#7c0000] focus:ring-2">
                                <span>Ingatkan Saya</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-[#7c0000] hover:text-[#540000] font-medium transition">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>

                        <hr class="border-gray-200">

                        <button type="submit"
                            class="w-full py-3 rounded-xl font-semibold text-white
                           bg-linear-to-r from-[#7c0000] to-[#540000]
                           transition-all duration-300
                           hover:-translate-y-1 hover:shadow-xl
                           active:scale-95">
                            Masuk
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>


    <script>
        function togglePw() {

            const input = document.getElementById("password")

            input.type =
                input.type === "password" ?
                "text" :
                "password"

        }
    </script>
@endsection
