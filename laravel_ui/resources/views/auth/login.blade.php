<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background: var(--color-neo-base); min-height: 100vh; display: flex; align-items: center; justify-content: center;">
    <div class="neo-card p-8 rounded-2xl max-w-md w-full" style="margin: 1rem;">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold mb-2" style="color: var(--color-neo-text);">Sign in to your account</h2>
            <p class="text-sm" style="color: var(--color-neo-text-light);">Subscription Management System</p>
        </div>
        
        <form class="space-y-6" method="POST" action="{{ route('login') }}">
            @csrf
            
            @if($errors->any())
                <div class="neo-card p-4 rounded-xl" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3);">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li class="text-sm font-medium" style="color: var(--color-neo-error);">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="space-y-4">
                <div>
                    <label for="username" class="block text-sm font-medium mb-2" style="color: var(--color-neo-text);">Username</label>
                    <input id="username" name="username" type="text" required 
                           class="neo-input px-4 py-3 w-full" 
                           style="color: var(--color-neo-text);" 
                           placeholder="Enter your username" 
                           value="{{ old('username') }}">
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium mb-2" style="color: var(--color-neo-text);">Password</label>
                    <input id="password" name="password" type="password" required 
                           class="neo-input px-4 py-3 w-full" 
                           style="color: var(--color-neo-text);" 
                           placeholder="Enter your password">
                </div>
            </div>

            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox" 
                       class="h-4 w-4 rounded" 
                       style="accent-color: var(--color-neo-accent);">
                <label for="remember" class="ml-2 block text-sm" style="color: var(--color-neo-text);">Remember me</label>
            </div>

            <div>
                <button type="submit" class="neo-button-primary w-full py-3 px-4 text-sm font-medium">
                    Sign in
                </button>
            </div>
        </form>
    </div>
</body>
</html>

