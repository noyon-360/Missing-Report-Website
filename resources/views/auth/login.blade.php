@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 sm:p-6">
    <div class="bg-darkSlate p-6 rounded-lg shadow-lg max-w-md mx-auto border border-darkBlue">
        <h1 class="text-2xl sm:text-3xl font-bold mb-4 sm:mb-6 text-center text-lightGray">
            <i class="fas fa-sign-in-alt"></i> Login
        </h1>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-lightGray font-medium mb-1">Email Address</label>
                <input type="type" id="email" name="email" value="{{ old('email') }}"
                    class="w-full px-2 py-1 border border-lightGray rounded-lg text-lightGray focus:outline-none focus:ring-2 focus:ring-lightGray">
                @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block text-lightGray font-medium mb-1">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full px-2 py-1 border border-lightGray rounded-lg text-lightGray focus:outline-none focus:ring-2 focus:ring-lightGray">
                @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <input type="checkbox" id="remember" name="remember" class="mr-1">
                    <label for="remember" class="text-lightGray">Remember Me</label>
                </div>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-lightGray hover:underline">Forgot Your
                    Password?</a>
                @endif
            </div>
            <div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">
                    Login
                </button>
            </div>
        </form>
        <div class="mt-4">
            <a href=""
                class="w-full bg-red-500 text-white py-2 rounded-lg hover:bg-red-600 flex items-center justify-center">
                <i class="fab fa-google mr-2"></i> Login with Google
            </a>
        </div>
    </div>
</div>
@endsection