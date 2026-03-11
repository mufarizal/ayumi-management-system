@extends('layouts.app')
@section('content')
    <div
        class="relative min-h-screen flex items-center justify-center
            bg-gradient-to-br from-[#eaeaea] via-[#f1f1f1] to-[#afafaf] overflow-hidden">

        {{-- Background Glow --}}
        <div class="absolute inset-0">
            <div class="absolute top-10 left-10 w-72 h-72 bg-[#3a3a3a]/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-[#9ca3af]/10 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-[#4a4a4a]/20 rounded-full blur-2xl"></div>
        </div>

        <div class="relative z-10 w-full max-w-md px-6">
            {{-- Card --}}
            <div
                class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl p-10
                    transition-all duration-500 hover:-translate-y-1">

                {{-- Logo --}}
                <div class="text-center mb-8">
                    {{-- <div
                        class="mx-auto mb-4 w-16 h-16 rounded-2xl
                            bg-linear-to-r from-[#111111] to-[#3a3a3a]
                            flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                        </svg>
                    </div> --}}

                    <h2
                        class="text-3xl font-bold
                           bg-gradient-to-r from-[#111111] to-[#3a3a3a]
                           bg-clip-text text-transparent">
                        いらっしゃいませ
                    </h2>
                    <p class="text-gray-600 text-sm mt-2">
                        Please sign in to your account
                    </p>
                </div>

                @include('components.alert')

                {{-- Form --}}
                <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Email --}}
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

                    {{-- Password --}}
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
                                class="w-4 h-4 text-[#111111] border-gray-300 rounded
                                      focus:ring-[#111111] focus:ring-2">
                            <span>Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-[#3a3a3a] hover:text-[#111111] font-medium transition">
                                Forgot Password?
                            </a>
                        @endif
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full py-3 rounded-xl font-semibold text-white
                           bg-linear-to-r from-[#7c0000] to-[#540000]
                           hover:from-black hover:to-[#111111]
                           transition-all duration-300
                           hover:-translate-y-1 hover:shadow-xl
                           active:scale-95">
                        Sign In
                    </button>
                </form>
                {{-- Footer --}}
                <div class="mt-8 text-center text-xs text-gray-400">
                    Protected by secure authentication
                </div>
            </div>


        </div>
    </div>
@endsection
