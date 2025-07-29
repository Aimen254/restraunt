<div class="flex flex-col h-full bg-gray-800">
    <div class="flex items-center justify-center h-16 px-4 bg-gray-900 border-b border-gray-700">
        <span class="text-xl font-bold">Admin Panel</span>
    </div>
    <nav class="flex-1 px-2 py-4 space-y-1 overflow-y-auto">
        <a href="{{ route('admin.dashboard') }}" 
           class="{{ request()->routeIs('admin.dashboard') ? 'bg-gray-900' : 'hover:bg-gray-700' }} text-white group flex items-center px-3 py-3 rounded-md">
            <svg class="mr-3 h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
        </a>
        <a href="{{ route('admin.menu.index') }}" 
           class="{{ request()->routeIs('admin.menu*') ? 'bg-gray-900' : 'hover:bg-gray-700' }} text-white group flex items-center px-3 py-3 rounded-md">
            <svg class="mr-3 h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            Menu Management
        </a>
        <a href="{{ route('admin.reservations.index') }}" 
           class="{{ request()->routeIs('admin.reservations*') ? 'bg-gray-900' : 'hover:bg-gray-700' }} text-white group flex items-center px-3 py-3 rounded-md">
            <svg class="mr-3 h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Reservations
        </a>
    </nav>
</div>