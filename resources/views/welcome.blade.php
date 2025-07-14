@extends('layouts.app')

@section('title', 'Welcome - University Course Management')

@section('content')
<div class="text-center">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <i class="fas fa-university text-6xl text-blue-900 mb-4"></i>
            <h1 class="text-5xl font-bold text-gray-900 mb-4">University Course Management System</h1>
            <p class="text-xl text-gray-600 mb-8">Streamline your academic journey with our comprehensive course management platform</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 mb-12">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <i class="fas fa-book-open text-3xl text-blue-600 mb-4"></i>
                <h3 class="text-xl font-semibold mb-2">Course Catalog</h3>
                <p class="text-gray-600">Browse and explore our comprehensive course offerings across all departments</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <i class="fas fa-user-graduate text-3xl text-green-600 mb-4"></i>
                <h3 class="text-xl font-semibold mb-2">Easy Enrollment</h3>
                <p class="text-gray-600">Register for courses with just a few clicks and manage your academic schedule</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <i class="fas fa-chart-line text-3xl text-purple-600 mb-4"></i>
                <h3 class="text-xl font-semibold mb-2">Track Progress</h3>
                <p class="text-gray-600">Monitor your academic performance and view detailed transcripts</p>
            </div>
        </div>

        @guest
        <div class="space-x-4">
            <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition-colors">
                Get Started
            </a>
            <a href="{{ route('login') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-8 rounded-lg transition-colors">
                Login
            </a>
        </div>
        @else
        <div>
            <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition-colors">
                Go to Dashboard
            </a>
        </div>
        @endguest
    </div>
</div>
@endsection