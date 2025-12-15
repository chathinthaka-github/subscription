<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background: var(--color-neo-base); min-height: 100vh;" class="font-sans">
    <nav class="neo-nav sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="{{ route('dashboard') }}" class="text-2xl font-bold" style="color: var(--color-neo-text);">Subscription Manager</a>
                    </div>
                    <div class="hidden sm:ml-8 sm:flex sm:space-x-4">
                        <a href="{{ route('dashboard') }}" class="neo-button px-4 py-2 text-sm font-medium inline-flex items-center" style="color: var(--color-neo-text);">Dashboard</a>
                        @can('service.view')
                        <a href="{{ route('shortcodes.index') }}" class="neo-button px-4 py-2 text-sm font-medium inline-flex items-center" style="color: var(--color-neo-text);">Shortcodes</a>
                        <a href="{{ route('services.index') }}" class="neo-button px-4 py-2 text-sm font-medium inline-flex items-center" style="color: var(--color-neo-text);">Services</a>
                        @endcan
                        @can('service_message.view')
                        <a href="{{ route('service-messages.index') }}" class="neo-button px-4 py-2 text-sm font-medium inline-flex items-center" style="color: var(--color-neo-text);">Messages</a>
                        @endcan
                        @can('renewal_plan.view')
                        <a href="{{ route('renewal-plans.index') }}" class="neo-button px-4 py-2 text-sm font-medium inline-flex items-center" style="color: var(--color-neo-text);">Plans</a>
                        @endcan
                        @can('reports.view')
                        <a href="{{ route('reports.index') }}" class="neo-button px-4 py-2 text-sm font-medium inline-flex items-center" style="color: var(--color-neo-text);">Reports</a>
                        @endcan
                        @can('admin.view')
                        <div class="relative group">
                            <button type="button" class="neo-button px-4 py-2 text-sm font-medium inline-flex items-center" style="color: var(--color-neo-text);">
                                Admin
                                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="absolute left-0 top-full mt-2 w-48 neo-card opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 p-2">
                                <a href="{{ route('admin.users.index') }}" class="block px-4 py-3 text-sm rounded-lg transition-all duration-200" style="color: var(--color-neo-text);" onmouseover="this.style.background='rgba(163, 163, 163, 0.1)'" onmouseout="this.style.background='transparent'">Users</a>
                                <a href="{{ route('admin.roles.index') }}" class="block px-4 py-3 text-sm rounded-lg transition-all duration-200" style="color: var(--color-neo-text);" onmouseover="this.style.background='rgba(163, 163, 163, 0.1)'" onmouseout="this.style.background='transparent'">Roles</a>
                                <a href="{{ route('admin.permissions.index') }}" class="block px-4 py-3 text-sm rounded-lg transition-all duration-200" style="color: var(--color-neo-text);" onmouseover="this.style.background='rgba(163, 163, 163, 0.1)'" onmouseout="this.style.background='transparent'">Permissions</a>
                            </div>
                        </div>
                        @endcan
                    </div>
                </div>
                <div class="flex items-center">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="neo-button px-4 py-2 text-sm font-medium" style="color: var(--color-neo-text); font-weight: 500;">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            @if(session('success'))
                <div class="mb-6 neo-card p-4 rounded-xl" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3);">
                    <p class="text-sm font-medium" style="color: var(--color-neo-success);">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 neo-card p-4 rounded-xl" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3);">
                    <p class="text-sm font-medium" style="color: var(--color-neo-error);">{{ session('error') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 neo-card p-4 rounded-xl" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3);">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li class="text-sm font-medium" style="color: var(--color-neo-error);">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</body>
</html>

