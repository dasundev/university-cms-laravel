<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'University Course Management')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-blue-900 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <i class="fas fa-graduation-cap text-2xl"></i>
                        <span class="text-xl font-bold">University CMS</span>
                    </a>
                </div>
                
                @auth
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="hover:text-blue-200 transition-colors">
                        <i class="fas fa-tachometer-alt mr-1"></i>Dashboard
                    </a>
                    <a href="{{ route('courses.index') }}" class="hover:text-blue-200 transition-colors">
                        <i class="fas fa-book mr-1"></i>Courses
                    </a>
                    @if(auth()->user()->isStudent())
                        <a href="{{ route('enrollments.index') }}" class="hover:text-blue-200 transition-colors">
                            <i class="fas fa-user-graduate mr-1"></i>My Enrollments
                        </a>
                        <a href="{{ route('results.index') }}" class="hover:text-blue-200 transition-colors">
                            <i class="fas fa-chart-line mr-1"></i>Results
                        </a>
                        <a href="{{ route('transcript') }}" class="hover:text-blue-200 transition-colors">
                            <i class="fas fa-file-alt mr-1"></i>Transcript
                        </a>
                    @endif
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('results.create') }}" class="hover:text-blue-200 transition-colors">
                            <i class="fas fa-plus mr-1"></i>Add Result
                        </a>
                    @endif
                    
                    <div class="relative group">
                        <button class="flex items-center space-x-1 hover:text-blue-200 transition-colors">
                            <i class="fas fa-user"></i>
                            <span>{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden group-hover:block">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-1"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="hover:text-blue-200 transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="bg-blue-700 hover:bg-blue-600 px-4 py-2 rounded-md transition-colors">Register</a>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <p>&copy; 2024 University Course Management System. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>