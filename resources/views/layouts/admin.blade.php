<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    <style>
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }
        .content-col {
            width: calc(100% - 16rem); /* 100% - 64 (sidebar width) */
            margin-left: 16rem; /* sidebar width */
        }
        @media (max-width: 1023px) {
            .content-col {
                width: 100%;
                margin-left: 0;
            }
        }
    </style>
</head>
<body class="h-full">
    <div class="min-h-full flex" x-data="{
        sidebarOpen: window.innerWidth >= 1024,
        mobile: window.innerWidth < 1024,
        init() {
            window.addEventListener('resize', () => {
                this.mobile = window.innerWidth < 1024;
                if (!this.mobile) this.sidebarOpen = true;
            });
        }
    }">
        
        <!-- Sidebar - Fixed width (col-4 equivalent) -->
        <div class="w-64 bg-gray-800 text-white sidebar-transition fixed h-full z-30"
             :class="{
                 '-translate-x-full': mobile && !sidebarOpen, 
                 'translate-x-0': !mobile || sidebarOpen
             }">
            @include('layouts.sidebar')
        </div>

        <!-- Main content area (col-8 equivalent) -->
        <div class="content-col min-h-full flex flex-col">
            <!-- Header -->
            <header class="bg-gray-800 text-white shadow fixed top-0 left-0 right-0 h-16 z-20">
                <div class="flex items-center justify-between h-16 px-4">
                    <!-- Toggle button - visible on all screens -->
                    <button @click="sidebarOpen = !sidebarOpen" 
                            class="text-white focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  x-bind:d="sidebarOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'" />
                        </svg>
                        <span class="sr-only" x-text="sidebarOpen ? 'Close sidebar' : 'Open sidebar'"></span>
                    </button>
                    
                    <h1 class="text-xl font-semibold">@yield('header')</h1>
                    
                    <!-- Profile dropdown -->
                    <div class="relative ml-3" x-data="{ profileOpen: false }">
                        <button @click="profileOpen = !profileOpen" 
                                class="flex items-center rounded-full bg-gray-700 text-sm focus:outline-none">
                            <span class="sr-only">Open user menu</span>
                           <span class="h-8 w-8 rounded-full bg-white flex items-center justify-center text-gray-800 font-medium">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        </button>
                        <div x-show="profileOpen" 
                             @click.away="profileOpen = false" 
                             class="absolute right-0 mt-2 w-48 rounded-md bg-white py-1 shadow-lg text-gray-800">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">Your Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main content -->
            <main class="flex-1 bg-gray-50 p-6 overflow-auto">
                <div class="mx-auto max-w-7xl">
                    @yield('content')
                </div>
            </main>
        </div>

        <!-- Mobile overlay -->
        <div class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden"
             x-show="mobile && sidebarOpen"
             @click="sidebarOpen = false"
             x-transition.opacity>
        </div>
    </div>
</body>
</html>