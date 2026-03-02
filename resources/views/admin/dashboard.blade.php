@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
    <div class="min-h-screen" style="background: linear-gradient(135deg, #fdf2f4, #f8fafc);">
        @include('components.sidebar')

        <div class="md:ml-64 p-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-[#111111] mb-2">
                            Dashboard Admin
                        </h1>
                        <p class="text-gray-600 text-lg">Selamat Datang 🙇🏻🙇🏻‍♀️, {{ Auth::user()->name }}!</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button
                            class="flex items-center space-x-2  text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl hover:shadow-[#111111]/25 transition-all duration-300 transform hover:-translate-y-1"
                            style="background: linear-gradient(to right, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="font-semibold">Quick Action</span>
                        </button>
                        <button
                            class="p-3 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200 hover:border-[#4a4a4a]">
                            <svg class="w-6 h-6 text-[#4a4a4a]" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Users -->
                @foreach (range(1, 4) as $i)
                    <div
                        class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-28 h-28 bg-[#3a3a3a]/5 rounded-full -mr-10 -mt-10">
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 rounded-xl flex items-center justify-center shadow-lg"
                                style="background: linear-gradient(to right, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                </svg>
                            </div>
                            <div class="text-right">
                                <p class="text-3xl font-bold text-[#111111]">{{ $i * 100 }}</p>
                                <p class="text-sm text-gray-500">+{{ $i * 12 }}% from last month</p>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">Dummy Users {{ $i }}</h3>
                        <p class="text-gray-600 text-sm">Active registered users</p>
                    </div>
                @endforeach
            </div>


            <!-- Recent Users Table -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class=" px-6 py-4"
                    style="background: linear-gradient(to right, var(--color-accent-gradient-1), var(--color-accent-gradient-2));">
                    <h2 class="text-xl font-bold text-white">Recent Users</h2>
                    <p class="text-white/70 text-sm mt-1">Latest registered users</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class=" text-white" style="background: linear-gradient(to right, #6b0f1a, #8f1d2c);">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold">#</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Name</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Email</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Department</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Joined</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-100 transition-all duration-300">
                                <td class="px-6 py-4 text-gray-900 font-medium">001</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <img src="https://ui-avatars.com/api/?name=John+Doe&background=111111&color=ffffff"
                                            alt="John Doe" class="w-10 h-10 rounded-full border-2 border-[#4a4a4a]">
                                        <span class="font-semibold text-gray-900">John Doe</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600">john.doe@company.com</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium">IT</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-3 h-3 bg-[#2afb00] rounded-full animate-pulse"></div>
                                        <span class="text-sm font-medium text-[#7cff35]">Active</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600">2 hours ago</td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
