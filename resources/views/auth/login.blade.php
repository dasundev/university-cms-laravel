@extends('layouts.app')

@section('title', 'Login - University Course Management')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
    <div class="text-center mb-6">
        <i class="fas fa-sign-in-alt text-4xl text-blue-600 mb-2"></i>
        <h2 class="text-2xl font-bold text-gray-900">Login to Your Account</h2>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <input type="password" id="password" name="password" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <span class="ml-2 text-sm text-gray-600">Remember me</span>
            </label>
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition-colors">
            Login
        </button>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-500">Register here</a>
        </p>
    </div>

    <div class="mt-4 p-4 bg-gray-100 rounded-md">
        <h4 class="font-semibold text-sm text-gray-700 mb-2">Demo Accounts:</h4>
        <p class="text-xs text-gray-600 mb-1"><strong>Admin:</strong> admin@university.edu / password</p>
        <p class="text-xs text-gray-600"><strong>Student:</strong> john.doe@student.university.edu / password</p>
    </div>
</div>
@endsection