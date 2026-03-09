@extends('layouts.app')
@section('content')
    @include('components.sidebar')
    <div class="ml-64 p-6">
        <h1>Dashboard {{ Auth::user()->role }}</h1>
        <h1>Welcome {{ Auth::user()->name }}</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
@endsection
