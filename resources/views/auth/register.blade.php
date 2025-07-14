@extends('layouts.app')

@section('title', 'Register - University Course Management')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
    <div class="text-center mb-6">
        <i class="fas fa-user-plus text-4xl text-blue-600 mb-2"></i>
        <h2 class="text-2xl font-bold text-gray-900">Create Your Account</h2>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">Student ID</label>
            <input type="text" id="student_id" name="student_id" value="{{ old('student_id') }}" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('student_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('phone')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
            <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('date_of_birth')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
            <textarea id="address" name="address" rows="3"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('address') }}</textarea>
            @error('address')
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
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition-colors">
            Register
        </button>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600">
            Already have an account? 
            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-500">Login here</a>
        </p>
    </div>
</div>
@endsection